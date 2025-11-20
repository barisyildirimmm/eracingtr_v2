<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class leagueController extends Controller
{
    public function listLeagues()
    {
        $leagues = DB::table('f1_leagues')->get();
        $tracks = DB::table('f1_tracks')->select('id', 'name')->orderBy('name', 'asc')->get();
        return view('adminPanel.leagues.list', ['leagues' => $leagues, 'tracks' => $tracks]);
    }

    public function createLeague(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'link' => 'required|string|max:200|unique:f1_leagues,link',
            'rank' => 'required|integer',
            'point_rate' => 'required|integer',
            'reserve_driver_point' => 'required|integer',
            'reserve_driver_team_point' => 'required|integer',
        ], [
            'name.required' => __('common.name_required'),
            'status.required' => __('common.status_required'),
            'link.required' => __('common.link_required'),
            'link.unique' => __('common.link_unique'),
            'rank.required' => __('common.rank_required'),
            'point_rate.required' => __('common.point_rate_required'),
            'reserve_driver_point.required' => __('common.reserve_driver_point_required'),
            'reserve_driver_team_point.required' => __('common.reserve_driver_team_point_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        DB::table('f1_leagues')->insert([
            'name' => $request->name,
            'status' => $request->status,
            'link' => $request->link,
            'rank' => $request->rank,
            'point_rate' => $request->point_rate,
            'reserve_driver_point' => $request->reserve_driver_point,
            'reserve_driver_team_point' => $request->reserve_driver_team_point,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.league_created')
        ]);
    }

    public function editLeague(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'link' => 'required|string|max:200|unique:f1_leagues,link,' . $id,
            'rank' => 'required|integer',
            'point_rate' => 'required|integer',
            'editReserveDriverPoint' => 'required|integer',
            'editReserveDriverTeamPoint' => 'required|integer',
            'tryouts_visibility' => 'nullable|integer',
            'tryouts_track_id' => 'nullable|integer|exists:f1_tracks,id',
        ], [
            'name.required' => __('common.name_required'),
            'status.required' => __('common.status_required'),
            'link.required' => __('common.link_required'),
            'link.unique' => __('common.link_unique'),
            'rank.required' => __('common.rank_required'),
            'point_rate.required' => __('common.point_rate_required'),
            'editReserveDriverPoint.required' => __('common.reserve_driver_point_required'),
            'editReserveDriverTeamPoint.required' => __('common.reserve_driver_team_point_required'),
            'tryouts_track_id.exists' => __('common.track_not_found')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        $updateData = [
            'name' => $request->name,
            'status' => $request->status,
            'link' => $request->link,
            'rank' => $request->rank,
            'point_rate' => $request->point_rate,
            'reserve_driver_point' => $request->editReserveDriverPoint,
            'reserve_driver_team_point' => $request->editReserveDriverTeamPoint,
            'tryouts_visibility' => $request->tryouts_visibility ?? 0,
        ];

        // tryouts_track_id sadece değer varsa ekle
        if ($request->has('tryouts_track_id') && $request->tryouts_track_id !== null && $request->tryouts_track_id !== '') {
            $updateData['tryouts_track_id'] = $request->tryouts_track_id;
        } else {
            $updateData['tryouts_track_id'] = null;
        }

        DB::table('f1_leagues')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.league_updated')
        ]);
    }

    public function deleteLeague($id)
    {
        $league = DB::table('f1_leagues')->where('id', $id)->first();

        if (!$league) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.league_not_found')
            ]);
        }

        DB::table('f1_leagues')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.league_deleted')
        ]);
    }
}
