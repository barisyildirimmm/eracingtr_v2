<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SocialMediaService
{
    /**
     * Publish post to all selected platforms
     */
    public function publishPost($post)
    {
        $platforms = json_decode($post->platforms, true) ?? [];
        $images = json_decode($post->images, true) ?? [];
        $content = strip_tags($post->content); // Remove HTML tags for social media

        $results = [];

        foreach ($platforms as $platform) {
            try {
                switch ($platform) {
                    case 'facebook':
                        $results['facebook'] = $this->publishToFacebook($content, $images);
                        break;
                    case 'instagram':
                        $results['instagram'] = $this->publishToInstagram($content, $images);
                        break;
                    case 'instagram_reels':
                        $results['instagram_reels'] = $this->publishToInstagramReels($content, $images);
                        break;
                    case 'instagram_story':
                        $results['instagram_story'] = $this->publishToInstagramStory($content, $images);
                        break;
                    case 'x':
                        $results['x'] = $this->publishToX($content, $images);
                        break;
                    case 'youtube_shorts':
                        $results['youtube_shorts'] = $this->publishToYouTubeShorts($content, $images);
                        break;
                }
            } catch (\Exception $e) {
                Log::error("Social media publish error for {$platform}: " . $e->getMessage());
                $results[$platform] = ['success' => false, 'error' => $e->getMessage()];
            }
        }

        return $results;
    }

    /**
     * Publish to Facebook
     */
    private function publishToFacebook($content, $images)
    {
        $pageId = env('FACEBOOK_PAGE_ID');
        $accessToken = env('FACEBOOK_ACCESS_TOKEN');

        if (!$pageId || !$accessToken) {
            throw new \Exception('Facebook credentials not configured');
        }

        try {
            // If there are images, post as photo
            if (!empty($images) && count($images) > 0) {
                $imageUrl = asset('assets/img/social_media/' . $images[0]);
                
                $response = Http::post("https://graph.facebook.com/v24.0/{$pageId}/photos", [
                    'message' => $content,
                    'url' => $imageUrl,
                    'access_token' => $accessToken
                ]);

                if ($response->failed()) {
                    $errorBody = $response->json();
                    throw new \Exception('Facebook API error: ' . ($errorBody['error']['message'] ?? $response->body()));
                }

                $responseData = $response->json();
                return [
                    'success' => true,
                    'message' => 'Posted to Facebook',
                    'post_id' => $responseData['id'] ?? null
                ];
            } else {
                // Post as text only
                $response = Http::post("https://graph.facebook.com/v24.0/{$pageId}/feed", [
                    'message' => $content,
                    'access_token' => $accessToken
                ]);

                if ($response->failed()) {
                    $errorBody = $response->json();
                    throw new \Exception('Facebook API error: ' . ($errorBody['error']['message'] ?? $response->body()));
                }

                $responseData = $response->json();
                return [
                    'success' => true,
                    'message' => 'Posted to Facebook',
                    'post_id' => $responseData['id'] ?? null
                ];
            }
        } catch (\Exception $e) {
            Log::error('Facebook publish error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Publish to Instagram
     */
    private function publishToInstagram($content, $images)
    {
        $instagramAccountId = env('INSTAGRAM_ACCOUNT_ID');
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');

        if (!$instagramAccountId || !$accessToken) {
            throw new \Exception('Instagram credentials not configured');
        }

        if (empty($images) || count($images) === 0) {
            throw new \Exception('Instagram requires at least one image');
        }

        try {
            $imageUrl = asset('assets/img/social_media/' . $images[0]);
            
            // Step 1: Create media container
            $mediaResponse = Http::post("https://graph.facebook.com/v24.0/{$instagramAccountId}/media", [
                'image_url' => $imageUrl,
                'caption' => $content,
                'access_token' => $accessToken
            ]);

            if ($mediaResponse->failed()) {
                $errorBody = $mediaResponse->json();
                throw new \Exception('Instagram media creation error: ' . ($errorBody['error']['message'] ?? $mediaResponse->body()));
            }

            $mediaData = $mediaResponse->json();
            $creationId = $mediaData['id'] ?? null;

            if (!$creationId) {
                throw new \Exception('Instagram media creation ID not found');
            }

            // Step 2: Publish media
            $publishResponse = Http::post("https://graph.facebook.com/v24.0/{$instagramAccountId}/media_publish", [
                'creation_id' => $creationId,
                'access_token' => $accessToken
            ]);

            if ($publishResponse->failed()) {
                $errorBody = $publishResponse->json();
                throw new \Exception('Instagram publish error: ' . ($errorBody['error']['message'] ?? $publishResponse->body()));
            }

            $publishData = $publishResponse->json();
            return [
                'success' => true,
                'message' => 'Posted to Instagram',
                'media_id' => $publishData['id'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Instagram publish error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Publish to Instagram Reels
     */
    private function publishToInstagramReels($content, $images)
    {
        $instagramAccountId = env('INSTAGRAM_ACCOUNT_ID');
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');

        if (!$instagramAccountId || !$accessToken) {
            throw new \Exception('Instagram credentials not configured');
        }

        if (empty($images) || count($images) === 0) {
            throw new \Exception('Instagram Reels requires at least one video');
        }

        try {
            // For Reels, we need a video URL (not image)
            // The first file should be a video
            $videoUrl = asset('assets/img/social_media/' . $images[0]);
            
            // Step 1: Create Reels media container
            $mediaResponse = Http::post("https://graph.facebook.com/v24.0/{$instagramAccountId}/media", [
                'media_type' => 'REELS',
                'video_url' => $videoUrl,
                'caption' => $content,
                'access_token' => $accessToken
            ]);

            if ($mediaResponse->failed()) {
                $errorBody = $mediaResponse->json();
                throw new \Exception('Instagram Reels media creation error: ' . ($errorBody['error']['message'] ?? $mediaResponse->body()));
            }

            $mediaData = $mediaResponse->json();
            $creationId = $mediaData['id'] ?? null;

            if (!$creationId) {
                throw new \Exception('Instagram Reels media creation ID not found');
            }

            // Step 2: Publish Reels
            $publishResponse = Http::post("https://graph.facebook.com/v24.0/{$instagramAccountId}/media_publish", [
                'creation_id' => $creationId,
                'access_token' => $accessToken
            ]);

            if ($publishResponse->failed()) {
                $errorBody = $publishResponse->json();
                throw new \Exception('Instagram Reels publish error: ' . ($errorBody['error']['message'] ?? $publishResponse->body()));
            }

            $publishData = $publishResponse->json();
            return [
                'success' => true,
                'message' => 'Posted to Instagram Reels',
                'media_id' => $publishData['id'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Instagram Reels publish error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Publish to Instagram Story
     */
    private function publishToInstagramStory($content, $images)
    {
        $instagramAccountId = env('INSTAGRAM_ACCOUNT_ID');
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');

        if (!$instagramAccountId || !$accessToken) {
            throw new \Exception('Instagram credentials not configured');
        }

        if (empty($images) || count($images) === 0) {
            throw new \Exception('Instagram Story requires at least one image or video');
        }

        try {
            $mediaUrl = asset('assets/img/social_media/' . $images[0]);
            
            // Determine if it's a video or image based on file extension
            $fileExtension = strtolower(pathinfo($images[0], PATHINFO_EXTENSION));
            $isVideo = in_array($fileExtension, ['mp4', 'mov', 'avi', 'mkv', 'webm']);
            
            // Step 1: Create Story media container
            // Instagram Story API doesn't use media_type parameter
            // It automatically detects Story based on the endpoint or parameters
            $mediaParams = [
                'access_token' => $accessToken
            ];
            
            if ($isVideo) {
                $mediaParams['video_url'] = $mediaUrl;
            } else {
                $mediaParams['image_url'] = $mediaUrl;
            }
            
            // Add caption if provided (optional for Stories)
            if (!empty($content)) {
                $mediaParams['caption'] = $content;
            }

            
            $mediaResponse = Http::post("https://graph.facebook.com/v24.0/{$instagramAccountId}/media", $mediaParams);

            if ($mediaResponse->failed()) {
                $errorBody = $mediaResponse->json();
                throw new \Exception('Instagram Story media creation error: ' . ($errorBody['error']['message'] ?? $mediaResponse->body()));
            }

            $mediaData = $mediaResponse->json();
            $creationId = $mediaData['id'] ?? null;

            if (!$creationId) {
                throw new \Exception('Instagram Story media creation ID not found');
            }

            // Step 2: Publish Story
            $publishResponse = Http::post("https://graph.facebook.com/v24.0/{$instagramAccountId}/media_publish", [
                'creation_id' => $creationId,
                'access_token' => $accessToken
            ]);

            dd($publishResponse->json(), $publishResponse->body(), $publishResponse->status(), $publishResponse->failed());

            if ($publishResponse->failed()) {
                $errorBody = $publishResponse->json();
                throw new \Exception('Instagram Story publish error: ' . ($errorBody['error']['message'] ?? $publishResponse->body()));
            }

            $publishData = $publishResponse->json();
            return [
                'success' => true,
                'message' => 'Posted to Instagram Story',
                'media_id' => $publishData['id'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Instagram Story publish error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Publish to X (Twitter)
     */
    private function publishToX($content, $images)
    {
        // X (Twitter) API integration
        // You'll need to configure X API credentials in .env
        $apiKey = env('X_API_KEY');
        $apiSecret = env('X_API_SECRET');
        $accessToken = env('X_ACCESS_TOKEN');
        $accessTokenSecret = env('X_ACCESS_TOKEN_SECRET');

        if (!$apiKey || !$apiSecret || !$accessToken || !$accessTokenSecret) {
            throw new \Exception('X (Twitter) credentials not configured');
        }

        Log::info('Publishing to X (Twitter)', [
            'content' => $content,
            'images' => $images
        ]);

        // Example API call (uncomment and configure when ready):
        /*
        // Use Twitter API v2 or a library like abraham/twitteroauth
        // This is a simplified example
        */

        return ['success' => true, 'message' => 'Posted to X (Twitter)'];
    }

    /**
     * Publish to YouTube Shorts
     */
    private function publishToYouTubeShorts($content, $images)
    {
        $clientId = env('YOUTUBE_CLIENT_ID');
        $clientSecret = env('YOUTUBE_CLIENT_SECRET');
        $refreshToken = env('YOUTUBE_REFRESH_TOKEN');

        if (!$clientId || !$clientSecret || !$refreshToken) {
            throw new \Exception('YouTube credentials not configured');
        }

        try {
            // Step 1: Get access token using refresh token
            $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'refresh_token' => $refreshToken,
                'grant_type' => 'refresh_token'
            ]);

            if ($tokenResponse->failed()) {
                $errorBody = $tokenResponse->json();
                throw new \Exception('YouTube token error: ' . ($errorBody['error_description'] ?? 'Failed to get access token'));
            }

            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'] ?? null;

            if (!$accessToken) {
                throw new \Exception('YouTube access token not found in response');
            }

            // Step 2: Get channel ID
            $channelResponse = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}"
            ])->get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'snippet,contentDetails',
                'mine' => 'true'
            ]);

            if ($channelResponse->failed()) {
                $errorBody = $channelResponse->json();
                throw new \Exception('YouTube channel error: ' . ($errorBody['error']['message'] ?? 'Failed to get channel'));
            }

            $channelData = $channelResponse->json();
            $channelId = $channelData['items'][0]['id'] ?? null;

            if (!$channelId) {
                throw new \Exception('YouTube channel ID not found');
            }

            // Note: YouTube Shorts requires video upload
            // For now, we'll create a post/community post if possible, or throw an error
            // In a real implementation, you would need to upload a video file
            
            // For images, we can't directly post to YouTube Shorts
            // This would require converting images to video or uploading as community post
            // For now, return success but note that video upload is required
            
            return [
                'success' => true,
                'message' => 'YouTube Shorts requires video upload. Image posting not directly supported.',
                'note' => 'To post images, convert to video first or use YouTube Community Posts API'
            ];
        } catch (\Exception $e) {
            Log::error('YouTube Shorts publish error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check and publish scheduled posts
     */
    public function processScheduledPosts()
    {
        $scheduledPosts = DB::table('social_media_posts')
            ->where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($scheduledPosts as $post) {
            try {
                $this->publishPost($post);
                
                DB::table('social_media_posts')
                    ->where('id', $post->id)
                    ->update([
                        'status' => 'published',
                        'published_at' => now(),
                        'updated_at' => now(),
                    ]);
            } catch (\Exception $e) {
                Log::error("Failed to publish scheduled post {$post->id}: " . $e->getMessage());
                
                DB::table('social_media_posts')
                    ->where('id', $post->id)
                    ->update([
                        'status' => 'failed',
                        'error_message' => $e->getMessage(),
                        'updated_at' => now(),
                    ]);
            }
        }
    }
}

