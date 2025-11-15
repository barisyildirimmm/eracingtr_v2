<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    function index()
    {

        $instagramPosts = DB::table('posts_instagram')->orderBy('timestamp', 'DESC')->get()->take(16);
        $youtubePosts = DB::table('posts_youtube')->get()->take(5);

        $nextRace = DB::table('f1_league_tracks')
            ->select('race_date', 'f1_leagues.name')
            ->join('f1_tracks', 'f1_league_tracks.track_id', 'f1_tracks.id')
            ->join('f1_leagues', 'f1_league_tracks.league_id', 'f1_leagues.id')
            ->where('race_date', '>', date('Y-m-d H:i:s'))
            ->where('f1_leagues.status', 1)
            ->get()->take(1);

        $activeLeague = DB::table('f1_leagues')
            ->select('f1_leagues.id', 'f1_leagues.name', 'f1_leagues.link')
            ->where('status', 1)
            ->orderBy('point_rate', 'ASC')
            ->first();

        $driverStandings = [];
        if ($activeLeague) {
            $leagueID = $activeLeague->id;

            $driverStandings = DB::table('f1_race_results')
                ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
                ->leftJoin('f1_league_drivers', function ($join) use ($leagueID) {
                    $join->on('f1_race_results.driver_id', '=', 'f1_league_drivers.driver_id')
                        ->where('f1_league_drivers.league_id', '=', $leagueID);
                })
                ->leftJoin('f1_teams', 'f1_league_drivers.team_id', '=', 'f1_teams.id') // Takım ismi için JOIN
                ->select(
                    'drivers.id',
                    'drivers.name',
                    'drivers.surname',
                    'f1_teams.name as team_name',  // Takım adı
                    'f1_teams.short_name as team_short_name', // Takım kısa adı
                    DB::raw('SUM(COALESCE(CAST(f1_race_results.points AS UNSIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS UNSIGNED), 0) + COALESCE(f1_league_drivers.last_point, 0)) as total_points')
                )
                ->where('f1_race_results.league_id', $leagueID)
                ->groupBy('drivers.id', 'drivers.name', 'drivers.surname', 'f1_teams.name', 'f1_teams.short_name')
                ->orderByDesc('total_points')
                ->get()
                ->take(10);

        }

        return view('welcome', compact(
            'instagramPosts',
            'youtubePosts',
            'nextRace',
            'activeLeague',
            'driverStandings'
        ));
    }

    function ruleBook()
    {
        return view('navs.ruleBook');
    }
}
