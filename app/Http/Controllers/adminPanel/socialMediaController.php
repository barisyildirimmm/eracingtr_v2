<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use App\Http\Services\SocialMediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class socialMediaController extends Controller
{
    protected $socialMediaService;

    public function __construct(SocialMediaService $socialMediaService)
    {
        $this->socialMediaService = $socialMediaService;
    }

    public function index()
    {
        $posts = DB::table('social_media_posts')
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('adminPanel.socialMedia.index', compact('posts'));
    }

    public function create()
    {
        return view('adminPanel.socialMedia.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'mimes:jpeg,png,jpg,mp4,mov,avi|max:102400', // 100MB max for videos
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'in:instagram,instagram_reels,instagram_story,youtube_shorts',
            'scheduled_at' => 'required|date|after:now',
        ], [
            'content.required' => 'İçerik zorunludur.',
            'platforms.required' => 'En az bir platform seçmelisiniz.',
            'platforms.min' => 'En az bir platform seçmelisiniz.',
            'scheduled_at.required' => 'Paylaşım zamanı zorunludur.',
            'scheduled_at.after' => 'Paylaşım zamanı gelecekte olmalıdır.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePaths = [];
        
        // Upload images/videos
        if ($request->hasFile('images')) {
            $uploadPath = public_path('assets/img/social_media/');
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            foreach ($request->file('images') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $fileName);
                $imagePaths[] = $fileName;
            }
        }

        // Insert post
        $postId = DB::table('social_media_posts')->insertGetId([
            'content' => $request->content,
            'images' => json_encode($imagePaths),
            'platforms' => json_encode($request->platforms),
            'scheduled_at' => $request->scheduled_at,
            'status' => 'scheduled',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.socialMedia.index')
            ->with('success', 'Sosyal medya paylaşımı başarıyla oluşturuldu.');
    }

    public function edit($id)
    {
        $post = DB::table('social_media_posts')->where('id', $id)->first();
        
        if (!$post) {
            return redirect()->route('admin.socialMedia.index')
                ->with('error', 'Paylaşım bulunamadı.');
        }

        $post->images = json_decode($post->images, true) ?? [];
        $post->platforms = json_decode($post->platforms, true) ?? [];

        return view('adminPanel.socialMedia.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = DB::table('social_media_posts')->where('id', $id)->first();
        
        if (!$post) {
            return redirect()->route('admin.socialMedia.index')
                ->with('error', 'Paylaşım bulunamadı.');
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'mimes:jpeg,png,jpg,mp4,mov,avi|max:102400', // 100MB max for videos
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'in:instagram,instagram_reels,instagram_story,youtube_shorts',
            'scheduled_at' => 'required|date|after:now',
        ], [
            'content.required' => 'İçerik zorunludur.',
            'platforms.required' => 'En az bir platform seçmelisiniz.',
            'platforms.min' => 'En az bir platform seçmelisiniz.',
            'scheduled_at.required' => 'Paylaşım zamanı zorunludur.',
            'scheduled_at.after' => 'Paylaşım zamanı gelecekte olmalıdır.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $existingImages = json_decode($post->images, true) ?? [];
        $imagePaths = $existingImages;

        // Upload new images/videos
        if ($request->hasFile('images')) {
            $uploadPath = public_path('assets/img/social_media/');
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            foreach ($request->file('images') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $fileName);
                $imagePaths[] = $fileName;
            }
        }

        // Remove deleted images
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $deletedImage) {
                $imagePath = public_path('assets/img/social_media/' . $deletedImage);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $imagePaths = array_filter($imagePaths, function($img) use ($deletedImage) {
                    return $img !== $deletedImage;
                });
            }
            $imagePaths = array_values($imagePaths);
        }

        // Update post
        DB::table('social_media_posts')->where('id', $id)->update([
            'content' => $request->content,
            'images' => json_encode($imagePaths),
            'platforms' => json_encode($request->platforms),
            'scheduled_at' => $request->scheduled_at,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.socialMedia.index')
            ->with('success', 'Sosyal medya paylaşımı başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $post = DB::table('social_media_posts')->where('id', $id)->first();
        
        if (!$post) {
            return redirect()->route('admin.socialMedia.index')
                ->with('error', 'Paylaşım bulunamadı.');
        }

        // Delete images
        $images = json_decode($post->images, true) ?? [];
        foreach ($images as $image) {
            $imagePath = public_path('assets/img/social_media/' . $image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        DB::table('social_media_posts')->where('id', $id)->delete();

        return redirect()->route('admin.socialMedia.index')
            ->with('success', 'Sosyal medya paylaşımı başarıyla silindi.');
    }

    public function publishNow($id)
    {
        $post = DB::table('social_media_posts')->where('id', $id)->first();
        
        if (!$post) {
            return redirect()->route('admin.socialMedia.index')
                ->with('error', 'Paylaşım bulunamadı.');
        }

        // Publish to all platforms and collect results
        $results = $this->socialMediaService->publishPost($post);
        
        // Prepare result messages
        $successPlatforms = [];
        $failedPlatforms = [];
        
        $platformNames = [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'instagram_reels' => 'Instagram Reels',
            'instagram_story' => 'Instagram Story',
            'x' => 'X (Twitter)',
            'youtube_shorts' => 'YouTube Shorts'
        ];
        
        foreach ($results as $platform => $result) {
            $platformName = $platformNames[$platform] ?? ucfirst($platform);
            
            if (isset($result['success']) && $result['success'] === true) {
                $successPlatforms[] = $platformName;
            } else {
                $errorMessage = $result['error'] ?? 'Bilinmeyen hata';
                $failedPlatforms[] = $platformName . ' (' . $errorMessage . ')';
            }
        }
        
        // Build result message
        $messages = [];
        if (!empty($successPlatforms)) {
            $messages[] = 'Başarılı: ' . implode(', ', $successPlatforms);
        }
        if (!empty($failedPlatforms)) {
            $messages[] = 'Başarısız: ' . implode(', ', $failedPlatforms);
        }
        
        $resultMessage = !empty($messages) ? implode(' | ', $messages) : 'Sonuç alınamadı.';
        
        // Update post status based on results
        $allSuccess = empty($failedPlatforms);
        $allFailed = empty($successPlatforms);
        
        $status = 'published';
        if ($allFailed) {
            $status = 'failed';
        } elseif (!$allSuccess) {
            $status = 'partial'; // Some platforms succeeded, some failed
        }
        
        // Store results in database
        $resultsJson = json_encode($results);
        
        // Build error message from failed platforms
        $errorMessages = [];
        foreach ($results as $platform => $result) {
            if (isset($result['success']) && $result['success'] === false) {
                $platformName = $platformNames[$platform] ?? ucfirst($platform);
                $errorMessages[] = $platformName . ': ' . ($result['error'] ?? 'Bilinmeyen hata');
            }
        }
        $errorMessage = !empty($errorMessages) ? implode(' | ', $errorMessages) : null;
        
        $updateData = [
            'status' => $status,
            'published_at' => now(),
            'updated_at' => now(),
        ];
        
        // Add publish_results if column exists (will be added via SQL)
        $updateData['publish_results'] = $resultsJson;
        
        // Add error_message if there are errors
        if ($errorMessage) {
            $updateData['error_message'] = $errorMessage;
        }
        
        DB::table('social_media_posts')->where('id', $id)->update($updateData);
        
        // Return with appropriate message
        if ($allSuccess) {
            return redirect()->route('admin.socialMedia.index')
                ->with('success', $resultMessage);
        } elseif ($allFailed) {
            return redirect()->route('admin.socialMedia.index')
                ->with('error', $resultMessage);
        } else {
            return redirect()->route('admin.socialMedia.index')
                ->with('warning', $resultMessage);
        }
    }
}

