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
                'f1_race_results.fastest_lap',
                DB::raw('SUM(COALESCE(CAST(f1_race_results.points AS SIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS SIGNED), 0) + COALESCE(f1_league_drivers.last_point, 0)) as total_points')
            )
            ->where('f1_race_results.league_id', $leagueID)
            ->groupBy(
                'drivers.id',
                'drivers.name',
                'drivers.surname',
                'f1_teams.name',
                'f1_teams.short_name',
                'f1_race_results.f1_league_track_id',
                'f1_race_results.r_ranking',
                'f1_race_results.fastest_lap'
            )
            ->get();

        // **Pilot puanlarını ayarla**
        $driverStandings = [];
        foreach ($drivers as $driverID => $driver) {
            $totalPoints = $standings->where('id', $driverID)->sum(function($item) {
                return (int)($item->total_points ?? 0);
            });

            $trackPoints = [];
            foreach ($tracks as $track) {
                $trackResult = $standings->where('id', $driverID)->where('f1_league_track_id', $track->f1_league_track_id)->first();
                $trackPoints[$track->f1_league_track_id] = [
                    'point' => $standings->where('id', $driverID)->where('f1_league_track_id', $track->f1_league_track_id)->sum(function($item) {
                        return (int)($item->total_points ?? 0);
                    }),
                    'rank' => $trackResult?->r_ranking ?? null,
                    'fastest_lap' => $trackResult?->fastest_lap ?? 0,
                ];
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

            $totalPoints = $standings->where('id', $driverID)->sum(function($item) {
                return (int)($item->total_points ?? 0);
            });

            foreach ($tracks as $track) {
                $trackPoints = $standings->where('id', $driverID)->where('f1_league_track_id', $track->f1_league_track_id)->sum(function($item) {
                    return (int)($item->total_points ?? 0);
                });

                if (!isset($teamStandings[$teamID])) {
                    $teamStandings[$teamID] = [
                        'team_id' => $teamID,
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
                'drivers.id as driver_id',
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

    function refDecisions($link, $trackId = null)
    {
        $leagueID = self::getLeagueID($link);
        
        // Ligdeki tüm yarışları al (pist seçimi için)
        $tracks = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->select('f1_league_tracks.id as f1_league_track_id', 'f1_league_tracks.track_id', 'f1_league_tracks.race_date', 'f1_league_tracks.sprint_status', 'f1_tracks.name as track_name')
            ->where('f1_league_tracks.league_id', $leagueID)
            ->orderBy('f1_league_tracks.race_date', 'desc')
            ->get();

        // Eğer trackID gönderilmediyse en son pistin trackID'sini al
        if (!$trackId) {
            $latestTrack = DB::table('f1_league_tracks')
                ->where('league_id', $leagueID)
                ->orderBy('race_date', 'desc')
                ->first();

            if ($latestTrack) {
                $trackId = $latestTrack->id;
            }
        }

        $complaints = [];
        $selectedTrack = null;

        if ($trackId) {
            // Seçilen pist bilgilerini al
            $selectedTrack = DB::table('f1_league_tracks')
                ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
                ->select('f1_league_tracks.id as league_track_id', 'f1_league_tracks.track_id', 'f1_league_tracks.race_date', 'f1_league_tracks.sprint_status', 'f1_league_tracks.referee_decision_complete', 'f1_tracks.name as track_name')
                ->where('f1_league_tracks.id', $trackId)
                ->where('f1_league_tracks.league_id', $leagueID)
                ->first();

            if ($selectedTrack) {
                $selectedTrack->race_date_formatted = date('d.m.Y', strtotime($selectedTrack->race_date));
                
                // Bu yarışa ait tüm hakem kararlarını al
                $decisions = DB::table('referee_decisions')
                    ->where('track_id', $selectedTrack->track_id)
                    ->where('league_id', $leagueID)
                    ->orderBy('created_at', 'desc')
                    ->get();

                foreach ($decisions as $decision) {
                    // Sadece şikayetleri al (şikayet + savunma birleştirilmiş)
                    if (!empty($decision->video_link) || !empty($decision->reminder)) {
                        $complainant = DB::table('drivers')->where('id', $decision->complainant)->first();
                        $complained = DB::table('drivers')->where('id', $decision->complained)->first();

                        // Bu karar için yorumları al
                        $comments = DB::table('referee_comments')
                            ->where('ref_decisions_id', $decision->id)
                            ->get()
                            ->map(function($comment) {
                                $driver = DB::table('drivers')->where('id', $comment->user_id)->first();
                                $userName = 'Bilinmiyor';
                                if ($driver) {
                                    $name = trim(($driver->name ?? '') . ' ' . ($driver->surname ?? ''));
                                    $userName = $name ?: 'Bilinmiyor';
                                }
                                
                                // Ceza bilgilerini al
                                $penaltyName = null;
                                $penaltyDescName = null;
                                if ($comment->penalty_id) {
                                    $penalty = DB::table('penalties')->where('id', $comment->penalty_id)->first();
                                    $penaltyName = $penalty ? $penalty->name : null;
                                }
                                if ($comment->penalty_desc_id) {
                                    $penaltyDesc = DB::table('penalty_desc')->where('id', $comment->penalty_desc_id)->first();
                                    $penaltyDescName = $penaltyDesc ? $penaltyDesc->name : null;
                                }
                                
                                return [
                                    'id' => $comment->id,
                                    'user_name' => $userName,
                                    'comment' => $comment->comment,
                                    'penalty_id' => $comment->penalty_id,
                                    'penalty_name' => $penaltyName,
                                    'penalty_desc_id' => $comment->penalty_desc_id,
                                    'penalty_desc_name' => $penaltyDescName,
                                ];
                            })
                            ->toArray();

                        // İtirazlar - referee_appeals tablosundan al
                        $appeals = DB::table('referee_appeals')
                            ->where('ref_id', $decision->id)
                            ->get()
                            ->map(function($appeal) {
                                $appealDriver = DB::table('drivers')->where('id', $appeal->driver_id)->first();
                                return [
                                    'id' => $appeal->id,
                                    'driver_name' => ($appealDriver->name ?? 'Bilinmiyor') . ' ' . ($appealDriver->surname ?? ''),
                                    'description' => $appeal->description,
                                    'result' => $appeal->result,
                                    'confirm' => $appeal->confirm,
                                ];
                            })
                            ->toArray();

                        $penaltyValue = $decision->penalty ?? '';
                        $hasPenalty = !empty($penaltyValue) && trim($penaltyValue) != 'Cezaya gerek görülmedi.';
                        
                        $complaints[] = [
                            'id' => $decision->id,
                            'complainant_name' => ($complainant->name ?? 'Bilinmiyor') . ' ' . ($complainant->surname ?? ''),
                            'complained_name' => ($complained->name ?? 'Bilinmiyor') . ' ' . ($complained->surname ?? ''),
                            'video_link' => $decision->video_link,
                            'reminder' => $decision->reminder,
                            'created_at' => $decision->created_at ? date('d.m.Y H:i', strtotime($decision->created_at)) : 'Belirsiz',
                            'penalty_id' => $decision->penalty_id,
                            'penalty' => $decision->penalty,
                            'penalty_name' => $decision->penalty,
                            'penalty_point' => $decision->penalty_point ?? 0,
                            'penalty_desc_id' => $decision->penalty_desc_id,
                            'penalty_desc_name' => $decision->penalty_desc,
                            'description' => $decision->description,
                            'has_defense' => !empty($decision->comp_video) || !empty($decision->comp_desc),
                            'comp_video' => $decision->comp_video,
                            'comp_desc' => $decision->comp_desc,
                            'comp_date' => $decision->comp_date ? date('d.m.Y H:i', strtotime($decision->comp_date)) : null,
                            'appeals' => $appeals,
                            'comments' => $comments,
                            'has_penalty' => $hasPenalty,
                        ];
                    }
                }
            }
        }

        // Şikayetleri sırala: Sadece hakem kararları açıklandıysa (referee_decision_complete == 1)
        if ($selectedTrack && $selectedTrack->referee_decision_complete == 1) {
            usort($complaints, function($a, $b) {
                // Ceza verilmeyenler her zaman en alta
                if (!$a['has_penalty'] && $b['has_penalty']) {
                    return 1; // a en alta
                }
                if ($a['has_penalty'] && !$b['has_penalty']) {
                    return -1; // b en alta
                }
                // İkisi de ceza verilmişse, ceza puanına göre sırala (yüksekten düşüğe)
                if ($a['has_penalty'] && $b['has_penalty']) {
                    $pointA = (int)($a['penalty_point'] ?? 0);
                    $pointB = (int)($b['penalty_point'] ?? 0);
                    return $pointB <=> $pointA; // Yüksekten düşüğe
                }
                // İkisi de ceza verilmemişse, oluşturulma tarihine göre sırala (yeni en üstte)
                return strtotime($b['created_at']) <=> strtotime($a['created_at']);
            });
        }

        return view('f1leagues.ref_decisions', compact('link', 'tracks', 'leagueID', 'trackId', 'complaints', 'selectedTrack'));
    }
    
    function liveBroadcasts($link)
    {
        $leagueID = self::getLeagueID($link);
        
        // Ligdeki yarışları al (race_video ile birlikte)
        $leagueTracks = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->select(
                'f1_league_tracks.id as league_track_id', 
                'f1_league_tracks.track_id', 
                'f1_league_tracks.race_date', 
                'f1_league_tracks.sprint_status', 
                'f1_league_tracks.race_video',
                'f1_tracks.name as track_name'
            )
            ->where('f1_league_tracks.league_id', $leagueID)
            ->whereNotNull('f1_league_tracks.race_video')
            ->where('f1_league_tracks.race_video', '!=', '')
            ->orderBy('f1_league_tracks.race_date', 'desc')
            ->get();
        
        foreach ($leagueTracks as $track) {
            $track->race_date_formatted = date('d.m.Y H:i', strtotime($track->race_date));
            
            // YouTube video ID çıkar
            $videoId = null;
            if (!empty($track->race_video)) {
                // Eğer sadece video ID ise (örn: 1aPZn8YsKXg)
                if (preg_match('/^[a-zA-Z0-9_-]{11}$/', trim($track->race_video))) {
                    $videoId = trim($track->race_video);
                }
                // Eğer YouTube linki ise
                elseif (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $track->race_video, $matches)) {
                    $videoId = $matches[1];
                }
            }
            $track->video_id = $videoId;
        }
        
        return view('f1leagues.live_broadcasts', compact('link', 'leagueTracks', 'leagueID'));
    }
    
    function schedule($link)
    {
        $leagueID = self::getLeagueID($link);
        
        // Ligdeki tüm yarışları al
        $schedule = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->select(
                'f1_league_tracks.id as league_track_id',
                'f1_league_tracks.track_id',
                'f1_league_tracks.race_date',
                'f1_league_tracks.sprint_status',
                'f1_league_tracks.qualifying_type',
                'f1_tracks.name as track_name'
            )
            ->where('f1_league_tracks.league_id', $leagueID)
            ->orderBy('f1_league_tracks.race_date', 'asc')
            ->get();
        
        foreach ($schedule as $race) {
            $race->race_date_formatted = date('d.m.Y', strtotime($race->race_date));
            $race->race_time_formatted = date('H:i', strtotime($race->race_date));
            $race->is_past = strtotime($race->race_date) < time();
        }
        
        return view('f1leagues.schedule', compact('link', 'schedule', 'leagueID'));
    }

    public function pastSeasons()
    {
        // Eski ligleri al (status = 0)
        $pastLeagues = DB::table('f1_leagues')
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('f1leagues.past_seasons', compact('pastLeagues'));
    }
}
