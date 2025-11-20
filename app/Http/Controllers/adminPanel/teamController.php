<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class teamController extends Controller
{
    public function listTeams()
    {
        $teams = DB::table('f1_teams')->select('id', 'name')->get();
        return view('adminPanel.teams.list', ['teams' => $teams]);
    }

    public function createTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ], [
            'name.required' => __('common.name_required')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        DB::table('f1_teams')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.team_created')
        ]);
    }

    public function editTeam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:50',
        ], [
            'name.required' => __('common.name_required')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        $updateData = array_filter([
            'name' => $request->name,
            'updated_at' => now()
        ]);

        DB::table('f1_teams')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.team_updated')
        ]);
    }

    public function deleteTeam($id)
    {
        $team = DB::table('f1_teams')->where('id', $id)->first();

        if (!$team) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.team_not_found')
            ]);
        }

        DB::table('f1_teams')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.team_deleted')
        ]);
    }
}