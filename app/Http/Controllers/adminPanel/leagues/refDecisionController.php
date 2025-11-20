<?php

namespace App\Http\Controllers\adminPanel\leagues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\text;

class refDecisionController extends Controller
{
    public function listRefDecisions($id)
    {
        // Ligdeki tüm yarışları al
        $leagueTracks = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->select('f1_league_tracks.id as league_track_id', 'f1_league_tracks.track_id', 'f1_league_tracks.race_date', 'f1_league_tracks.sprint_status', 'f1_tracks.name as track_name')
            ->where('f1_league_tracks.league_id', $id)
            ->orderBy('f1_league_tracks.race_date', 'desc')
            ->get();

        // Her yarış için şikayet, savunma ve itiraz sayılarını al
        foreach ($leagueTracks as $track) {
            $track->race_date_formatted = date('d.m.Y', strtotime($track->race_date));
            
            // Bu yarışa ait tüm hakem kararlarını al
            $decisions = DB::table('referee_decisions')
                ->where('track_id', $track->track_id)
                ->where('league_id', $id)
                ->get();

            $complaintCount = 0;
            $defenseCount = 0;
            $appealCount = 0;

            foreach ($decisions as $decision) {
                // Şikayet var mı?
                if (!empty($decision->video_link) || !empty($decision->reminder)) {
                    $complaintCount++;
                }

                // Savunma var mı?
                if (!empty($decision->comp_video) || !empty($decision->comp_desc)) {
                    $defenseCount++;
                }

                // İtirazlar
                $appeals = DB::table('referee_appeals')
                    ->where('ref_id', $decision->id)
                    ->count();
                $appealCount += $appeals;
            }

            $track->complaint_count = $complaintCount;
            $track->defense_count = $defenseCount;
            $track->appeal_count = $appealCount;
        }

        // Pilot bazlı toplam ceza puanlarını hesapla
        $driverPenaltyPoints = DB::table('referee_decisions')
            ->join('drivers', 'referee_decisions.complained', '=', 'drivers.id')
            ->select(
                'drivers.id',
                'drivers.name',
                'drivers.surname',
                DB::raw('SUM(COALESCE(referee_decisions.penalty_point, 0)) as total_penalty_points'),
                DB::raw('COUNT(referee_decisions.id) as total_decisions')
            )
            ->where('referee_decisions.league_id', $id)
            ->whereNotNull('referee_decisions.penalty_point')
            ->where('referee_decisions.penalty_point', '>', 0)
            ->groupBy('drivers.id', 'drivers.name', 'drivers.surname')
            ->havingRaw('SUM(COALESCE(referee_decisions.penalty_point, 0)) > 0')
            ->orderBy('total_penalty_points', 'desc')
            ->get();

        // Her pilot için detaylı ceza bilgilerini al
        foreach ($driverPenaltyPoints as $driver) {
            $penaltyDetails = DB::table('referee_decisions')
                ->join('f1_league_tracks', function($join) use ($id) {
                    $join->on('referee_decisions.track_id', '=', 'f1_league_tracks.track_id')
                         ->where('f1_league_tracks.league_id', '=', $id);
                })
                ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
                ->join('drivers as complainant_driver', 'referee_decisions.complainant', '=', 'complainant_driver.id')
                ->select(
                    'f1_tracks.name as track_name',
                    'f1_league_tracks.race_date',
                    'referee_decisions.penalty_point',
                    'referee_decisions.penalty',
                    'referee_decisions.id as decision_id',
                    DB::raw("CONCAT(complainant_driver.name, ' ', complainant_driver.surname) as complainant_name")
                )
                ->where('referee_decisions.complained', $driver->id)
                ->where('referee_decisions.league_id', $id)
                ->whereNotNull('referee_decisions.penalty_point')
                ->where('referee_decisions.penalty_point', '>', 0)
                ->orderBy('f1_league_tracks.race_date', 'desc')
                ->get();

            $driver->penalty_details = $penaltyDetails;
        }

        return view('adminPanel.leagues.refDecisions.list', [
            'leagueTracks' => $leagueTracks, 
            'leagueId' => $id,
            'driverPenaltyPoints' => $driverPenaltyPoints
        ]);
    }

    public function showTrackDecisions($leagueId, $trackId)
    {
        // Yarış bilgilerini al
        $track = DB::table('f1_league_tracks')
            ->join('f1_tracks', 'f1_league_tracks.track_id', '=', 'f1_tracks.id')
            ->select('f1_league_tracks.id as league_track_id', 'f1_league_tracks.track_id', 'f1_league_tracks.race_date', 'f1_league_tracks.sprint_status', 'f1_tracks.name as track_name')
            ->where('f1_league_tracks.id', $trackId)
            ->where('f1_league_tracks.league_id', $leagueId)
            ->first();

        if (!$track) {
            abort(404);
        }

        $track->race_date_formatted = date('d.m.Y', strtotime($track->race_date));
        
        // Bu yarışa ait tüm hakem kararlarını al
        $decisions = DB::table('referee_decisions')
            ->where('track_id', $track->track_id)
            ->where('league_id', $leagueId)
            ->orderBy('created_at', 'desc')
            ->get();

        $complaints = [];

        foreach ($decisions as $decision) {
            // Sadece şikayetleri al (şikayet + savunma birleştirilmiş)
            if (!empty($decision->video_link) || !empty($decision->reminder)) {
                $complainant = DB::table('drivers')->where('id', $decision->complainant)->first();
                $complained = DB::table('drivers')->where('id', $decision->complained)->first();

                // Bu karar için yorumları al
                $comments = DB::table('referee_comments')
                    ->where('ref_decisions_id', $decision->id)
                    ->get()
                    ->map(function($comment) {
                        $driver = DB::table('drivers')->where('id', $comment->user_id)->first();
                        $userName = 'Bilinmiyor';
                        if ($driver) {
                            $name = trim(($driver->name ?? '') . ' ' . ($driver->surname ?? ''));
                            $userName = $name ?: 'Bilinmiyor';
                        }
                        
                        // Ceza bilgilerini al
                        $penaltyName = null;
                        $penaltyDescName = null;
                        if ($comment->penalty_id) {
                            $penalty = DB::table('penalties')->where('id', $comment->penalty_id)->first();
                            $penaltyName = $penalty ? $penalty->name : null;
                        }
                        if ($comment->penalty_desc_id) {
                            $penaltyDesc = DB::table('penalty_desc')->where('id', $comment->penalty_desc_id)->first();
                            $penaltyDescName = $penaltyDesc ? $penaltyDesc->name : null;
                        }
                        
                        return [
                            'id' => $comment->id,
                            'user_name' => $userName,
                            'comment' => $comment->comment,
                            'penalty_id' => $comment->penalty_id,
                            'penalty_name' => $penaltyName,
                            'penalty_desc_id' => $comment->penalty_desc_id,
                            'penalty_desc_name' => $penaltyDescName,
                        ];
                    })
                    ->toArray();

                // İtirazlar - referee_appeals tablosundan al
                $appeals = DB::table('referee_appeals')
                    ->where('ref_id', $decision->id)
                    ->get()
                    ->map(function($appeal) {
                        $appealDriver = DB::table('drivers')->where('id', $appeal->driver_id)->first();
                        return [
                            'id' => $appeal->id,
                            'driver_name' => ($appealDriver->name ?? 'Bilinmiyor') . ' ' . ($appealDriver->surname ?? ''),
                            'description' => $appeal->description,
                            'result' => $appeal->result,
                            'confirm' => $appeal->confirm,
                        ];
                    })
                    ->toArray();

                $complaints[] = [
                    'id' => $decision->id,
                    'complainant_name' => ($complainant->name ?? 'Bilinmiyor') . ' ' . ($complainant->surname ?? ''),
                    'complained_name' => ($complained->name ?? 'Bilinmiyor') . ' ' . ($complained->surname ?? ''),
                    'video_link' => $decision->video_link,
                    'reminder' => $decision->reminder,
                    'created_at' => $decision->created_at ? date('d.m.Y H:i', strtotime($decision->created_at)) : 'Belirsiz',
                    'penalty_id' => $decision->penalty_id,
                    'penalty_name' => $decision->penalty, // Direkt tablodan al
                    'penalty_point' => $decision->penalty_point, // Direkt tablodan al
                    'penalty_desc_id' => $decision->penalty_desc_id,
                    'penalty_desc_name' => $decision->penalty_desc, // Direkt tablodan al
                    'description' => $decision->description,
                    // Savunma bilgileri
                    'has_defense' => !empty($decision->comp_video) || !empty($decision->comp_desc),
                    'comp_video' => $decision->comp_video,
                    'comp_desc' => $decision->comp_desc,
                    'comp_date' => isset($decision->comp_date) && $decision->comp_date ? date('d.m.Y H:i', strtotime($decision->comp_date)) : null,
                    'comments' => $comments,
                    'appeals' => $appeals,
                ];
            }
        }

        // Ceza listelerini al
        $penalties = DB::table('penalties')->orderBy('name', 'asc')->get();
        $penaltyDescs = DB::table('penalty_desc')->orderBy('name', 'asc')->get();

        return view('adminPanel.leagues.refDecisions.trackDetail', [
            'track' => $track,
            'complaints' => $complaints,
            'leagueId' => $leagueId,
            'penalties' => $penalties,
            'penaltyDescs' => $penaltyDescs
        ]);
    }

    public function updateDecisionDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'decision_id' => 'required|integer|exists:referee_decisions,id',
            'penalty_id' => 'nullable|integer|exists:penalties,id',
            'penalty_desc_id' => 'nullable|integer|exists:penalty_desc,id',
            'description' => 'nullable|string|max:2000',
        ], [
            'decision_id.required' => __('common.decision_id_required'),
            'decision_id.exists' => __('common.decision_not_exists'),
            'penalty_id.exists' => __('common.penalty_not_exists'),
            'penalty_desc_id.exists' => __('common.penalty_desc_not_exists'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        try {
            // Ceza bilgilerini al
            $penalty = null;
            $penaltyDesc = null;
            $penaltyPoint = null;
            
            if ($request->penalty_id) {
                $penaltyData = DB::table('penalties')->where('id', $request->penalty_id)->first();
                if ($penaltyData) {
                    $penalty = $penaltyData->name;
                    $penaltyPoint = $penaltyData->penalty_point;
                }
            }
            
            if ($request->penalty_desc_id) {
                $penaltyDescData = DB::table('penalty_desc')->where('id', $request->penalty_desc_id)->first();
                if ($penaltyDescData) {
                    $penaltyDesc = $penaltyDescData->name;
                }
            }

            DB::table('referee_decisions')
                ->where('id', $request->decision_id)
                ->update([
                    'penalty_id' => $request->penalty_id,
                    'penalty_desc_id' => $request->penalty_desc_id,
                    'penalty' => $penalty,
                    'penalty_desc' => $penaltyDesc,
                    'penalty_point' => $penaltyPoint,
                    'description' => $request->description,
                    'updated_at' => now()
                ]);

            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.decision_updated')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }

    // Ceza Yönetimi
    public function listPenalties()
    {
        $penalties = DB::table('penalties')->orderBy('name', 'asc')->get();
        return view('adminPanel.leagues.refDecisions.penalties', ['penalties' => $penalties]);
    }

    public function listPenaltyDescs()
    {
        $penaltyDescs = DB::table('penalty_desc')->orderBy('name', 'asc')->get();
        return view('adminPanel.leagues.refDecisions.penaltyDescs', ['penaltyDescs' => $penaltyDescs]);
    }

    public function createPenalty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'penalty_point' => 'nullable|integer',
            'type' => 'required|integer',
            'time' => 'required|string|max:255',
        ], [
            'name.required' => __('common.penalty_name_required'),
            'type.required' => __('common.penalty_type_required'),
            'time.required' => __('common.penalty_time_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        try {
            DB::table('penalties')->insert([
                'name' => $request->name,
                'penalty_point' => $request->penalty_point,
                'type' => $request->type,
                'time' => $request->time,
            ]);

            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.penalty_created')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }

    public function updatePenalty(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'penalty_point' => 'nullable|integer',
            'type' => 'required|integer',
            'time' => 'required|string|max:255',
        ], [
            'name.required' => __('common.penalty_name_required'),
            'type.required' => __('common.penalty_type_required'),
            'time.required' => __('common.penalty_time_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        try {
            DB::table('penalties')->where('id', $id)->update([
                'name' => $request->name,
                'penalty_point' => $request->penalty_point,
                'type' => $request->type,
                'time' => $request->time,
            ]);

            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.penalty_updated')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }

    public function deletePenalty($id)
    {
        try {
            DB::table('penalties')->where('id', $id)->delete();
            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.penalty_deleted')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }

    public function createPenaltyDesc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => __('common.penalty_desc_name_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        try {
            DB::table('penalty_desc')->insert([
                'name' => $request->name,
            ]);

            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.penalty_desc_created')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }

    public function updatePenaltyDesc(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => __('common.penalty_desc_name_required'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        try {
            DB::table('penalty_desc')->where('id', $id)->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.penalty_desc_updated')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }

    public function deletePenaltyDesc($id)
    {
        try {
            DB::table('penalty_desc')->where('id', $id)->delete();
            return response()->json([
                'hata' => 0,
                'aciklama' => __('common.penalty_desc_deleted')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.error_occurred_retry')
            ]);
        }
    }
}
