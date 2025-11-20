<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class driverController extends Controller
{
    public function show($driverSlug)
    {
        // Slug'dan ID'yi çıkar (örn: baris-yildirim-1004 -> 1004)
        $parts = explode('-', $driverSlug);
        $driverId = end($parts);
        
        // Pilot bilgilerini al
        $driver = DB::table('drivers')
            ->where('drivers.id', $driverId)
            ->first();

        if (!$driver) {
            abort(404);
        }

        // En son aktif ligdeki takım bilgisini al
        $activeLeague = DB::table('f1_leagues')
            ->where('status', 1)
            ->orderBy('point_rate', 'ASC')
            ->first();

        $teamInfo = null;
        if ($activeLeague) {
            $leagueDriver = DB::table('f1_league_drivers')
                ->leftJoin('f1_teams', 'f1_league_drivers.team_id', '=', 'f1_teams.id')
                ->select(
                    'f1_league_drivers.team_id',
                    'f1_teams.name as team_name',
                    'f1_teams.short_name as team_short_name'
                )
                ->where('f1_league_drivers.driver_id', $driverId)
                ->where('f1_league_drivers.league_id', $activeLeague->id)
                ->first();

            if ($leagueDriver) {
                $teamInfo = [
                    'team_id' => $leagueDriver->team_id,
                    'team_name' => $leagueDriver->team_name,
                    'team_short_name' => $leagueDriver->team_short_name
                ];
            }
        }

        // Takım bilgisini driver objesine ekle
        $driver->team_id = $teamInfo ? $teamInfo['team_id'] : null;
        $driver->team_name = $teamInfo ? $teamInfo['team_name'] : null;
        $driver->team_short_name = $teamInfo ? $teamInfo['team_short_name'] : null;

        // Pilot istatistiklerini al
        $raceResults = DB::table('f1_race_results')
            ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->join('f1_leagues', 'f1_race_results.league_id', '=', 'f1_leagues.id')
            ->select(
                'f1_race_results.*',
                'f1_tracks.name as track_name',
                'f1_leagues.name as league_name',
                'f1_leagues.link as league_link',
                'f1_league_tracks.race_date'
            )
            ->where('f1_race_results.driver_id', $driverId)
            ->orderBy('f1_league_tracks.race_date', 'DESC')
            ->get();

        // İstatistikleri hesapla
        $totalPoints = 0;
        foreach ($raceResults as $race) {
            $totalPoints += (int)($race->points ?? 0) + (int)($race->s_point ?? 0);
        }

        // Ortalama pozisyon hesapla
        $validRankings = $raceResults->where('r_ranking', '>', 0)->pluck('r_ranking');
        $avgPosition = '-';
        if ($validRankings->count() > 0) {
            $sum = 0;
            foreach ($validRankings as $ranking) {
                $sum += (int)$ranking;
            }
            $avgPosition = round($sum / $validRankings->count(), 1);
        }

        $stats = [
            'total_races' => $raceResults->count(),
            'total_points' => $totalPoints,
            'wins' => $raceResults->where('r_ranking', 1)->count(),
            'podiums' => $raceResults->whereIn('r_ranking', [1, 2, 3])->count(),
            'pole_positions' => $raceResults->where('q_ranking', 1)->count(),
            'fastest_laps' => $raceResults->where('fastest_lap', 1)->count(),
            'best_position' => $raceResults->where('r_ranking', '>', 0)->min('r_ranking') ?? '-',
            'avg_position' => $avgPosition,
        ];

        // En iyi sonuçlar
        $bestResults = $raceResults->where('r_ranking', '>', 0)
            ->sortBy('r_ranking')
            ->take(5);

        // Son yarışlar
        $recentRaces = $raceResults->take(10);

        return view('drivers.show', compact('driver', 'stats', 'bestResults', 'recentRaces'));
    }
}
