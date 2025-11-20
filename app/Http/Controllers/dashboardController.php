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
                    DB::raw('SUM(COALESCE(CAST(f1_race_results.points AS SIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS SIGNED), 0) + COALESCE(f1_league_drivers.last_point, 0)) as total_points')
                )
                ->where('f1_race_results.league_id', $leagueID)
                ->groupBy('drivers.id', 'drivers.name', 'drivers.surname', 'f1_teams.name', 'f1_teams.short_name')
                ->orderByDesc('total_points')
                ->get()
                ->take(10);

        }

        // Tüm pistler için istatistikler (sadece point_rate = 100 olan ligler)
        $trackStatistics = [];
        $allTracks = DB::table('f1_tracks')->where('status', 1)->get();
        
        foreach ($allTracks as $track) {
            $trackStats = [
                'track_id' => $track->id,
                'track_name' => $track->name,
                'most_wins' => [],
                'most_podiums' => [],
                'most_poles' => [],
                'most_fastest_laps' => [],
                'most_points' => [],
            ];

            // Bu pistte yapılan tüm yarışları al (sadece point_rate = 100 olan ligler)
            $raceResults = DB::table('f1_race_results')
                ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
                ->join('f1_leagues', 'f1_league_tracks.league_id', '=', 'f1_leagues.id')
                ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
                ->where('f1_league_tracks.track_id', $track->id)
                ->where('f1_leagues.point_rate', 100)
                ->where('f1_race_results.r_ranking', '>', 0)
                ->select(
                    'drivers.id as driver_id',
                    'drivers.name',
                    'drivers.surname',
                    'f1_race_results.r_ranking',
                    'f1_race_results.q_ranking',
                    'f1_race_results.fastest_lap',
                    DB::raw('COALESCE(CAST(f1_race_results.points AS SIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS SIGNED), 0) as points')
                )
                ->get();

            if ($raceResults->count() > 0) {
                // En çok kazanan
                $wins = $raceResults->where('r_ranking', 1)
                    ->groupBy('driver_id')
                    ->map(function($group) {
                        $first = $group->first();
                        return [
                            'driver_id' => $first->driver_id,
                            'name' => $first->name,
                            'surname' => $first->surname,
                            'count' => $group->count()
                        ];
                    })
                    ->sortByDesc('count')
                    ->take(3)
                    ->values();
                $trackStats['most_wins'] = $wins;

                // En çok podyum
                $podiums = $raceResults->where('r_ranking', '<=', 3)
                    ->groupBy('driver_id')
                    ->map(function($group) {
                        $first = $group->first();
                        return [
                            'driver_id' => $first->driver_id,
                            'name' => $first->name,
                            'surname' => $first->surname,
                            'count' => $group->count()
                        ];
                    })
                    ->sortByDesc('count')
                    ->take(3)
                    ->values();
                $trackStats['most_podiums'] = $podiums;

                // En çok pole position
                $poles = $raceResults->where('q_ranking', 1)
                    ->groupBy('driver_id')
                    ->map(function($group) {
                        $first = $group->first();
                        return [
                            'driver_id' => $first->driver_id,
                            'name' => $first->name,
                            'surname' => $first->surname,
                            'count' => $group->count()
                        ];
                    })
                    ->sortByDesc('count')
                    ->take(3)
                    ->values();
                $trackStats['most_poles'] = $poles;

                // En çok en hızlı tur
                $fastestLaps = $raceResults->where('fastest_lap', 1)
                    ->groupBy('driver_id')
                    ->map(function($group) {
                        $first = $group->first();
                        return [
                            'driver_id' => $first->driver_id,
                            'name' => $first->name,
                            'surname' => $first->surname,
                            'count' => $group->count()
                        ];
                    })
                    ->sortByDesc('count')
                    ->take(3)
                    ->values();
                $trackStats['most_fastest_laps'] = $fastestLaps;

                // En çok puan
                $points = $raceResults->groupBy('driver_id')
                    ->map(function($group) {
                        $first = $group->first();
                        return [
                            'driver_id' => $first->driver_id,
                            'name' => $first->name,
                            'surname' => $first->surname,
                            'total' => $group->sum('points')
                        ];
                    })
                    ->sortByDesc('total')
                    ->take(3)
                    ->values();
                $trackStats['most_points'] = $points;
            }

            $trackStatistics[] = $trackStats;
        }

        // Seçmeleri gösterilecek ligler (tryouts_visibility = 1)
        $tryoutsLeagues = DB::table('f1_leagues')
            ->leftJoin('f1_tracks', 'f1_leagues.tryouts_track_id', '=', 'f1_tracks.id')
            ->where('f1_leagues.status', 1)
            ->where('f1_leagues.tryouts_visibility', 1)
            ->select(
                'f1_leagues.*',
                'f1_tracks.id as track_id',
                'f1_tracks.name as track_name'
            )
            ->orderBy('f1_leagues.point_rate', 'ASC')
            ->get();

        $tryoutsData = [];
        foreach ($tryoutsLeagues as $league) {
            $tryouts = DB::table('f1_league_tryouts')
                ->join('drivers', 'f1_league_tryouts.driver_id', '=', 'drivers.id')
                ->where('f1_league_tryouts.league_id', $league->id)
                ->select(
                    'f1_league_tryouts.id',
                    'f1_league_tryouts.driver_id',
                    'f1_league_tryouts.first_day_result',
                    'f1_league_tryouts.second_day_result',
                    'f1_league_tryouts.third_day_result',
                    'f1_league_tryouts.fourth_day_result',
                    'f1_league_tryouts.fifth_day_result',
                    'drivers.name',
                    'drivers.surname'
                )
                ->get();

            if ($tryouts->count() > 0) {
                // Zamanları parse edip en hızlı zamanı bul
                $tryouts = $tryouts->map(function($tryout) {
                    $times = [];
                    $fields = ['first_day_result', 'second_day_result', 'third_day_result', 'fourth_day_result', 'fifth_day_result'];
                    
                    foreach ($fields as $field) {
                        $time = $tryout->$field;
                        if ($time && $time != '-' && $time != '') {
                            // Zaman formatını parse et (örn: "1:23.456" -> saniyeye çevir)
                            if (preg_match('/(\d+):(\d+)\.(\d+)/', $time, $matches)) {
                                $minutes = (int)$matches[1];
                                $seconds = (int)$matches[2];
                                $milliseconds = (float)('0.' . $matches[3]);
                                $totalSeconds = ($minutes * 60) + $seconds + $milliseconds;
                                $times[] = [
                                    'time' => $totalSeconds,
                                    'formatted' => $time,
                                    'field' => $field
                                ];
                            }
                        }
                    }
                    
                    // En hızlı zamanı bul
                    if (!empty($times)) {
                        $best = collect($times)->sortBy('time')->first();
                        $tryout->best_time = $best['time'];
                        $tryout->best_time_formatted = $best['formatted'];
                        $tryout->best_time_field = $best['field']; // Hangi günün en hızlı olduğunu sakla
                    } else {
                        $tryout->best_time = 9999;
                        $tryout->best_time_formatted = null;
                        $tryout->best_time_field = null;
                    }
                    
                    return $tryout;
                });

                // En hızlı zamana göre sırala
                $tryouts = $tryouts->sortBy(function($tryout) {
                    return $tryout->best_time ?? 9999;
                })->values();

                // Hangi günlerin dolu olduğunu kontrol et
                $activeDays = [];
                $dayFields = [
                    'first_day_result' => '1. Gün',
                    'second_day_result' => '2. Gün',
                    'third_day_result' => '3. Gün',
                    'fourth_day_result' => '4. Gün',
                    'fifth_day_result' => '5. Gün'
                ];

                foreach ($dayFields as $field => $label) {
                    $hasData = $tryouts->filter(function($tryout) use ($field) {
                        return !empty($tryout->$field) && $tryout->$field != '-';
                    })->count() > 0;
                    
                    if ($hasData) {
                        $activeDays[$field] = $label;
                    }
                }

                $tryoutsData[] = [
                    'league' => $league,
                    'tryouts' => $tryouts,
                    'track_id' => $league->track_id ?? null,
                    'track_name' => $league->track_name ?? null,
                    'activeDays' => $activeDays
                ];
            }
        }

        return view('welcome', compact(
            'instagramPosts',
            'youtubePosts',
            'nextRace',
            'activeLeague',
            'driverStandings',
            'tryoutsData'
        ));
    }

    function statistics($trackId = null)
    {
        // Tüm aktif pistleri al
        $allTracks = DB::table('f1_tracks')->where('status', 1)->orderBy('name', 'asc')->get();
        
        $generalStatistics = null;
        $trackStatistics = null;
        
        if (!$trackId) {
            // Tümü seçildiğinde: Tüm pistlerdeki genel istatistikler
            $allRaceResults = DB::table('f1_race_results')
                ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
                ->join('f1_leagues', 'f1_league_tracks.league_id', '=', 'f1_leagues.id')
                ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
                ->leftJoin('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
                ->where('f1_leagues.point_rate', 100)
                ->where('f1_race_results.r_ranking', '>', 0)
                ->select(
                    'drivers.id as driver_id',
                    'drivers.name',
                    'drivers.surname',
                    'drivers.country',
                    'f1_race_results.r_ranking',
                    'f1_race_results.q_ranking',
                    'f1_race_results.fastest_lap',
                    'f1_race_results.fast_q',
                    'f1_race_results.fast_r',
                    'f1_league_tracks.race_date',
                    'f1_league_tracks.id as f1_league_track_id',
                    'f1_league_tracks.track_id',
                    'f1_leagues.id as league_id',
                    'f1_leagues.name as league_name',
                    'f1_leagues.link as league_link',
                    'f1_tracks.name as track_name',
                    DB::raw('COALESCE(CAST(f1_race_results.points AS SIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS SIGNED), 0) as points')
                )
                ->get();

            if ($allRaceResults->count() > 0) {
                $generalStatistics = $this->calculateStatistics($allRaceResults);
            }
        } else {
            // Seçilen pist için istatistikler
            $track = $allTracks->firstWhere('id', $trackId);
            if ($track) {
                $raceResults = DB::table('f1_race_results')
                    ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
                    ->join('f1_leagues', 'f1_league_tracks.league_id', '=', 'f1_leagues.id')
                    ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
                    ->where('f1_league_tracks.track_id', $trackId)
                    ->where('f1_leagues.point_rate', 100)
                    ->where('f1_race_results.r_ranking', '>', 0)
                    ->select(
                        'drivers.id as driver_id',
                        'drivers.name',
                        'drivers.surname',
                        'drivers.country',
                        'f1_race_results.r_ranking',
                        'f1_race_results.q_ranking',
                        'f1_race_results.fastest_lap',
                        'f1_race_results.fast_q',
                        'f1_race_results.fast_r',
                        'f1_league_tracks.id as f1_league_track_id',
                        'f1_league_tracks.race_date',
                        'f1_leagues.id as league_id',
                        'f1_leagues.name as league_name',
                        'f1_leagues.link as league_link',
                        DB::raw('COALESCE(CAST(f1_race_results.points AS SIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS SIGNED), 0) as points')
                    )
                    ->get();

                if ($raceResults->count() > 0) {
                    $trackStatistics = $this->calculateStatistics($raceResults);
                    $trackStatistics['track_name'] = $track->name;
                    $trackStatistics['track_id'] = $track->id;
                }
            }
        }

        // Top 3 şampiyon pilotları bul (status 0 ve point_rate 100 olan liglerden)
        $finishedLeagues = DB::table('f1_leagues')
            ->where('status', 0)
            ->where('point_rate', 100)
            ->select('id', 'name')
            ->get();

        $championshipCounts = [];

        foreach ($finishedLeagues as $league) {
            $leagueId = $league->id;
            $leagueName = $league->name;
            
            // Bu ligdeki tüm pilotların toplam puanlarını hesapla
            $leagueStandings = DB::table('f1_race_results')
                ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
                ->leftJoin('f1_league_drivers', function ($join) use ($leagueId) {
                    $join->on('f1_race_results.driver_id', '=', 'f1_league_drivers.driver_id')
                         ->where('f1_league_drivers.league_id', '=', $leagueId);
                })
                ->where('f1_race_results.league_id', $leagueId)
                ->where('f1_race_results.r_ranking', '>', 0)
                ->select(
                    'drivers.id',
                    'drivers.name',
                    'drivers.surname',
                    DB::raw('SUM(COALESCE(CAST(f1_race_results.points AS SIGNED), 0) + COALESCE(CAST(f1_race_results.s_point AS SIGNED), 0) + COALESCE(f1_league_drivers.last_point, 0)) as total_points')
                )
                ->groupBy('drivers.id', 'drivers.name', 'drivers.surname')
                ->orderByDesc('total_points')
                ->get();

            if ($leagueStandings->isNotEmpty()) {
                // En yüksek puanı al
                $maxPoints = (int)($leagueStandings->first()->total_points ?? 0);
                
                // En yüksek puanlı pilotları bul (beraberlik durumu için)
                $champions = $leagueStandings->filter(function($item) use ($maxPoints) {
                    return (int)($item->total_points ?? 0) === $maxPoints;
                });
                
                // Her şampiyon için sayacı artır ve sezon bilgisini ekle
                foreach ($champions as $champion) {
                    $driverId = $champion->id;
                    if (!isset($championshipCounts[$driverId])) {
                        $championshipCounts[$driverId] = [
                            'id' => $champion->id,
                            'name' => $champion->name,
                            'surname' => $champion->surname,
                            'championships' => 0,
                            'seasons' => []
                        ];
                    }
                    $championshipCounts[$driverId]['championships']++;
                    $championshipCounts[$driverId]['seasons'][] = $leagueName;
                }
            }
        }

        // Her pilot için katıldığı sezon sayısını hesapla (point_rate 100 ve status 0 olan liglerden)
        foreach ($championshipCounts as $driverId => $champion) {
            $seasonsParticipated = DB::table('f1_race_results')
                ->join('f1_leagues', 'f1_race_results.league_id', '=', 'f1_leagues.id')
                ->where('f1_race_results.driver_id', $driverId)
                ->where('f1_leagues.status', 0)
                ->where('f1_leagues.point_rate', 100)
                ->where('f1_race_results.r_ranking', '>', 0)
                ->distinct()
                ->count('f1_race_results.league_id');
            
            $championshipCounts[$driverId]['seasons_participated'] = $seasonsParticipated;
        }

        // Tüm şampiyonları sırala
        $allChampions = collect($championshipCounts)
            ->sortByDesc('championships')
            ->values();
        
        // İlk 3 şampiyon
        $topChampions = $allChampions->take(3);
        
        // Diğer şampiyonlar (4. ve sonrası)
        $otherChampions = $allChampions->skip(3);

        return view('statistics', compact('generalStatistics', 'trackStatistics', 'allTracks', 'trackId', 'topChampions', 'otherChampions'));
    }

    private function calculateStatistics($raceResults)
    {
        $stats = [
            'most_wins' => [],
            'most_podiums' => [],
            'most_poles' => [],
            'most_fastest_laps' => [],
            'most_points' => [],
            'most_races' => [],
            'best_avg_position' => [],
            'most_top5' => [],
            'most_top10' => [],
            'most_positions_gained' => [],
            'most_positions_lost' => [],
            'fastest_qualifying_laps' => [],
            'fastest_race_laps' => [],
            'most_consistent' => [],
            'most_dnf' => [],
            'highest_avg_points' => [],
        ];

        // En çok kazanan
        $wins = $raceResults->where('r_ranking', 1)
            ->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $latest = $group->sortByDesc(function($item) {
                    return $item->race_date ?? '2000-01-01';
                })->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'count' => $group->count(),
                    'league_name' => $latest->league_name ?? '',
                    'league_link' => $latest->league_link ?? '',
                    'f1_league_track_id' => $latest->f1_league_track_id ?? null,
                    'track_name' => $latest->track_name ?? ''
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values();
        $stats['most_wins'] = $wins;

        // En çok podyum
        $podiums = $raceResults->where('r_ranking', '<=', 3)
            ->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $latest = $group->sortByDesc(function($item) {
                    return $item->race_date ?? '2000-01-01';
                })->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'count' => $group->count(),
                    'league_name' => $latest->league_name ?? '',
                    'league_link' => $latest->league_link ?? '',
                    'f1_league_track_id' => $latest->f1_league_track_id ?? null,
                    'track_name' => $latest->track_name ?? ''
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values();
        $stats['most_podiums'] = $podiums;

        // En çok pole position
        $poles = $raceResults->where('q_ranking', 1)
            ->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $latest = $group->sortByDesc(function($item) {
                    return $item->race_date ?? '2000-01-01';
                })->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'count' => $group->count(),
                    'league_name' => $latest->league_name ?? '',
                    'league_link' => $latest->league_link ?? '',
                    'f1_league_track_id' => $latest->f1_league_track_id ?? null,
                    'track_name' => $latest->track_name ?? ''
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values();
        $stats['most_poles'] = $poles;

        // En çok en hızlı tur
        $fastestLaps = $raceResults->where('fastest_lap', 1)
            ->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $latest = $group->sortByDesc(function($item) {
                    return $item->race_date ?? '2000-01-01';
                })->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'count' => $group->count(),
                    'league_name' => $latest->league_name ?? '',
                    'league_link' => $latest->league_link ?? '',
                    'f1_league_track_id' => $latest->f1_league_track_id ?? null,
                    'track_name' => $latest->track_name ?? ''
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values();
        $stats['most_fastest_laps'] = $fastestLaps;

        // En çok puan
        $points = $raceResults->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $latest = $group->sortByDesc(function($item) {
                    return $item->race_date ?? '2000-01-01';
                })->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'total' => $group->sum(function($item) {
                        return (int)($item->points ?? 0);
                    }),
                    'league_name' => $latest->league_name ?? '',
                    'league_link' => $latest->league_link ?? '',
                    'f1_league_track_id' => $latest->f1_league_track_id ?? null,
                    'track_name' => $latest->track_name ?? ''
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values();
        $stats['most_points'] = $points;

        // En çok yarış
        $races = $raceResults->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values();
        $stats['most_races'] = $races;

        // En iyi ortalama sıralama
        $avgPositions = $raceResults->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $rankings = $group->pluck('r_ranking')->filter(function($r) { return $r > 0; });
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'avg' => $rankings->isNotEmpty() ? round($rankings->avg(), 2) : null,
                    'races' => $rankings->count()
                ];
            })
            ->filter(function($item) { return $item['avg'] !== null && $item['races'] >= 3; })
            ->sortBy('avg')
            ->take(5)
            ->values();
        $stats['best_avg_position'] = $avgPositions;

        // En çok top 5
        $top5 = $raceResults->where('r_ranking', '<=', 5)
            ->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values();
        $stats['most_top5'] = $top5;

        // En çok top 10
        $top10 = $raceResults->where('r_ranking', '<=', 10)
            ->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take(5)
            ->values();
        $stats['most_top10'] = $top10;

        // En çok sıra kazanan (qualifying'den yarışa)
        $positionsGained = $raceResults->filter(function($result) {
            $qRank = (int)$result->q_ranking;
            $rRank = (int)$result->r_ranking;
            return $qRank > 0 && $rRank > 0 && $qRank > $rRank;
        })
        ->map(function($result) {
            $qRank = (int)$result->q_ranking;
            $rRank = (int)$result->r_ranking;
            return [
                'driver_id' => $result->driver_id,
                'name' => $result->name,
                'surname' => $result->surname,
                'country' => $result->country ?? '',
                'gained' => $qRank - $rRank
            ];
        })
        ->groupBy('driver_id')
        ->map(function($group) {
            $first = $group->first();
            return [
                'driver_id' => $first['driver_id'],
                'name' => $first['name'],
                'surname' => $first['surname'],
                'country' => $first['country'] ?? '',
                'total_gained' => $group->sum('gained'),
                'count' => $group->count()
            ];
        })
        ->sortByDesc('total_gained')
        ->take(5)
        ->values();
        $stats['most_positions_gained'] = $positionsGained;

        // En hızlı sıralama turu (qualifying) - En hızlı fast_q zamanları
        $fastestQualifying = $raceResults->filter(function($result) {
            return !empty($result->fast_q) && $result->fast_q != '0' && $result->fast_q != '-';
        })
        ->sortBy(function($result) {
            // Zaman formatını parse et (örn: "1:23.456" -> saniyeye çevir)
            $time = $result->fast_q;
            if (preg_match('/(\d+):(\d+)\.(\d+)/', $time, $matches)) {
                return (int)$matches[1] * 60 + (int)$matches[2] + (float)('0.' . $matches[3]);
            }
            return 9999;
        })
        ->take(5)
        ->map(function($result, $index) {
            return [
                'driver_id' => $result->driver_id,
                'name' => $result->name,
                'surname' => $result->surname,
                'country' => $result->country ?? '',
                'time' => $result->fast_q,
                'rank' => $index + 1
            ];
        })
        ->values();
        $stats['fastest_qualifying_laps'] = $fastestQualifying;

        // En hızlı yarış turu (race) - En hızlı fast_r zamanları
        $fastestRace = $raceResults->filter(function($result) {
            return !empty($result->fast_r) && $result->fast_r != '0' && $result->fast_r != '-';
        })
        ->sortBy(function($result) {
            // Zaman formatını parse et
            $time = $result->fast_r;
            if (preg_match('/(\d+):(\d+)\.(\d+)/', $time, $matches)) {
                return (int)$matches[1] * 60 + (int)$matches[2] + (float)('0.' . $matches[3]);
            }
            return 9999;
        })
        ->take(5)
        ->map(function($result, $index) {
            return [
                'driver_id' => $result->driver_id,
                'name' => $result->name,
                'surname' => $result->surname,
                'country' => $result->country ?? '',
                'time' => $result->fast_r,
                'rank' => $index + 1
            ];
        })
        ->values();
        $stats['fastest_race_laps'] = $fastestRace;

        // En çok sıra kaybeden (qualifying'den yarışa)
        $positionsLost = $raceResults->filter(function($result) {
            $qRank = (int)$result->q_ranking;
            $rRank = (int)$result->r_ranking;
            return $qRank > 0 && $rRank > 0 && $qRank < $rRank;
        })
        ->map(function($result) {
            $qRank = (int)$result->q_ranking;
            $rRank = (int)$result->r_ranking;
            return [
                'driver_id' => $result->driver_id,
                'name' => $result->name,
                'surname' => $result->surname,
                'country' => $result->country ?? '',
                'lost' => $rRank - $qRank
            ];
        })
        ->groupBy('driver_id')
        ->map(function($group) {
            $first = $group->first();
            return [
                'driver_id' => $first['driver_id'],
                'name' => $first['name'],
                'surname' => $first['surname'],
                'country' => $first['country'] ?? '',
                'total_lost' => $group->sum('lost'),
                'count' => $group->count()
            ];
        })
        ->sortByDesc('total_lost')
        ->take(5)
        ->values();
        $stats['most_positions_lost'] = $positionsLost;

        // En tutarlı pilot (en düşük standart sapma)
        $consistent = $raceResults->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $rankings = $group->pluck('r_ranking')->filter(function($r) { return $r > 0; });
                if ($rankings->count() < 5) return null; // En az 5 yarış
                
                $avg = $rankings->avg();
                $variance = $rankings->sum(function($r) use ($avg) {
                    return pow($r - $avg, 2);
                }) / $rankings->count();
                $stdDev = sqrt($variance);
                
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'std_dev' => round($stdDev, 2),
                    'avg' => round($avg, 2),
                    'races' => $rankings->count()
                ];
            })
            ->filter(function($item) { return $item !== null; })
            ->sortBy('std_dev')
            ->take(5)
            ->values();
        $stats['most_consistent'] = $consistent;

        // En çok DNF (Did Not Finish - r_ranking = 0 veya null)
        $dnf = $raceResults->filter(function($result) {
            return $result->r_ranking == 0 || $result->r_ranking == null;
        })
        ->groupBy('driver_id')
        ->map(function($group) {
            $first = $group->first();
            return [
                'driver_id' => $first->driver_id,
                'name' => $first->name,
                'surname' => $first->surname,
                'country' => $first->country ?? '',
                'count' => $group->count()
            ];
        })
        ->sortByDesc('count')
        ->take(5)
        ->values();
        $stats['most_dnf'] = $dnf;

        // En yüksek ortalama puan (en az 5 yarış)
        $avgPoints = $raceResults->groupBy('driver_id')
            ->map(function($group) {
                $first = $group->first();
                $points = $group->pluck('points');
                return [
                    'driver_id' => $first->driver_id,
                    'name' => $first->name,
                    'surname' => $first->surname,
                    'country' => $first->country ?? '',
                    'avg_points' => $points->isNotEmpty() ? round($points->avg(), 2) : 0,
                    'races' => $points->count()
                ];
            })
            ->filter(function($item) { return $item['races'] >= 5; })
            ->sortByDesc('avg_points')
            ->take(5)
            ->values();
        $stats['highest_avg_points'] = $avgPoints;

        return $stats;
    }

    function ruleBook()
    {
        return view('navs.ruleBook');
    }

    function calendar()
    {
        // Tüm aktif liglerdeki gelecek yarışları al
        $upcomingRaces = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->join('f1_leagues', 'f1_league_tracks.league_id', '=', 'f1_leagues.id')
            ->where('f1_league_tracks.race_date', '>=', date('Y-m-d'))
            ->where('f1_leagues.status', 1)
            ->select(
                'f1_league_tracks.id as league_track_id',
                'f1_league_tracks.league_id',
                'f1_league_tracks.track_id',
                'f1_league_tracks.race_date',
                'f1_league_tracks.sprint_status',
                'f1_tracks.name as track_name',
                'f1_leagues.name as league_name',
                'f1_leagues.link as league_link'
            )
            ->orderBy('f1_league_tracks.race_date', 'asc')
            ->get();

        // Tarihe göre grupla ve sprint/yarış birleştir
        $calendarEvents = [];
        foreach ($upcomingRaces as $race) {
            $dateKey = date('Y-m-d', strtotime($race->race_date));
            
            if (!isset($calendarEvents[$dateKey])) {
                $calendarEvents[$dateKey] = [
                    'date' => $race->race_date,
                    'date_formatted' => date('d.m.Y', strtotime($race->race_date)),
                    'races' => []
                ];
            }

            // Aynı gün, aynı lig ve aynı pistte sprint ve yarış varsa birleştir
            $found = false;
            foreach ($calendarEvents[$dateKey]['races'] as &$existingRace) {
                if ($existingRace['league_id'] == $race->league_id && 
                    $existingRace['track_id'] == $race->track_id) {
                    // Aynı gün, aynı lig, aynı pist - sprint/yarış durumunu güncelle
                    if ($race->sprint_status == 1) {
                        $existingRace['has_sprint'] = true;
                    }
                    if ($race->sprint_status == 0) {
                        $existingRace['has_race'] = true;
                    }
                    // En erken saati kullan
                    $raceTime = date('H:i', strtotime($race->race_date));
                    if ($raceTime < $existingRace['race_time']) {
                        $existingRace['race_time'] = $raceTime;
                    }
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $calendarEvents[$dateKey]['races'][] = [
                    'league_track_id' => $race->league_track_id,
                    'league_id' => $race->league_id,
                    'track_id' => $race->track_id,
                    'track_name' => $race->track_name,
                    'league_name' => $race->league_name,
                    'league_link' => $race->league_link,
                    'race_date' => $race->race_date,
                    'race_time' => date('H:i', strtotime($race->race_date)),
                    'has_sprint' => $race->sprint_status == 1,
                    'has_race' => $race->sprint_status == 0,
                ];
            }
        }

        // Tarihe göre sırala
        ksort($calendarEvents);

        return view('calendar', compact('calendarEvents'));
    }
}
