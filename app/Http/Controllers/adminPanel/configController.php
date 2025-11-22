<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class configController extends Controller
{
    public function socialMediaPostUpdate()
    {
        ini_set('max_execution_time', 300);
        
        $results = [
            'instagram' => null,
            'youtube' => null,
            'errors' => []
        ];

        // INSTAGRAM API (Facebook Graph API üzerinden)
        try {
            $accessToken = env('INSTAGRAM_ACCESS_TOKEN');
            $instagramBusinessAccountId = env('INSTAGRAM_ACCOUNT_ID'); // Instagram Business Account ID

            if (!$accessToken || !$instagramBusinessAccountId) {
                $results['errors'][] = 'Instagram credentials not found in .env';
                $results['instagram'] = [
                    'error' => 'INSTAGRAM_ACCESS_TOKEN veya INSTAGRAM_ACCOUNT_ID .env dosyasında bulunamadı',
                    'access_token_exists' => !empty($accessToken),
                    'account_id_exists' => !empty($instagramBusinessAccountId)
                ];
            } else {
                // Facebook Graph API v24.0 kullanarak Instagram medya çekme
                $apiVersion = 'v24.0';
                $fields = 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,username';
                $url = "https://graph.facebook.com/{$apiVersion}/{$instagramBusinessAccountId}/media";
                
                $response = Http::get($url, [
                    'fields' => $fields,
                    'access_token' => $accessToken
                ]);
                
                if ($response->failed()) {
                    $errorBody = $response->json();
                    $results['instagram'] = [
                        'success' => false,
                        'status_code' => $response->status(),
                        'error' => $errorBody['error']['message'] ?? 'API isteği başarısız oldu',
                        'error_code' => $errorBody['error']['code'] ?? null,
                        'error_type' => $errorBody['error']['type'] ?? null,
                        'error_subcode' => $errorBody['error']['error_subcode'] ?? null,
                        'full_error' => $errorBody['error'] ?? $errorBody,
                        'request_url' => $url,
                        'request_params' => [
                            'fields' => $fields,
                            'access_token' => substr($accessToken, 0, 20) . '...' // Güvenlik için kısaltılmış
                        ]
                    ];
                } else {
                    $json = $response->json();
                    $results['instagram'] = [
                        'success' => true,
                        'status_code' => $response->status(),
                        'api_version' => $apiVersion,
                        'account_id' => $instagramBusinessAccountId,
                        'data_count' => count($json['data'] ?? []),
                        'data' => $json['data'] ?? [],
                        'paging' => $json['paging'] ?? null,
                        'has_next' => isset($json['paging']['next']),
                        'full_response' => $json
                    ];
                }
            }
        } catch (\Exception $e) {
            $results['errors'][] = 'Instagram error: ' . $e->getMessage();
            $results['instagram'] = [
                'success' => false,
                'error' => $e->getMessage(),
                'error_type' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
        }

        // YOUTUBE API
        try {
            $clientId = env('YOUTUBE_CLIENT_ID');
            $clientSecret = env('YOUTUBE_CLIENT_SECRET');
            $refreshToken = env('YOUTUBE_REFRESH_TOKEN');

            if (!$clientId || !$clientSecret || !$refreshToken) {
                $results['errors'][] = 'YouTube credentials not found in .env';
                $results['youtube'] = [
                    'error' => 'YOUTUBE_CLIENT_ID, YOUTUBE_CLIENT_SECRET veya YOUTUBE_REFRESH_TOKEN .env dosyasında bulunamadı',
                    'client_id_exists' => !empty($clientId),
                    'client_secret_exists' => !empty($clientSecret),
                    'refresh_token_exists' => !empty($refreshToken),
                    'client_id_preview' => !empty($clientId) ? substr($clientId, 0, 20) . '...' : null,
                    'refresh_token_preview' => !empty($refreshToken) ? substr($refreshToken, 0, 20) . '...' : null
                ];
            } else {
                // Önce access token al (refresh token ile)
                $tokenUrl = 'https://oauth2.googleapis.com/token';
                
                $tokenResponse = Http::asForm()->post($tokenUrl, [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'refresh_token' => $refreshToken,
                    'grant_type' => 'refresh_token'
                ]);

                $tokenResponseBody = $tokenResponse->json();
                $tokenResponseStatus = $tokenResponse->status();

                if ($tokenResponse->failed()) {
                    $errorType = $tokenResponseBody['error'] ?? null;
                    $errorDescription = $tokenResponseBody['error_description'] ?? null;
                    
                    $possibleCauses = [];
                    if ($errorType === 'unauthorized_client') {
                        $possibleCauses = [
                            'Refresh token bu Client ID için oluşturulmamış olabilir',
                            'Client ID ve Client Secret yanlış olabilir',
                            'Refresh token başka bir OAuth client için oluşturulmuş olabilir',
                            'OAuth consent screen ayarlarında bu client ID tanımlı değil olabilir'
                        ];
                    } elseif ($errorType === 'invalid_grant') {
                        $possibleCauses = [
                            'Refresh token geçersiz veya süresi dolmuş olabilir',
                            'Refresh token iptal edilmiş olabilir',
                            'Kullanıcı hesabı erişim iznini geri çekmiş olabilir'
                        ];
                    } else {
                        $possibleCauses = [
                            'Client ID ve Client Secret eşleşmiyor olabilir',
                            'Refresh token geçersiz veya süresi dolmuş olabilir',
                            'OAuth consent screen ayarları yanlış olabilir',
                            'YouTube Data API v3 etkinleştirilmemiş olabilir'
                        ];
                    }
                    
                    $results['youtube'] = [
                        'success' => false,
                        'error' => 'Access token alınamadı',
                        'status_code' => $tokenResponseStatus,
                        'token_error' => $tokenResponseBody,
                        'error_details' => [
                            'error_type' => $errorType,
                            'error_description' => $errorDescription,
                            'possible_causes' => $possibleCauses,
                            'solution_steps' => [
                                '1. Google Cloud Console\'da OAuth 2.0 Client ID\'yi kontrol edin',
                                '2. Refresh token\'ın bu Client ID için oluşturulduğundan emin olun',
                                '3. Yeni bir refresh token almak için OAuth flow\'unu tekrar çalıştırın',
                                '4. YouTube Data API v3\'ün etkinleştirildiğinden emin olun'
                            ]
                        ],
                        'request_info' => [
                            'token_url' => $tokenUrl,
                            'client_id_length' => strlen($clientId),
                            'client_secret_length' => strlen($clientSecret),
                            'refresh_token_length' => strlen($refreshToken),
                            'grant_type' => 'refresh_token',
                            'client_id_preview' => substr($clientId, 0, 20) . '...' . substr($clientId, -5)
                        ],
                        'full_response' => $tokenResponseBody
                    ];
                } else {
                    $accessToken = $tokenResponseBody['access_token'] ?? null;

                    if (!$accessToken) {
                        $results['youtube'] = [
                            'success' => false,
                            'error' => 'Access token yanıtında bulunamadı',
                            'token_response' => $tokenResponseBody,
                            'status_code' => $tokenResponseStatus
                        ];
                    } else {
                        // Channel ID'yi access token ile al
                        $channelInfoUrl = 'https://www.googleapis.com/youtube/v3/channels';
                        $channelResponse = Http::get($channelInfoUrl, [
                            'part' => 'contentDetails,snippet',
                            'mine' => 'true',
                            'access_token' => $accessToken
                        ]);

                        $channelId = null;
                        $channelData = null;
                        if ($channelResponse->successful()) {
                            $channelData = $channelResponse->json();
                            if (isset($channelData['items'][0])) {
                                $channelId = $channelData['items'][0]['id'] ?? null;
                            }
                        }

                        // Video araması yap
                        $searchUrl = "https://www.googleapis.com/youtube/v3/search";
                        $searchParams = [
                            'part' => 'snippet',
                            'type' => 'video',
                            'order' => 'date',
                            'maxResults' => 5
                        ];

                        // Access token ile istek yap
                        $response = Http::withToken($accessToken)->get($searchUrl, $searchParams);
                        
                        if ($response->failed()) {
                            $errorBody = $response->json();
                            $results['youtube'] = [
                                'success' => false,
                                'status_code' => $response->status(),
                                'error' => $errorBody['error']['message'] ?? 'API isteği başarısız oldu',
                                'error_code' => $errorBody['error']['code'] ?? null,
                                'error_reason' => $errorBody['error']['errors'][0]['reason'] ?? null,
                                'full_error' => $errorBody['error'] ?? $errorBody,
                                'request_url' => $searchUrl,
                                'access_token_received' => true,
                                'access_token_preview' => substr($accessToken, 0, 20) . '...',
                                'channel_id' => $channelId,
                                'channel_response' => $channelData
                            ];
                        } else {
                            $data = $response->json();
                            $results['youtube'] = [
                                'success' => true,
                                'status_code' => $response->status(),
                                'access_token_received' => true,
                                'channel_id' => $channelId,
                                'channel_info' => $channelData,
                                'items_count' => count($data['items'] ?? []),
                                'items' => $data['items'] ?? [],
                                'page_info' => $data['pageInfo'] ?? null,
                                'full_response' => $data
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $results['errors'][] = 'YouTube error: ' . $e->getMessage();
            $results['youtube'] = [
                'success' => false,
                'error' => $e->getMessage(),
                'error_type' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
        }

        // API sonuçlarını göster
        dd($results);
    }
    public function socialMediaPostUpdateOLD()
    {
        ini_set('max_execution_time', 300);
        // INSTAGRAM
        // $accessToken = 'IGQWRUWXNJalBXQVAtcm5ITFFmNFNhSF94a011cnc4bHRNUjZAWYTVwanpKQVhibG5ERXVhTUVOMXBCNHlZASzlINlZArUEZAxUWZApWDh5YTU1NFR2emJlQW1KR2tzbjQ1R3MxRFliLUFYMEdLR0hZAWkhRT2VsbEdqTUEZD';
        // $userID = '17841412813981311';

        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');
        $userID = env('INSTAGRAM_USER_ID');

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
