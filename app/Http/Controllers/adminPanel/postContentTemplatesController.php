<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class postContentTemplatesController extends Controller
{
    public function listPostContents(){
        return view('adminPanel.postContents.list');
    }

    public function imgProxy(Request $r) {
        $url = $r->query('url');
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid URL');
        }
        $res = Http::timeout(10)->withHeaders([
            'User-Agent' => 'Mozilla/5.0',
            'Accept' => 'image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
        ])->get($url);

        if (!$res->ok()) abort(404, 'Image not found');

        return response($res->body(), 200)->header('Content-Type', $res->header('Content-Type') ?: 'image/png')
            ->header('Cache-Control', 'public, max-age=86400');
    }

    public function poleGorseli()
    {
        $drivers = DB::table('drivers')
            ->select('id','name','surname')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $tracks = DB::table('f1_tracks')
            ->select('id','name')
            ->where('status', 1)
            ->orderBy('rank')
            ->orderBy('name')
            ->get();

        $teams = DB::table('f1_teams')
            ->select('id','name')
            ->where('status', 1)
            ->orderBy('rank')
            ->orderBy('name')
            ->get();

        return view('adminPanel.postContents.pole', compact('drivers','tracks','teams'));
    }

    public function podiumGorseli(){
        $drivers = DB::table('drivers')
            ->select('id','name','surname')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $tracks = DB::table('f1_tracks')
            ->select('id','name')
            ->where('status', 1)
            ->orderBy('rank')
            ->get();

        return view('adminPanel.postContents.podium', compact('drivers','tracks'));
    }

    public function kazananGorseli(){
        return view('adminPanel.postContents.winner');
    }
    public function puanTablosuGorseli(){
        return view('adminPanel.postContents.standing');
    }
}