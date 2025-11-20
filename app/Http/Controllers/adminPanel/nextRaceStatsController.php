<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class nextRaceStatsController extends Controller
{
    public function index()
    {
        // Önümüzdeki ilk yarışı bul
        $nextRace = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->join('f1_leagues', 'f1_league_tracks.league_id', '=', 'f1_leagues.id')
            ->where('f1_league_tracks.race_date', '>', now())
            ->where('f1_leagues.status', 1)
            ->select(
                'f1_league_tracks.id as league_track_id',
                'f1_league_tracks.league_id',
                'f1_league_tracks.track_id',
                'f1_league_tracks.race_date',
                'f1_league_tracks.sprint_status',
                'f1_tracks.name as track_name',
                'f1_leagues.name as league_name'
            )
            ->orderBy('f1_league_tracks.race_date', 'asc')
            ->first();

        if (!$nextRace) {
            return view('adminPanel.nextRaceStats', [
                'nextRace' => null,
                'driverMilestones' => collect()
            ]);
        }

        // Bu yarışa katılacak pilotları bul
        $leagueDrivers = DB::table('f1_league_drivers')
            ->join('drivers', 'f1_league_drivers.driver_id', '=', 'drivers.id')
            ->leftJoin('f1_teams', 'f1_league_drivers.team_id', '=', 'f1_teams.id')
            ->where('f1_league_drivers.league_id', $nextRace->league_id)
            ->select(
                'drivers.id as driver_id',
                'drivers.name',
                'drivers.surname',
                'f1_teams.name as team_name'
            )
            ->get();

        $driverMilestones = collect();

        foreach ($leagueDrivers as $driver) {
            // Tüm yarış sonuçlarını al
            $allRaceResults = DB::table('f1_race_results')
                ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
                ->where('f1_race_results.driver_id', $driver->driver_id)
                ->where('f1_race_results.r_ranking', '>', 0) // Tamamlanmış yarışlar
                ->orderBy('f1_league_tracks.race_date', 'asc')
                ->select('f1_race_results.*', 'f1_league_tracks.race_date')
                ->get();
            
            // Bu yarıştan önceki yarışlar (tarih karşılaştırması için)
            $nextRaceDate = $nextRace->race_date;
            $previousRaces = $allRaceResults->filter(function($result) use ($nextRaceDate) {
                return strtotime($result->race_date) < strtotime($nextRaceDate);
            });
            
            $totalRaces = $previousRaces->count();
            $poles = $previousRaces->filter(function($result) { return $result->q_ranking == 1; })->count();
            $wins = $previousRaces->filter(function($result) { return $result->r_ranking == 1; })->count();
            $podiums = $previousRaces->filter(function($result) { return $result->r_ranking > 0 && $result->r_ranking <= 3; })->count();
            $fastestLaps = $previousRaces->filter(function($result) { return $result->fastest_lap == 1; })->count();
            $totalPoints = $previousRaces->sum(function($result) {
                return (int)($result->points ?? 0) + (int)($result->s_point ?? 0);
            });

            // Milestone'ları hesapla
            $milestones = [];
            
            // Yarış milestone'ları (50, 100, 150, 200, 250, vb.)
            $raceMilestones = [50, 100, 150, 200, 250, 300];
            foreach ($raceMilestones as $milestone) {
                if ($totalRaces + 1 == $milestone) {
                    $milestones[] = [
                        'type' => 'race',
                        'text' => __('common.milestone_race', ['name' => $driver->name, 'surname' => $driver->surname, 'count' => $milestone]),
                        'icon' => 'fa-flag-checkered',
                        'color' => 'blue'
                    ];
                }
            }

            // Pol milestone'ları (5, 10, 15, 20, 25, 30, vb.)
            $poleMilestones = [5, 10, 15, 20, 25, 30, 50];
            foreach ($poleMilestones as $milestone) {
                if ($poles + 1 == $milestone) {
                    $milestones[] = [
                        'type' => 'pole',
                        'text' => __('common.milestone_pole', ['name' => $driver->name, 'surname' => $driver->surname, 'count' => $milestone]),
                        'icon' => 'fa-flag',
                        'color' => 'orange'
                    ];
                }
            }

            // Kazanma milestone'ları (5, 10, 15, 20, 25, 30, 50, vb.)
            $winMilestones = [5, 10, 15, 20, 25, 30, 50];
            foreach ($winMilestones as $milestone) {
                if ($wins + 1 == $milestone) {
                    $milestones[] = [
                        'type' => 'win',
                        'text' => __('common.milestone_win', ['name' => $driver->name, 'surname' => $driver->surname, 'count' => $milestone]),
                        'icon' => 'fa-trophy',
                        'color' => 'gold'
                    ];
                }
            }

            // Podyum milestone'ları (10, 25, 50, 75, 100, vb.)
            $podiumMilestones = [10, 25, 50, 75, 100];
            foreach ($podiumMilestones as $milestone) {
                if ($podiums + 1 == $milestone) {
                    $milestones[] = [
                        'type' => 'podium',
                        'text' => __('common.milestone_podium', ['name' => $driver->name, 'surname' => $driver->surname, 'count' => $milestone]),
                        'icon' => 'fa-medal',
                        'color' => 'purple'
                    ];
                }
            }

            // En hızlı tur milestone'ları (5, 10, 15, 20, 25, vb.)
            $fastestLapMilestones = [5, 10, 15, 20, 25, 50];
            foreach ($fastestLapMilestones as $milestone) {
                if ($fastestLaps + 1 == $milestone) {
                    $milestones[] = [
                        'type' => 'fastest_lap',
                        'text' => __('common.milestone_fastest_lap', ['name' => $driver->name, 'surname' => $driver->surname, 'count' => $milestone]),
                        'icon' => 'fa-tachometer-alt',
                        'color' => 'red'
                    ];
                }
            }

            // Puan milestone'ları (100, 250, 500, 1000, 1500, 2000, vb.)
            $pointsMilestones = [100, 250, 500, 1000, 1500, 2000, 2500, 3000];
            foreach ($pointsMilestones as $milestone) {
                $currentPoints = $totalPoints;
                // Bu yarışta alabileceği maksimum puanı tahmin et (genelde 25-26 puan)
                $estimatedMaxPoints = 26;
                if ($currentPoints < $milestone && ($currentPoints + $estimatedMaxPoints) >= $milestone) {
                    $milestones[] = [
                        'type' => 'points',
                        'text' => __('common.milestone_points', ['name' => $driver->name, 'surname' => $driver->surname, 'count' => $milestone]),
                        'icon' => 'fa-chart-line',
                        'color' => 'green'
                    ];
                }
            }

            if (count($milestones) > 0) {
                $driverMilestones->push([
                    'driver' => $driver,
                    'stats' => [
                        'total_races' => $totalRaces,
                        'poles' => $poles,
                        'wins' => $wins,
                        'podiums' => $podiums,
                        'fastest_laps' => $fastestLaps,
                        'total_points' => $totalPoints
                    ],
                    'milestones' => $milestones
                ]);
            }
        }

        return view('adminPanel.nextRaceStats', compact('nextRace', 'driverMilestones'));
    }
}

