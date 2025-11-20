<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class configController extends Controller
{
    public function socialMediaPostUpdate()
    {
        ini_set('max_execution_time', 300);
        // INSTAGRAM
        $accessToken = 'IGQWRUWXNJalBXQVAtcm5ITFFmNFNhSF94a011cnc4bHRNUjZAWYTVwanpKQVhibG5ERXVhTUVOMXBCNHlZASzlINlZArUEZAxUWZApWDh5YTU1NFR2emJlQW1KR2tzbjQ1R3MxRFliLUFYMEdLR0hZAWkhRT2VsbEdqTUEZD';
        $userID = '17841412813981311';

        $savePath = public_path('assets/img/instagram/');
        if (!is_dir($savePath)) {
            mkdir($savePath, 0777, true);
        }

        $baseUrl = "https://graph.instagram.com/$userID/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp&access_token=$accessToken";

        do {
            $response = file_get_contents($baseUrl);
            $json = json_decode($response, true);

            if (!isset($json['data'])) break;

            foreach ($json['data'] as $item) {

                // --- 1) MEDYA DOSYASINI HER HALDE İNDİR ---
                if ($item['media_type'] === 'IMAGE' && !empty($item['media_url'])) {
                    $filePath = $savePath . $item['id'] . '.jpg';
                    if (!file_exists($filePath)) {
                        $img = @file_get_contents($item['media_url']);
                        if ($img !== false) file_put_contents($filePath, $img);
                    }
                }
                if ($item['media_type'] === 'CAROUSEL_ALBUM' && !empty($item['media_url'])) {
                    $filePath = $savePath . $item['id'] . '.jpg';
                    if (!file_exists($filePath)) {
                        $img = @file_get_contents($item['media_url']);
                        if ($img !== false) file_put_contents($filePath, $img);
                    }
                }

                if ($item['media_type'] === 'VIDEO' && !empty($item['media_url'])) {
                    $filePath = $savePath . $item['id'] . '.mp4';
                    if (!file_exists($filePath)) {
                        $video = @file_get_contents($item['media_url']);
                        if ($video !== false) file_put_contents($filePath, $video);
                    }
                }

                // --- 2) DB kontrol et ve yoksa ekle ---
                $exists = DB::table('posts_instagram')
                    ->where('instagram_id', $item['id'])
                    ->exists();

                if (!$exists) {
                    DB::table('posts_instagram')->insert([
                        'instagram_id' => $item['id'],
                        'caption'      => $item['caption'] ?? null,
                        'media_type'   => $item['media_type'],
                        'media_url'    => $item['media_url'] ?? null,
                        'permalink'    => $item['permalink'] ?? null,
                        'timestamp'    => date('Y-m-d H:i:s', strtotime($item['timestamp']))
                    ]);
                }
            }

            $baseUrl = $json['paging']['next'] ?? null;

        } while ($baseUrl);

        // !INSTAGRAM


        //YOUTUBE
        $apiKey = 'AIzaSyC8DW5WKOfMDb34sgv1DQa2O2S1I1p4rZU'; // Buraya API anahtarınızı yazın
        $channelId = 'UCenpXKmAP_4cgK61R-8w50Q'; // Buraya kanal ID'nizi yazın

        $url = "https://www.googleapis.com/youtube/v3/search?key={$apiKey}&channelId={$channelId}&order=date&part=snippet&type=video";

        $response = file_get_contents($url);

        $data = json_decode($response, true);

        $youtubePastPosts = DB::table('posts_youtube')->select('id', 'etag')->get()->keyBy('etag')->toArray();
        foreach ($data['items'] as $item) {

            if (isset($youtubePastPosts[$item['etag']])) {
                continue;
            }
            $dateString = $item['snippet']['publishTime'];
            $timestamp = strtotime($dateString);
            $formattedDate = date('Y-m-d H:i:s', $timestamp);

            $insertData = [
                'etag' => $item['etag'],
                'video_id' => $item['id']['videoId'],
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
                'thumbnails_def' => $item['snippet']['thumbnails']['default']['url'],
                'thumbnails_med' => $item['snippet']['thumbnails']['medium']['url'],
                'thumbnails_high' => $item['snippet']['thumbnails']['high']['url'],
                'live_content' => $item['snippet']['liveBroadcastContent'],
                'publish_time' => $formattedDate
            ];
            DB::table('posts_youtube')->insert($insertData);
        }
        //!YOUTUBE
        return redirect()->route('Ahome')->with('success', __('common.instagram_data_updated'));

    }
}
