<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    function index()
    {
        // Genel İstatistikler
        $totalLeagues = DB::table('f1_leagues')->count();
        $activeLeagues = DB::table('f1_leagues')->where('status', 1)->count();
        $totalDrivers = DB::table('drivers')->where('status', 1)->count();
        $totalTeams = DB::table('f1_teams')->where('status', 1)->count();
        $totalTracks = DB::table('f1_tracks')->where('status', 1)->count();
        $totalRaceTracks = DB::table('f1_league_tracks')->count();
        $totalRaceResults = DB::table('f1_race_results')->count();
        
        // Hakem Kararları İstatistikleri
        $totalComplaints = DB::table('referee_decisions')
            ->where(function($query) {
                $query->whereNotNull('video_link')
                      ->orWhereNotNull('reminder');
            })
            ->count();
        
        $totalDefenses = DB::table('referee_decisions')
            ->where(function($query) {
                $query->whereNotNull('comp_video')
                      ->orWhereNotNull('comp_desc');
            })
            ->count();
        
        $totalAppeals = DB::table('referee_appeals')->count();
        
        // Son 5 Yarış
        $recentRaces = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->join('f1_leagues', 'f1_league_tracks.league_id', '=', 'f1_leagues.id')
            ->select(
                'f1_league_tracks.id',
                'f1_tracks.name as track_name',
                'f1_leagues.name as league_name',
                'f1_league_tracks.race_date',
                'f1_league_tracks.sprint_status'
            )
            ->orderBy('f1_league_tracks.race_date', 'desc')
            ->limit(5)
            ->get();
        
        // En çok şikayet alan yarışlar
        $topComplaintTracks = DB::table('referee_decisions')
            ->join('f1_league_tracks', function($join) {
                $join->on('referee_decisions.track_id', '=', 'f1_league_tracks.track_id')
                     ->on('referee_decisions.league_id', '=', 'f1_league_tracks.league_id');
            })
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->join('f1_leagues', 'referee_decisions.league_id', '=', 'f1_leagues.id')
            ->where(function($query) {
                $query->whereNotNull('referee_decisions.video_link')
                      ->orWhereNotNull('referee_decisions.reminder');
            })
            ->select(
                'f1_league_tracks.id as league_track_id',
                'f1_tracks.name as track_name',
                'f1_leagues.name as league_name',
                'f1_league_tracks.race_date',
                DB::raw('COUNT(DISTINCT referee_decisions.id) as complaint_count')
            )
            ->groupBy('f1_league_tracks.id', 'f1_tracks.name', 'f1_leagues.name', 'f1_league_tracks.race_date')
            ->orderBy('complaint_count', 'desc')
            ->limit(5)
            ->get();
        
        // Aktif ligler listesi
        $activeLeaguesList = DB::table('f1_leagues')
            ->where('status', 1)
            ->orderBy('rank')
            ->orderBy('name')
            ->limit(5)
            ->get();
        
        // Son eklenen pilotlar
        $recentDrivers = DB::table('drivers')
            ->orderBy('registration_date', 'desc')
            ->limit(5)
            ->get();
        
        // Toplam puan dağıtımı
        $totalPointsDistributed = DB::table('f1_race_results')
            ->sum(DB::raw('COALESCE(points, 0) + COALESCE(s_point, 0)'));
        
        return view('adminPanel.dashboard', compact(
            'totalLeagues',
            'activeLeagues',
            'totalDrivers',
            'totalTeams',
            'totalTracks',
            'totalRaceTracks',
            'totalRaceResults',
            'totalComplaints',
            'totalDefenses',
            'totalAppeals',
            'recentRaces',
            'topComplaintTracks',
            'activeLeaguesList',
            'recentDrivers',
            'totalPointsDistributed'
        ));
    }
}
