<?php

namespace App\Http\Controllers\f1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class leagueController extends Controller
{
    public function getLeagueID($link)
    {
        $leagueID = DB::table('f1_leagues')->select('id')->where('link', $link)->first()->id;
        return $leagueID;
    }

    public function pointTable($link)
    {
        $leagueID = self::getLeagueID($link);

        // **Ligdeki pistleri al**
        $tracks = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', 'f1_tracks.id')
            ->select('f1_league_tracks.id as f1_league_track_id', 'f1_league_tracks.sprint_status', 'f1_tracks.name as track_name')
            ->where('f1_league_tracks.league_id', $leagueID)
            ->orderBy('race_date')
            ->get();

        // **Ligdeki pilotları al**
        $drivers = DB::table('f1_league_drivers')
            ->join('drivers', 'f1_league_drivers.driver_id', 'drivers.id')
            ->select('drivers.id', 'drivers.name', 'drivers.surname', 'f1_league_drivers.team_id')
            ->where('f1_league_drivers.league_id', $leagueID)
            ->get()->keyBy('id')->toArray();

        // **Pilotların puanlarını al**
        $standings = DB::table('f1_race_results')
            ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
            ->leftJoin('f1_league_drivers', function ($join) use ($leagueID) {
                $join->on('f1_race_results.driver_id', '=', 'f1_league_drivers.driver_id')
                    ->where('f1_league_drivers.league_id', '=', $leagueID);
            })
            ->leftJoin('f1_teams', 'f1_league_drivers.team_id', '=', 'f1_teams.id')
            ->select(
                'drivers.id',
                'drivers.name',
                'drivers.surname',
                'f1_teams.name as team_name',
                'f1_teams.short_name as team_short_name',
                'f1_race_results.f1_league_track_id',
                'f1_race_results.r_ranking',
                DB::raw('SUM(COALESCE(CAST(f1_race_results.points AS UNSIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS UNSIGNED), 0)) as total_points')
            )
            ->where('f1_race_results.league_id', $leagueID)
            ->groupBy(
                'drivers.id',
                'drivers.name',
                'drivers.surname',
                'f1_teams.name',
                'f1_teams.short_name',
                'f1_race_results.f1_league_track_id',
                'f1_race_results.r_ranking'
            )
            ->get();

        // **Pilot puanlarını ayarla**
        $driverStandings = [];
        foreach ($drivers as $driverID => $driver) {
            $totalPoints = $standings->where('id', $driverID)->sum('total_points') ?? 0;

            $trackPoints = [];
            foreach ($tracks as $track) {
                $trackPoints[$track->f1_league_track_id] = [
                    'point' => $standings->where('id', $driverID)->where('f1_league_track_id', $track->f1_league_track_id)->sum('total_points') ?? 0,
                    'rank' => $standings->where('id', $driverID)->where('f1_league_track_id', $track->f1_league_track_id)->first()?->r_ranking ?? null,                ];
            }

            $driverStandings[] = [
                'driver' => $driver,
                'total_points' => $totalPoints,
                'track_points' => $trackPoints,
            ];
        }

        // **Sıralama büyükten küçüğe**
        usort($driverStandings, fn($a, $b) => $b['total_points'] <=> $a['total_points']);

        // **Takım puanlarını hesapla**
        $teamStandings = [];

        foreach ($drivers as $driverID => $driver) {
            $teamID = $driver->team_id;
            $teamName = DB::table('f1_teams')->where('id', $teamID)->value('name');

            $totalPoints = $standings->where('id', $driverID)->sum('total_points') ?? 0;

            foreach ($tracks as $track) {
                $trackPoints = $standings->where('id', $driverID)->where('f1_league_track_id', $track->f1_league_track_id)->sum('total_points') ?? 0;

                if (!isset($teamStandings[$teamID])) {
                    $teamStandings[$teamID] = [
                        'team_name' => $teamName,
                        'total_points' => 0,
                        'track_points' => []
                    ];
                }

                $teamStandings[$teamID]['track_points'][$track->f1_league_track_id] = ($teamStandings[$teamID]['track_points'][$track->f1_league_track_id] ?? 0) + $trackPoints;
            }

            $teamStandings[$teamID]['total_points'] += $totalPoints;
        }

        $teamStandings = collect($teamStandings)->sortByDesc('total_points');

        return view('f1leagues.point_table', compact(
            'link',
            'tracks',
            'driverStandings',
            'teamStandings',
            'leagueID'
        ));
    }

    public function results($link, $trackID = null)
    {
        $leagueID = self::getLeagueID($link);

        // Pist listesi (Sprint bilgisi dahil)
        $tracks = DB::table('f1_tracks')
            ->join('f1_league_tracks', 'f1_tracks.id', '=', 'f1_league_tracks.track_id')
            ->where('f1_league_tracks.league_id', $leagueID)
            ->select('f1_league_tracks.id as f1_league_track_id', 'f1_tracks.name', 'f1_league_tracks.sprint_status')
            ->distinct()
            ->get();

        // Eğer trackID gönderilmediyse en son pistin trackID’sini al
        if (!$trackID) {
            $latestTrack = DB::table('f1_league_tracks')
                ->where('league_id', $leagueID)
                ->orderBy('race_date', 'desc')
                ->first();

            if ($latestTrack) {
                $trackID = $latestTrack->id;
            }
        }

        // Yarış sonuçlarını pist bilgileriyle birlikte çek
        $query = DB::table('f1_race_results')
            ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
            ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->where('f1_race_results.league_id', $leagueID)
            ->select(
                'f1_race_results.*',
                'drivers.name as driver_name',
                'drivers.surname as driver_surname',
                'f1_league_tracks.id as f1_league_track_id',
                'f1_tracks.name as track_name',
                'f1_league_tracks.race_date',
                'f1_league_tracks.sprint_status'
            )
            ->orderByRaw('CASE WHEN f1_race_results.r_ranking = 0 THEN 1 ELSE 0 END, CAST(f1_race_results.r_ranking AS UNSIGNED) ASC');

        // Pist ID varsa filtre uygula
        if ($trackID) {
            $query->where('f1_race_results.f1_league_track_id', $trackID);
        }

        $raceResults = $query->get();

        return view('f1leagues.results', compact(
            'leagueID',
            'raceResults',
            'link',
            'trackID',
            'tracks'
        ));
    }

    function refDecisions($link)
    {
        return view('f1leagues.ref_decisions', compact('link'));
    }
    function liveBroadcasts($link)
    {
        return view('f1leagues.live_broadcasts', compact('link'));
    }
    function schedule($link)
    {
        return view('f1leagues.schedule', compact('link'));
    }
}
