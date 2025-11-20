<?php

namespace App\Http\Controllers\driverPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\Mailler;

class dashboardController extends Controller
{
    function index()
    {
        $driverId = session('driverInfo')->id;

        // Tüm yarış sonuçlarını al
        $raceResults = DB::table('f1_race_results')
            ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->join('f1_leagues', 'f1_race_results.league_id', '=', 'f1_leagues.id')
            ->leftJoin('f1_league_drivers', function ($join) use ($driverId) {
                $join->where('f1_league_drivers.driver_id', '=', $driverId)
                    ->on('f1_league_drivers.league_id', '=', 'f1_race_results.league_id');
            })
            ->leftJoin('f1_teams', 'f1_league_drivers.team_id', '=', 'f1_teams.id')
            ->where('f1_race_results.driver_id', $driverId)
            ->where('f1_race_results.r_ranking', '>', 0) // Sadece tamamlanmış yarışlar
            ->select(
                'f1_race_results.*',
                'f1_tracks.name as track_name',
                'f1_leagues.name as league_name',
                'f1_leagues.id as league_id',
                'f1_leagues.status as league_status',
                'f1_league_tracks.race_date',
                'f1_league_tracks.sprint_status',
                'f1_teams.name as team_name',
                'f1_teams.short_name as team_short_name'
            )
            ->orderBy('f1_league_tracks.race_date', 'desc')
            ->get();

        // Genel İstatistikler - String + int hatasını düzelt
        $totalRaces = $raceResults->count();
        $totalPoints = $raceResults->sum(function ($result) {
            return (int)($result->points ?? 0) + (int)($result->s_point ?? 0);
        });
        $wins = $raceResults->where('r_ranking', 1)->count();
        $podiums = $raceResults->where('r_ranking', '<=', 3)->where('r_ranking', '>', 0)->count();
        $polePositions = $raceResults->where('q_ranking', 1)->count();
        $fastestLaps = $raceResults->where('fastest_lap', 1)->count();

        // Şampiyonluk sayısını hesapla (status = 2 olan bitmiş liglerde en yüksek puan)
        $championships = 0;
        $finishedLeagues = DB::table('f1_leagues')
            ->where('status', 2)
            ->pluck('id');

        foreach ($finishedLeagues as $leagueId) {
            // Bu ligdeki tüm pilotların puanlarını hesapla
            $leagueDriverPoints = DB::table('f1_race_results')
                ->where('league_id', $leagueId)
                ->where('r_ranking', '>', 0)
                ->select('driver_id', DB::raw('SUM(COALESCE(CAST(points AS UNSIGNED), 0) + COALESCE(CAST(s_point AS UNSIGNED), 0)) as total_points'))
                ->groupBy('driver_id')
                ->orderByDesc('total_points')
                ->get();

            if ($leagueDriverPoints->isNotEmpty()) {
                $maxPoints = $leagueDriverPoints->first()->total_points;
                // En yüksek puanlı pilotları bul (beraberlik durumu için)
                $champions = $leagueDriverPoints->where('total_points', $maxPoints)->pluck('driver_id');
                
                // Eğer mevcut pilot şampiyonlardan biri ise
                if ($champions->contains($driverId)) {
                    $championships++;
                }
            }
        }

        // Sıralama istatistikleri
        $raceRankings = $raceResults->pluck('r_ranking')->filter(function ($rank) {
            return $rank > 0;
        });
        $qualifyingRankings = $raceResults->pluck('q_ranking')->filter(function ($rank) {
            return $rank > 0;
        });

        $bestRacePosition = $raceRankings->isNotEmpty() ? $raceRankings->min() : null;
        $worstRacePosition = $raceRankings->isNotEmpty() ? $raceRankings->max() : null;
        $avgRacePosition = $raceRankings->isNotEmpty() ? round($raceRankings->avg(), 2) : null;

        $bestQualifyingPosition = $qualifyingRankings->isNotEmpty() ? $qualifyingRankings->min() : null;
        $worstQualifyingPosition = $qualifyingRankings->isNotEmpty() ? $qualifyingRankings->max() : null;
        $avgQualifyingPosition = $qualifyingRankings->isNotEmpty() ? round($qualifyingRankings->avg(), 2) : null;

        // Yeni İstatistikler
        $top5Finishes = $raceResults->where('r_ranking', '<=', 5)->where('r_ranking', '>', 0)->count();
        $top10Finishes = $raceResults->where('r_ranking', '<=', 10)->where('r_ranking', '>', 0)->count();
        
        // Sıra kazanma/kaybetme (qualifying'den yarışa)
        $positionsGained = $raceResults->filter(function($result) {
            $qRank = (int)($result->q_ranking ?? 0);
            $rRank = (int)($result->r_ranking ?? 0);
            return $qRank > 0 && $rRank > 0 && $qRank > $rRank;
        })->sum(function($result) {
            return (int)$result->q_ranking - (int)$result->r_ranking;
        });
        
        $positionsLost = $raceResults->filter(function($result) {
            $qRank = (int)($result->q_ranking ?? 0);
            $rRank = (int)($result->r_ranking ?? 0);
            return $qRank > 0 && $rRank > 0 && $qRank < $rRank;
        })->sum(function($result) {
            return (int)$result->r_ranking - (int)$result->q_ranking;
        });
        
        // DNF sayısı
        $dnfCount = DB::table('f1_race_results')
            ->where('driver_id', $driverId)
            ->where(function($query) {
                $query->where('r_ranking', 0)
                      ->orWhereNull('r_ranking');
            })
            ->count();
        
        // Tutarlılık (standart sapma) - en az 5 yarış
        $consistency = null;
        if ($raceRankings->count() >= 5) {
            $avg = $raceRankings->avg();
            $variance = $raceRankings->sum(function($r) use ($avg) {
                return pow($r - $avg, 2);
            }) / $raceRankings->count();
            $stdDev = sqrt($variance);
            $consistency = round($stdDev, 2);
        }
        
        // Ortalama puan (yarış başına)
        $avgPointsPerRace = $totalRaces > 0 ? round($totalPoints / $totalRaces, 2) : 0;

        // Lig bazında istatistikler
        $leagueStats = [];
        foreach ($raceResults->groupBy('league_id') as $leagueId => $leagueResults) {
            $leagueName = $leagueResults->first()->league_name;
            $leagueTotalRaces = $leagueResults->count();
            $leagueTotalPoints = $leagueResults->sum(function ($result) {
                return (int)($result->points ?? 0) + (int)($result->s_point ?? 0);
            });
            $leagueWins = $leagueResults->where('r_ranking', 1)->count();
            $leaguePodiums = $leagueResults->where('r_ranking', '<=', 3)->where('r_ranking', '>', 0)->count();
            $leaguePoles = $leagueResults->where('q_ranking', 1)->count();
            $leagueFastestLaps = $leagueResults->where('fastest_lap', 1)->count();

            $leagueRaceRankings = $leagueResults->pluck('r_ranking')->filter(function ($rank) {
                return $rank > 0;
            });
            $leagueAvgPosition = $leagueRaceRankings->isNotEmpty() ? round($leagueRaceRankings->avg(), 2) : null;

            $leagueStats[] = [
                'league_id' => $leagueId,
                'league_name' => $leagueName,
                'total_races' => $leagueTotalRaces,
                'total_points' => $leagueTotalPoints,
                'wins' => $leagueWins,
                'podiums' => $leaguePodiums,
                'pole_positions' => $leaguePoles,
                'fastest_laps' => $leagueFastestLaps,
                'avg_position' => $leagueAvgPosition,
            ];
        }

        // En son 10 yarış
        $recentRaces = $raceResults->take(10);

        return view('driverPanel.dashboard', compact(
            'totalRaces',
            'totalPoints',
            'wins',
            'podiums',
            'polePositions',
            'fastestLaps',
            'championships',
            'bestRacePosition',
            'worstRacePosition',
            'avgRacePosition',
            'bestQualifyingPosition',
            'worstQualifyingPosition',
            'avgQualifyingPosition',
            'top5Finishes',
            'top10Finishes',
            'positionsGained',
            'positionsLost',
            'dnfCount',
            'consistency',
            'avgPointsPerRace',
            'leagueStats',
            'recentRaces'
        ));
    }
}
