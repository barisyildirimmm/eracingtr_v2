<?php

namespace App\Http\Controllers\adminPanel\leagues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class refereeController extends Controller
{
    public function index()
    {
        $refereeDecisions = DB::table('f1_referee_decisions')
            ->join('f1_league_tracks', 'f1_referee_decisions.track_id', '=', 'f1_league_tracks.id')
            ->select('f1_referee_decisions.*', 'f1_league_tracks.track_id')
            ->get();

        return view('adminPanel.leagues.referee.index', compact('refereeDecisions'));
    }

    public function create()
    {
        $tracks = DB::table('f1_league_tracks')->get();

        return view('adminPanel.leagues.referee.create', compact('tracks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'track_id' => 'required|exists:f1_league_tracks,id',
            'decision' => 'required|string|max:255',
        ]);

        DB::table('f1_referee_decisions')->insert([
            'track_id' => $request->input('track_id'),
            'decision' => $request->input('decision'),
            'created_at' => now(),
        ]);

        return redirect()->route('adminPanel.leagues.referee.index')->with('success', 'Hakem kararı başarıyla kaydedildi.');
    }
}
