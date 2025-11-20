<?php

namespace App\Http\Controllers\adminPanel\leagues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class leagueTracksController extends Controller
{
    public function listLeaguesTracks($id)
    {
        $leagueTracks = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->select('f1_league_tracks.id', 'f1_tracks.name', 'f1_league_tracks.sprint_status', 'f1_league_tracks.qualifying_type', 'f1_league_tracks.race_date', 'f1_league_tracks.track_id' )
            ->where('f1_league_tracks.league_id', $id)
            ->orderBy('f1_league_tracks.race_date', 'desc')
            ->get();
            
        foreach ($leagueTracks as $leagueTrack) {
            $leagueTrack->race_dateOrj = date('Y-m-d H:i:s', strtotime($leagueTrack->race_date));
            $leagueTrack->race_time = date('H:i', strtotime($leagueTrack->race_dateOrj));
            $leagueTrack->race_date = date('Y-m-d', strtotime($leagueTrack->race_dateOrj));
        }
        
        $allTracks = DB::table('f1_tracks')->get();

        return view('adminPanel.leagues.leagueTracks.list', ['allTracks' => $allTracks, 'leagueTracks' => $leagueTracks, 'leagueId' => $id]);
    }
    public function createLeagueTrack(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league_id' => 'required|exists:f1_leagues,id',
            'track_id' => 'required|exists:f1_tracks,id',
            'race_date' => 'required|date',
            'race_time' => 'required|string',
            'sprint_status' => 'boolean',
            'qualifying_type' => 'required|integer|in:0,1',
        ], [
            'league_id.required' => __('common.league_id_required'),
            'league_id.exists' => __('common.league_id_exists'),
            'track_id.required' => __('common.track_id_required'),
            'track_id.exists' => __('common.track_id_exists'),
            'race_date.required' => __('common.race_date_required'),
            'race_date.date' => __('common.race_date_date'),
            'race_time.required' => __('common.race_time_required'),
            'race_time.string' => __('common.race_time_string'),
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }
        $validatedData = $validator->validated();

        $validatedData['race_date'] = date('Y-m-d H:i:s', strtotime($validatedData['race_date'] . ' ' . $validatedData['race_time']));
        unset($validatedData['race_time']);

        if(isset($validatedData['sprint_status'])) {
            $sprintStatus = 1;
        } else {
            $sprintStatus = 0;
        }

        $existingTrack = DB::table('f1_league_tracks')
            ->where('league_id', $request->league_id)
            ->where('track_id', $request->track_id)
            ->where('sprint_status', $sprintStatus)
            ->first();

        if ($existingTrack) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.track_exists_error')
            ]);
        }

        try {
            DB::beginTransaction();
            $insertedTrack = DB::table('f1_league_tracks')->insertGetId([
                'league_id' => $validatedData['league_id'],
                'track_id' => $validatedData['track_id'],
                'race_date' => $validatedData['race_date'],
                'sprint_status' => $sprintStatus,
                'qualifying_type' => $validatedData['qualifying_type'],
            ]);

            $leagueDrivers = DB::table('f1_league_drivers')->where('league_id', $validatedData['league_id'])->get()->pluck('driver_id')->toArray();
            
            foreach ($leagueDrivers as $driverId) {
                DB::table('f1_race_results')->insert([
                    'league_id' => $validatedData['league_id'],
                    'f1_league_track_id' => $insertedTrack,
                    'driver_id' => $driverId,
                    'track_id' => $validatedData['track_id'],
                    'sprint_status' => $sprintStatus,
                ]);
            }

            DB::table('log_league')->insert([
                'text' => 'Lig ID: ' . $validatedData['league_id'] . ' - Pist ID: ' . $insertedTrack . ' - Eklendi',
                'admin_id' => session('adminInfo')->id,
                'action' => 'add',
            ]);

            DB::commit();

            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.track_created')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }
    public function editLeagueTrack(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:f1_league_tracks,id',
            'race_date' => 'required|date',
            'race_time' => 'required|string',
            'qualifying_type' => 'required|integer|in:0,1',
        ], [
            'id.required' => 'Lig pisti alanı zorunludur.',
            'id.exists' => 'Bu lig pisti mevcut değil.',
            'race_date.required' => 'Yarış tarihi alanı zorunludur.',
            'race_date.date' => 'Yarış tarihi geçersiz formatta.',
            'race_time.required' => 'Yarış saati alanı zorunludur.',
            'race_time.string' => 'Yarış saati geçersiz formatta.',
            'qualifying_type.required' => 'Qualifying tipi alanı zorunludur.',
            'qualifying_type.integer' => 'Qualifying tipi geçersiz formatta.',
            'qualifying_type.in' => 'Qualifying tipi geçersiz değer.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }
        $validatedData = $validator->validated();
        $validatedData['race_date'] = date('Y-m-d H:i:s', strtotime($validatedData['race_date'] . ' ' . $validatedData['race_time']));
        unset($validatedData['race_time']);

        try {
            DB::beginTransaction();
            DB::table('f1_league_tracks')->where('id', $validatedData['id'])->update($validatedData);
            DB::commit();
            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.track_updated')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }
    
    public function deleteLeagueTrack(Request $request)
    {
        $track = DB::table('f1_league_tracks')->where('id', $request->id)->first();
        if (!$track) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.track_not_found')
            ]);
        }

        $previousRaceInfos = DB::table('f1_race_results' )->where('league_id', $track->league_id)->where('f1_league_track_id', $request->id)->get();
        
        $logData = [
            'text' => 'Lig ID: ' . $track->league_id . ' - Pist ID: ' . $track->id . ' - Silindi - Geçmiş yarış Bilgileri: ' . json_encode($previousRaceInfos),
            'admin_id' => session('adminInfo')->id,
            'action' => 'delete',
        ];
        try {
            DB::beginTransaction();
            DB::table('f1_league_tracks')->where('id', $request->id)->delete();
            DB::table('f1_race_results')->where('f1_league_track_id', $request->id)->where('league_id', $track->league_id)->delete();
            DB::table('log_league')->insert($logData);
            DB::commit();
            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.track_deleted')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }

    }

    public function listRaceVideos($id)
    {
        $leagueTracks = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->select('f1_league_tracks.id', 'f1_tracks.name', 'f1_league_tracks.sprint_status', 'f1_league_tracks.race_date', 'f1_league_tracks.race_video')
            ->where('f1_league_tracks.league_id', $id)
            ->orderBy('f1_league_tracks.race_date', 'desc')
            ->get();
            
        foreach ($leagueTracks as $leagueTrack) {
            $leagueTrack->race_dateOrj = date('Y-m-d H:i:s', strtotime($leagueTrack->race_date));
            $leagueTrack->race_date_formatted = date('d.m.Y', strtotime($leagueTrack->race_dateOrj));
        }

        return view('adminPanel.leagues.leagueTracks.raceVideos', ['leagueTracks' => $leagueTracks, 'leagueId' => $id]);
    }

    public function updateRaceVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league_track_id' => 'required|integer|exists:f1_league_tracks,id',
            'race_video' => 'nullable|string|url|max:500',
        ], [
            'league_track_id.required' => __('common.league_track_id_required'),
            'league_track_id.integer' => __('common.league_track_id_integer'),
            'league_track_id.exists' => __('common.league_track_id_exists'),
            'race_video.url' => __('common.race_video_url'),
            'race_video.max' => __('common.race_video_max'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }
        $validatedData = $validator->validated();

        try {
            DB::table('f1_league_tracks')
                ->where('id', $validatedData['league_track_id'])
                ->update([
                    'race_video' => $validatedData['race_video']
                ]);

            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.race_video_updated')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }
}