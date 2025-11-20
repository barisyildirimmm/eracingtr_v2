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
            ->whereRaw("DATE_ADD(race_date, INTERVAL ? MINUTE) > ?", [enums()['complaint_time_limit_minutes'], $now])
            ->orderByDesc('race_date')
            ->select('f1_league_tracks.*')
            ->get();

        $tracks = collect();
        $drivers = [];

        foreach ($tracksRaw as $track) {
            $track->track_name = DB::table('f1_tracks')->where('id', $track->track_id)->value('name');
            $track->league_name = DB::table('f1_leagues')->where('id', $track->league_id)->value('name');

            // Kalan şikayet süresini hesapla (yarıştan sonraki 4 saat)
            $raceDate = Carbon::parse($track->race_date);
            $deadline = $raceDate->copy()->addMinutes(enums()['complaint_time_limit_minutes']);
            
            // Kalan süreyi hesapla (yarıştan sonraki 4 saat içinde kalan süre)
            // Şu anki zamandan deadline'a kadar olan süre
            $remainingSeconds = max(0, (int)$deadline->diffInSeconds($now, false));
            $track->remaining_seconds = $remainingSeconds;
            $track->deadline_timestamp = $deadline->timestamp;
            $track->race_date_timestamp = $raceDate->timestamp;

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
                    $deleteTimeLimit = enums()['complaint_delete_time_seconds'];
                    $decision->can_delete = $secondsPassed >= 0 && $secondsPassed < $deleteTimeLimit;
                    $decision->delete_timer = $decision->can_delete ? $deleteTimeLimit - $secondsPassed : 0;
                    $decision->delete_timer_human = gmdate("i:s", $decision->delete_timer);
                    $decision->delete_deadline = $createdAt->addSeconds($deleteTimeLimit)->format('H:i');

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

        // Kalan şikayet hakkını hesapla (lig bazında)
        $leagueId = null;
        if ($tracks->isNotEmpty()) {
            $leagueId = $tracks->first()->league_id;
        }
        
        $complaintCount = 0;
        $remainingComplaints = enums()['complaint_max_count'];
        
        if ($leagueId) {
            $complaintCount = DB::table('referee_decisions')
                ->where('complainant', $driverId)
                ->where('league_id', $leagueId)
                ->count();
            $remainingComplaints = enums()['complaint_max_count'] - $complaintCount;
        }

        return view('driverPanel.refDecisions.complaint', [
            'tracks' => $tracks,
            'drivers' => $drivers,
            'remainingComplaints' => $remainingComplaints,
            'maxComplaints' => enums()['complaint_max_count'],
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
            ->whereRaw("DATE_ADD(f1_league_tracks.race_date, INTERVAL ? MINUTE) > ?", [enums()['defense_time_limit_minutes'], $now])
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

                // Kalan savunma süresini hesapla (şikayetten sonraki 24 saat)
                $complaintDate = Carbon::parse($decision->created_at);
                $defenseDeadline = $complaintDate->copy()->addMinutes(enums()['defense_time_limit_minutes']);
                $remainingSeconds = max(0, (int)$defenseDeadline->diffInSeconds($now, false));
                $newTrack->remaining_seconds = $remainingSeconds;
                $newTrack->deadline_timestamp = $defenseDeadline->timestamp;
                $newTrack->race_date = $track->race_date;

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

        // Yarıştan sonraki 3 güne kadar olan yarışları al
        $leagueTracks = DB::table('f1_league_tracks')
            ->where('referee_decision_complete', 1)
            ->where('race_date', '<=', $now)
            ->whereRaw("DATE_ADD(race_date, INTERVAL ? DAY) > ?", [enums()['appeal_time_limit_days'], $now])
            ->get();

        $appealsData = collect();

        foreach ($leagueTracks as $leagueTrack) {
            $trackName = DB::table('f1_tracks')->where('id', $leagueTrack->track_id)->value('name');
            $leagueName = DB::table('f1_leagues')->where('id', $leagueTrack->league_id)->value('name');

            // Bu yarışa ait tüm şikayetleri al
            $decisions = DB::table('referee_decisions')
                ->where('track_id', $leagueTrack->track_id)
                ->where('league_id', $leagueTrack->league_id)
                ->where(function ($query) use ($driverId) {
                    // Kişiye gelen şikayetler (complained = driverId)
                    $query->where('complained', $driverId)
                    ->orWhere('complainant', $driverId);
                })
                ->get();

            foreach ($decisions as $decision) {
                // Daha önce itiraz yapılmış mı kontrol et
                $existingAppeal = DB::table('referee_appeals')
                    ->where('ref_id', $decision->id)
                    ->where('driver_id', $driverId)
                    ->first();

                if ($existingAppeal) {
                    continue; // Zaten itiraz yapılmış, atla
                }

                $complainant = DB::table('drivers')->where('id', $decision->complainant)->first();
                $complained = DB::table('drivers')->where('id', $decision->complained)->first();

                // Kalan itiraz süresini hesapla (yarıştan sonraki 3 gün)
                $raceDate = Carbon::parse($leagueTrack->race_date);
                $appealDeadline = $raceDate->copy()->addDays(enums()['appeal_time_limit_days']);
                $remainingSeconds = max(0, (int)$appealDeadline->diffInSeconds($now, false));

                $appealItem = (object) [
                    'league_track_id' => $leagueTrack->id,
                    'track_id' => $leagueTrack->track_id,
                    'league_id' => $leagueTrack->league_id,
                    'track_name' => $trackName,
                    'league_name' => $leagueName,
                    'race_date' => $leagueTrack->race_date,
                    'sprint_status' => $leagueTrack->sprint_status,
                    'decision_id' => $decision->id,
                    'complainant_id' => $decision->complainant,
                    'complainant_name' => ($complainant->name ?? 'Bilinmiyor') . ' ' . ($complainant->surname ?? ''),
                    'complained_id' => $decision->complained,
                    'complained_name' => ($complained->name ?? 'Bilinmiyor') . ' ' . ($complained->surname ?? ''),
                    'video_link' => $decision->video_link,
                    'reminder' => $decision->reminder,
                    'comp_video' => $decision->comp_video,
                    'comp_desc' => $decision->comp_desc,
                    'has_complaint' => !empty($decision->video_link) || !empty($decision->reminder),
                    'has_defense' => !empty($decision->comp_video) || !empty($decision->comp_desc),
                    'is_complained_against' => $decision->complained == $driverId, // Kişiye gelen şikayet
                    'is_my_complaint' => $decision->complainant == $driverId, // Kişinin yaptığı şikayet
                    'remaining_seconds' => $remainingSeconds,
                    'deadline_timestamp' => $appealDeadline->timestamp,
                ];

                $appealsData->push($appealItem);
            }
        }

        // Kalan itiraz hakkını hesapla
        $appealCount = DB::table('referee_appeals')->where('driver_id', $driverId)->count();
        $remainingAppeals = enums()['appeal_max_count'] - $appealCount;

        return view('driverPanel.refDecisions.appeal', [
            'appeals' => $appealsData,
            'remainingAppeals' => $remainingAppeals,
            'maxAppeals' => enums()['appeal_max_count'],
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

        $driverId = session('driverInfo')->id;

        // Şikayet hakkı kontrolü (lig bazında)
        $complaintCount = DB::table('referee_decisions')
            ->where('complainant', $driverId)
            ->where('league_id', $request->league_id)
            ->count();
        if ($complaintCount >= enums()['complaint_max_count']) {
            return back()->with('error', __('common.complaint_rights_exhausted', ['max' => enums()['complaint_max_count']]));
        }

        DB::table('referee_decisions')->insert([
            'track_id' => $request->track_id,
            'league_id' => $request->league_id,
            'complainant' => $driverId,
            'complained' => $request->complained,
            'video_link' => $request->video_link,
            'reminder' => $request->reminder,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $deleteTimeMinutes = enums()['complaint_delete_time_seconds'] / 60;
        return back()->with('success', __('common.complaint_sent', ['minutes' => $deleteTimeMinutes]));
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

        return back()->with('success', __('common.defense_sent'));
    }

    public function postAppeal(Request $request)
    {
        $request->validate([
            'ref_id' => 'required|integer',
            'description' => 'required|string',
        ]);

        $driverId = session('driverInfo')->id;

        // İtiraz hakkı kontrolü
        $appealCount = DB::table('referee_appeals')->where('driver_id', $driverId)->count();
        if ($appealCount >= enums()['appeal_max_count']) {
            return back()->with('error', __('common.appeal_rights_exhausted', ['max' => enums()['appeal_max_count']]));
        }

        // Daha önce itiraz yapılmış mı kontrol et
        $existingAppeal = DB::table('referee_appeals')
            ->where('ref_id', $request->ref_id)
            ->where('driver_id', $driverId)
            ->first();

        if ($existingAppeal) {
            return back()->with('error', __('common.appeal_already_exists'));
        }

        // referee_appeals tablosuna kayıt ekle
        DB::table('referee_appeals')->insert([
            'ref_id' => $request->ref_id,
            'driver_id' => $driverId,
            'description' => $request->description
        ]);

        return back()->with('success', __('common.appeal_sent'));
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

            if ($secondsPassed >= 0 && $secondsPassed < enums()['complaint_delete_time_seconds']) {
                DB::table('referee_decisions')->where('id', $id)->delete();
                return back()->with('success', __('common.complaint_deleted'));
            }
        }

        return back()->with('error', __('common.complaint_delete_failed'));
    }
}
