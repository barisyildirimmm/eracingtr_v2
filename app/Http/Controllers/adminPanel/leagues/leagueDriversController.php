<?php

namespace App\Http\Controllers\adminPanel\leagues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class leagueDriversController extends Controller
{
    public function listLeagueDrivers($id)
    {
        $leagueDriverIds = DB::table('f1_league_drivers')
            ->where('league_id', $id)
            ->pluck('driver_id')
            ->toArray();

        $drivers = DB::table('f1_league_drivers')
        ->join('drivers', 'f1_league_drivers.driver_id', '=', 'drivers.id')
        ->leftJoin('f1_teams', 'f1_league_drivers.team_id', '=', 'f1_teams.id')
        ->select('f1_league_drivers.id as league_driver_id', 'f1_league_drivers.driver_id', 'f1_league_drivers.team_id', 'drivers.name', 'drivers.surname', 'drivers.phone', 'f1_teams.name as team_name')
        ->where('f1_league_drivers.league_id', $id)
        ->orderBy('drivers.name', 'asc')
        ->get();

        $allDrivers = DB::table('drivers')
            ->where('status', 1)
            ->whereNotIn('id', $leagueDriverIds)
            ->orderBy('name', 'asc')
            ->get();

        $teams = DB::table('f1_teams')->select('id', 'name')->where('status', 1)->orderBy('name', 'asc')->get();

        return view('adminPanel.leagues.leagueDrivers.list', ['drivers' => $drivers, 'leagueId' => $id, 'allDrivers' => $allDrivers, 'teams' => $teams]);
    }
    public function addDriversToLeague(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league_id' => 'required|integer',
            'driver_ids' => 'required|array',
            'driver_ids.*' => 'required|integer'
        ], [
            'league_id.required' => 'Lig alanı zorunludur.',
            'league_id.integer' => 'Lig alanı geçersiz formatta.',
            'driver_ids.required' => 'Pilotlar alanı zorunludur.',
            'driver_ids.array' => 'Pilotlar alanı geçersiz formatta.',
            'driver_ids.*.required' => 'Pilot alanı zorunludur.',
            'driver_ids.*.integer' => 'Pilot alanı geçersiz formatta.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.invalid_data')
            ]);
        }

        $validatedData = $validator->validated();

        $leagueId = $validatedData['league_id'];
        $driverIds = $validatedData['driver_ids'];

        try {
            DB::beginTransaction();

            $leagueTracks = DB::table('f1_league_tracks')->select('id', 'track_id', 'sprint_status')->where('league_id', $leagueId)->get()->toArray();

            foreach ($driverIds as $driverId) {
                $exists = DB::table('f1_league_drivers')
                    ->where('league_id', $leagueId)
                    ->where('driver_id', $driverId)
                    ->exists();

                if (!$exists) {
                    DB::table('f1_league_drivers')->insert([
                        'league_id' => $leagueId,
                        'driver_id' => $driverId,
                    ]);

                    foreach ($leagueTracks as $leagueTrack) {
                        DB::table('f1_race_results')->insert([
                            'league_id' => $leagueId,
                            'f1_league_track_id' => $leagueTrack->id,
                            'driver_id' => $driverId,
                            'track_id' => $leagueTrack->track_id,
                            'sprint_status' => $leagueTrack->sprint_status,
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.drivers_added')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'hata' => 1,
                'aciklama' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ]);
        }
    }

    public function removeDriversFromLeague(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league_id' => 'required|integer',
            'driver_ids' => 'required|array',
            'driver_ids.*' => 'required|integer'
        ], [
            'league_id.required' => 'Lig alanı zorunludur.',
            'league_id.integer' => 'Lig alanı geçersiz formatta.',
            'driver_ids.required' => 'Pilotlar alanı zorunludur.',
            'driver_ids.array' => 'Pilotlar alanı geçersiz formatta.',
            'driver_ids.*.required' => 'Pilot alanı zorunludur.',
            'driver_ids.*.integer' => 'Pilot alanı geçersiz formatta.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.invalid_data')
            ]);
        }

        $validatedData = $validator->validated();

        $leagueId = $validatedData['league_id'];
        $driverIds = $validatedData['driver_ids'];

        try {
            DB::beginTransaction();

            DB::table('f1_league_drivers')
                ->where('league_id', $leagueId)
                ->whereIn('driver_id', $driverIds)
                ->delete();

            DB::table('f1_race_results')
                ->where('league_id', $leagueId)
                ->whereIn('driver_id', $driverIds)
                ->delete();

            DB::commit();
            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.drivers_removed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'hata' => 1,
                'aciklama' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ]);
        }
    }

    public function updateDriverTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league_id' => 'required|integer',
            'driver_id' => 'required|integer',
            'team_id' => 'nullable|integer'
        ], [
            'league_id.required' => __('common.league_id_required'),
            'league_id.integer' => __('common.league_id_integer'),
            'driver_id.required' => __('common.driver_id_required'),
            'driver_id.integer' => __('common.driver_id_integer'),
            'team_id.integer' => __('common.team_id_integer'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.invalid_data')
            ]);
        }

        $validatedData = $validator->validated();

        $leagueId = $validatedData['league_id'];
        $driverId = $validatedData['driver_id'];
        $teamId = $validatedData['team_id'] ?? null;

        try {
            DB::table('f1_league_drivers')
                ->where('league_id', $leagueId)
                ->where('driver_id', $driverId)
                ->update([
                    'team_id' => $teamId
                ]);

            $teamName = null;
            if ($teamId) {
                $team = DB::table('f1_teams')->select('name')->where('status', 1)->where('id', $teamId)->where('status', 1)->first();
                $teamName = $team ? $team->name : null;
            }
            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.team_updated'),
                'team_name' => $teamName,
                'team_id' => $teamId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ]);
        }
    }
}
