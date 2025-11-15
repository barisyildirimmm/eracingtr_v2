<?php

namespace App\Http\Controllers\driverPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class refDecisionController extends Controller
{
    public function showComplaints()
    {
        $driverId = session('driverInfo')->id;
        $now = now();

        // 30 saatlik süre içinde olan tüm pistleri al
        $tracksRaw = DB::table('f1_league_tracks')
            ->join('f1_league_drivers', function ($join) use ($driverId) {
                $join->on('f1_league_tracks.league_id', '=', 'f1_league_drivers.league_id')
                    ->where('f1_league_drivers.driver_id', '=', $driverId);
            })
            ->where('race_date', '<=', $now)
            ->whereRaw("DATE_ADD(race_date, INTERVAL 240 MINUTE) > ?", [$now])
            ->orderByDesc('race_date')
            ->select('f1_league_tracks.*')
            ->get();

        $tracks = collect();
        $drivers = [];

        foreach ($tracksRaw as $track) {
            $track->track_name = DB::table('f1_tracks')->where('id', $track->track_id)->value('name');
            $track->league_name = DB::table('f1_leagues')->where('id', $track->league_id)->value('name');

            // ❗ track_id yerine $track->id kullanılıyor
            $track->previous_decisions = DB::table('referee_decisions')
                ->where('track_id', $track->track_id)
                ->where('league_id', $track->league_id)
                ->where('complainant', $driverId)
                ->orderByDesc('id')
                ->get()
                ->map(function ($decision) {
                    $driver = DB::table('drivers')->where('id', $decision->complained)->first();
                    $decision->complained_name = ($driver->name ?? 'Bilinmiyor') . ' ' . ($driver->surname ?? '');

                    $createdAt = Carbon::parse($decision->created_at);
                    $secondsPassed = $createdAt->diffInSeconds(now(), false);
                    $decision->can_delete = $secondsPassed >= 0 && $secondsPassed < 600;
                    $decision->delete_timer = $decision->can_delete ? 600 - $secondsPassed : 0;
                    $decision->delete_timer_human = gmdate("i:s", $decision->delete_timer);
                    $decision->delete_deadline = $createdAt->addSeconds(600)->format('H:i');

                    return $decision;
                });

            $tracks->push($track);

            // sürücüler sadece bir kez alınır
            if (empty($drivers)) {
                $drivers = DB::table('f1_league_drivers')
                    ->join('drivers', 'f1_league_drivers.driver_id', '=', 'drivers.id')
                    ->where('f1_league_drivers.league_id', $track->league_id)
                    ->where('drivers.id', '!=', $driverId)
                    ->select('drivers.id', 'drivers.name', 'drivers.surname')
                    ->get();
            }
            $addDriver = (object) [
                'id' => 1003,
                'name' => 'Oyun',
                'surname' => 'Cezası',
            ];
            $drivers->push($addDriver);
        }

        return view('driverPanel.refDecisions.complaint', [
            'tracks' => $tracks,
            'drivers' => $drivers,
        ]);
    }

    public function showDefenses()
    {
        $driverId = session('driverInfo')->id;
        $now = now();

        $track = DB::table('f1_league_tracks')
            ->join('f1_league_drivers', function ($join) use ($driverId) {
                $join->on('f1_league_tracks.league_id', '=', 'f1_league_drivers.league_id')
                    ->where('f1_league_drivers.driver_id', '=', $driverId);
            })
            ->where('f1_league_tracks.race_date', '<=', $now)
            ->whereRaw("DATE_ADD(f1_league_tracks.race_date, INTERVAL 1440 MINUTE) > ?", [$now])
            ->orderByDesc('f1_league_tracks.race_date')
            ->select('f1_league_tracks.*')
            ->first();

        $tracks = collect();

        if ($track) {
            $trackName = DB::table('f1_tracks')->where('id', $track->track_id)->value('name');
            $leagueName = DB::table('f1_leagues')->where('id', $track->league_id)->value('name');

            $decisions = DB::table('referee_decisions')
                ->where('track_id', $track->track_id)
                ->where('league_id', $track->league_id)
                ->where('complained', $driverId)
                ->get();

            foreach ($decisions as $decision) {
                $newTrack = clone $track;
                $newTrack->track_name = $trackName;
                $newTrack->league_name = $leagueName;
                $newTrack->decision_id = $decision->id;
                $newTrack->video_link = $decision->video_link;
                $newTrack->reminder = $decision->reminder;
                $newTrack->comp_video = $decision->comp_video;
                $newTrack->comp_desc = $decision->comp_desc;

                $complainant = DB::table('drivers')->where('id', $decision->complainant)->first();
                $newTrack->complainant_name = ($complainant->name ?? 'Bilinmiyor') . ' ' . ($complainant->surname ?? '');

                $newTrack->has_defense = !empty($decision->comp_video) || !empty($decision->comp_desc);

                $tracks->push($newTrack);
            }
        }

        return view('driverPanel.refDecisions.defense', [
            'tracks' => $tracks,
        ]);
    }

    public function showAppeals()
    {
        $driverId = session('driverInfo')->id;
        $now = now();

        $tracks = DB::table('f1_league_tracks')
            ->join('referee_decisions', 'f1_league_tracks.id', '=', 'referee_decisions.track_id')
            ->where('referee_decisions.complained', $driverId)
            ->where('f1_league_tracks.referee_decision_complete', 1)
            ->whereRaw("DATE_ADD(race_date, INTERVAL 3 DAY) > ?", [$now])
            ->select('f1_league_tracks.*', 'referee_decisions.id as decision_id')
            ->get()
            ->map(function ($track) {
                $track->track_name = DB::table('f1_tracks')->where('id', $track->track_id)->value('name');
                $track->league_name = DB::table('f1_leagues')->where('id', $track->league_id)->value('name');
                return $track;
            });

        return view('driverPanel.refDecisions.appeal', [
            'tracks' => $tracks,
        ]);
    }

    public function postComplaint(Request $request)
    {
        $request->validate([
            'track_id' => 'required|integer',
            'league_id' => 'required|integer',
            'complained' => 'required|integer',
            'video_link' => 'required|url',
            'reminder' => 'required|string',
        ]);

        DB::table('referee_decisions')->insert([
            'track_id' => $request->track_id,
            'league_id' => $request->league_id,
            'complainant' => session('driverInfo')->id,
            'complained' => $request->complained,
            'video_link' => $request->video_link,
            'reminder' => $request->reminder,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Şikayetiniz gönderildi. İlk 10 dakika içerisinde iptal edebilirsiniz.');
    }

    public function postDefense(Request $request)
    {
        $request->validate([
            'decision_id' => 'required|integer',
            'comp_video' => 'required|url',
            'comp_desc' => 'required|string',
        ]);

        DB::table('referee_decisions')->where('id', $request->decision_id)->update([
            'comp_video' => $request->comp_video,
            'comp_desc' => $request->comp_desc,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Savunmanız gönderildi.');
    }

    public function postAppeal(Request $request)
    {
        $request->validate([
            'decision_id' => 'required|integer',
            'appeal_video' => 'required|url',
            'appeal_desc' => 'required|string',
        ]);

        DB::table('referee_decisions')->where('id', $request->decision_id)->update([
            'appeal_video' => $request->appeal_video,
            'appeal_desc' => $request->appeal_desc,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'İtirazınız gönderildi.');
    }

    public function deleteComplaint($id)
    {
        $driverId = session('driverInfo')->id;

        $decision = DB::table('referee_decisions')
            ->where('id', $id)
            ->where('complainant', $driverId)
            ->first();

        if ($decision) {
            $created = Carbon::parse($decision->created_at);
            $secondsPassed = $created->diffInSeconds(now(), false);

            if ($secondsPassed >= 0 && $secondsPassed < 600) {
                DB::table('referee_decisions')->where('id', $id)->delete();
                return back()->with('success', 'Şikayet başarıyla silindi.');
            }
        }

        return back()->with('error', 'Şikayet silinemedi veya süresi geçti.');
    }
}
