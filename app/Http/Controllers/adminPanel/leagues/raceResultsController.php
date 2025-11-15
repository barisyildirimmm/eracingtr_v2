<?php

namespace App\Http\Controllers\adminPanel\leagues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class raceResultsController extends Controller
{
    public function listRaceResult($league_id, $f1_league_track_id = null)
    {
        // **Güncellenmiş Sorgu**: `f1_league_tracks.id` kullanıyoruz
        $tracks = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_tracks.id', '=', 'f1_league_tracks.track_id')
            ->select(
                'f1_league_tracks.id as f1_league_track_id', // Benzersiz ID
                'f1_tracks.name as track_name',
                'f1_league_tracks.track_id',
                'f1_league_tracks.sprint_status',
                'f1_league_tracks.qualifying_type'
            )
            ->where('f1_league_tracks.league_id', '=', $league_id)
            ->get();

        // Pist isimlerini dizide tutalım
        $trackNames = [];
        foreach ($tracks as $track) {
            $trackNames[$track->f1_league_track_id] = $track;
        }

        // Eğer track_id gelmezse, ilk pisti varsayılan olarak seç
        if (!$f1_league_track_id && $tracks->isNotEmpty()) {
            $f1_league_track_id = $tracks->first()->f1_league_track_id;
        }

        // **Güncellenmiş Qualifying Type Sorgusu**
        $qualifyingType = DB::table('f1_league_tracks')
            ->where('id', '=', $f1_league_track_id) // `track_id` yerine `id` kullandık
            ->value('qualifying_type');

        // **Güncellenmiş Yarış Sonuçları Sorgusu**
        $raceResults = DB::table('f1_race_results')
            ->join('f1_league_tracks', 'f1_race_results.f1_league_track_id', '=', 'f1_league_tracks.id')
            ->join('drivers', 'f1_race_results.driver_id', '=', 'drivers.id')
            ->select(
                'f1_race_results.*',
                'f1_league_tracks.id as f1_league_track_id',
                'f1_league_tracks.track_id',
                'f1_league_tracks.qualifying_type',
                'drivers.name as driver_name',
                'drivers.surname as driver_surname'
            )
            ->where('f1_race_results.league_id', '=', $league_id)
            ->where('f1_race_results.f1_league_track_id', '=', $f1_league_track_id) // Güncellendi
            ->orderBy('drivers.name')
            ->get();

        return view('adminPanel.leagues.raceResults', compact(
            'tracks',
            'raceResults',
            'league_id',
            'f1_league_track_id',
            'trackNames',
            'qualifyingType'
        ));
    }

    public function ligYarisSonucOlustur()
    {
//        $leagueID = 56;
//        // Ligde yarışan tüm sürücüleri al
//        $drivers = DB::table('f1_league_drivers')
//            ->where('league_id', $leagueID)
//            ->pluck('driver_id'); // Sadece sürücü ID'lerini al
//
//        // Eğer ligde sürücü yoksa işlem yapma
//        if ($drivers->isEmpty()) {
//            return response()->json(['message' => 'No drivers found for this league.'], 400);
//        }
//
//        // 2️⃣ Ligde bulunan tüm pistleri al
//        $tracks = DB::table('f1_league_tracks')
//            ->where('league_id', $leagueID)
//            ->pluck('track_id', 'id'); // `id` (f1_league_track_id) ve `track_id` al
//
//        // Eğer pist bulunamazsa işlem yapma
//        if ($tracks->isEmpty()) {
//            return response()->json(['message' => 'No tracks found for this league.'], 400);
//        }
//
//        // 3️⃣ Eklenmiş sürücüleri takip etmek için dizi
//        $insertData = [];
//
//        foreach ($drivers as $driverID) {
//            foreach ($tracks as $leagueTrackID => $trackID) {
//                $tracksData = DB::table('f1_league_tracks')
//                    ->where('id', $leagueTrackID)
//                    ->first();
//
//                $sprintStatus = $tracksData->sprint_status;
//
//                $insertData[] = [
//                    'f1_league_track_id' => $leagueTrackID, // `f1_league_tracks` içindeki id
//                    'q_ranking' => 0,
//                    'r_ranking' => 0,
//                    'points' => 0,
//                    'fast_q1' => 0,
//                    'fast_q2' => 0,
//                    'fast_q3' => 0,
//                    'fast_q' => 0,
//                    'fast_r' => 0,
//                    'fastest_lap' => 0,
//                    'total_time' => 0,
//                    'race_penalty' => 0,
//                    'driver_id' => $driverID,
//                    'league_id' => $leagueID,
//                    'track_id' => $trackID, // Pist ID
//                    'grid_penalty' => 0,
//                    'reserve_driver' => 0,
//                    'sprint_status' => $sprintStatus,
//                    's_ranking' => 0,
//                    's_point' => 0,
//
//                ];
//            }
//        }
//
//        // 4️⃣ Toplu ekleme işlemi
//        DB::table('f1_race_results')->insert($insertData);
//
//        dd([
//            'message' => 'Default race results inserted successfully.',
//            'total_inserted' => count($insertData)
//        ]);
    }

    public function updateRaceResultsOLD(Request $request)
    {
        $updates = $request->input('update', []);

        foreach ($updates as $result_id => $value) {
            DB::table('f1_race_results')
                ->where('id', '=', $result_id)
                ->update([
                    'q_ranking' => $request->input("q_ranking.$result_id"),
                    'r_ranking' => $request->input("r_ranking.$result_id"),
                    'points' => $request->input("points.$result_id"),
                    'fast_q1' => $request->input("fast_q1.$result_id") ?? 0,
                    'fast_q2' => $request->input("fast_q2.$result_id") ?? 0,
                    'fast_q3' => $request->input("fast_q3.$result_id") ?? 0,
                    'fast_q' => $request->input("fast_q.$result_id"),
                    'fast_r' => $request->input("fast_r.$result_id"),
                    'fastest_lap' => $request->input("fastest_lap.$result_id"),
                    'total_time' => $request->input("total_time.$result_id"),
                    'race_penalty' => $request->input("race_penalty.$result_id"),
                    'grid_penalty' => $request->input("grid_penalty.$result_id"),
                    'reserve_driver' => $request->input("reserve_driver.$result_id"),
                ]);
        }

        return redirect()->route('admin.leagues.raceResults', [
            'league_id' => $request->input('league_id'),
            'track_id' => $request->input('f1_league_track_id'),
        ])->with('success', 'Sonuçlar başarıyla güncellendi.');
    }
    public function updateRaceResults(Request $request)
    {
        $updates = $request->input('update', []);

        foreach ($updates as $result_id => $value) {
            DB::table('f1_race_results')
                ->where('id', '=', $result_id)
                ->update([
                    'q_ranking' => $request->input("q_ranking.$result_id"),
                    'r_ranking' => $request->input("r_ranking.$result_id"),
                    'points' => $request->input("points.$result_id"),
                    'fast_q1' => $request->input("fast_q1.$result_id") ?? 0,
                    'fast_q2' => $request->input("fast_q2.$result_id") ?? 0,
                    'fast_q3' => $request->input("fast_q3.$result_id") ?? 0,
                    'fast_q' => $request->input("fast_q.$result_id"),
                    'fast_r' => $request->input("fast_r.$result_id"),
                    'fastest_lap' => $request->input("fastest_lap.$result_id") ? 1 : 0,
                    'total_time' => $request->input("total_time.$result_id"),
                    'race_penalty' => $request->input("race_penalty.$result_id"),
                    'grid_penalty' => $request->input("grid_penalty.$result_id"),
                    'reserve_driver' => $request->input("reserve_driver.$result_id"),
                ]);
        }

        return redirect()->route('admin.leagues.raceResults', [
            'league_id' => $request->input('league_id'),
            'track_id' => $request->input('f1_league_track_id'),
        ])->with('success', 'Sonuçlar başarıyla güncellendi.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'race_id' => 'required|exists:f1_league_tracks,id',
            'driver_id' => 'required|exists:f1_drivers,id',
            'position' => 'required|integer|min:1',
            'points' => 'required|integer|min:0',
        ]);

        DB::table('f1_race_results')->insert([
            'race_id' => $request->input('race_id'),
            'driver_id' => $request->input('driver_id'),
            'position' => $request->input('position'),
            'points' => $request->input('points'),
            'created_at' => now(),
        ]);

        return redirect()->route('adminPanel.leagues.raceResults.index')->with('success', 'Yarış sonucu başarıyla kaydedildi.');
    }
}
