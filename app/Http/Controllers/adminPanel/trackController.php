<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class trackController extends Controller
{
    public function listTracks()
    {
        $tracks = DB::table('f1_tracks')->select('id', 'name')->get();
        return view('adminPanel.tracks.list', ['tracks' => $tracks]);
    }

    public function createTrack(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
        ], [
            'name.required' => 'Adı alanı zorunludur.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        DB::table('f1_tracks')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Pist başarıyla oluşturuldu.'
        ]);
    }

    public function editTrack(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:200',
        ], [
            'name.required' => 'Adı alanı zorunludur.'
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

        DB::table('f1_tracks')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Pist başarıyla güncellendi.'
        ]);
    }

    public function deleteTrack($id)
    {
        $track = DB::table('f1_tracks')->where('id', $id)->first();

        if (!$track) {
            return response()->json([
                'hata' => 1,
                'aciklama' => 'Pist bulunamadı.'
            ]);
        }

        DB::table('f1_tracks')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Pist başarıyla silindi.'
        ]);
    }
}