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
        return view('adminPanel.leagues.list', ['leagues' => $leagues]);
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
            'name.required' => 'Adı alanı zorunludur.',
            'status.required' => 'Durum alanı zorunludur.',
            'link.required' => 'Bağlantı alanı zorunludur.',
            'link.unique' => 'Bu bağlantı zaten kullanılmış.',
            'rank.required' => 'Rank alanı zorunludur.',
            'point_rate.required' => 'Puan oranı alanı zorunludur.',
            'reserve_driver_point.required' => 'Yedek sürücü puanı alanı zorunludur.',
            'reserve_driver_team_point.required' => 'Yedek takım puanı alanı zorunludur.',
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
            'aciklama' => 'Lig başarıyla oluşturuldu.'
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
        ], [
            'name.required' => 'Adı alanı zorunludur.',
            'status.required' => 'Durum alanı zorunludur.',
            'link.required' => 'Bağlantı alanı zorunludur.',
            'link.unique' => 'Bu bağlantı zaten kullanılmış.',
            'rank.required' => 'Rank alanı zorunludur.',
            'point_rate.required' => 'Puan oranı alanı zorunludur.',
            'editReserveDriverPoint.required' => 'Yedek sürücü puanı alanı zorunludur.',
            'editReserveDriverTeamPoint.required' => 'Yedek takım puanı alanı zorunludur.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        $updateData = array_filter([
            'name' => $request->name,
            'status' => $request->status,
            'link' => $request->link,
            'rank' => $request->rank,
            'point_rate' => $request->point_rate,
            'reserve_driver_point' => $request->editReserveDriverPoint,
            'reserve_driver_team_point' => $request->editReserveDriverTeamPoint,
        ], function ($value) {
            return $value !== null; // `null` değerlerini kaldırır, ancak `0` gibi değerleri bırakır.
        });

        DB::table('f1_leagues')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Lig başarıyla güncellendi.'
        ]);
    }

    public function deleteLeague($id)
    {
        $league = DB::table('f1_leagues')->where('id', $id)->first();

        if (!$league) {
            return response()->json([
                'hata' => 1,
                'aciklama' => 'Lig bulunamadı.'
            ]);
        }

        DB::table('f1_leagues')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Lig başarıyla silindi.'
        ]);
    }
}
