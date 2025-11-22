@extends('adminPanel.layouts.main')

@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .social-media-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .page-header-card {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
        color: white;
    }
    .post-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #dc3545;
    }
    .post-card.scheduled {
        border-left-color: #ffc107;
    }
    .post-card.published {
        border-left-color: #28a745;
    }
    .post-card.failed {
        border-left-color: #dc3545;
    }
    .platform-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .platform-facebook {
        background: #1877f2;
        color: white;
    }
    .platform-instagram {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: white;
    }
    .platform-x {
        background: #000000;
        color: white;
    }
    .platform-youtube {
        background: #ff0000;
        color: white;
    }
    .image-preview {
        display: inline-block;
        margin: 0.5rem;
        position: relative;
    }
    .image-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 2px solid #e9ecef;
    }
    .btn-create {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }
</style>
@endsection

@section('content')
<div class="social-media-page">
    <div class="container">
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">
                        <i class="fas fa-share-alt me-2"></i>
                        Sosyal Medya Paylaşımları
                    </h1>
                    <p class="mb-0 mt-2 opacity-90">Tüm sosyal medya platformlarında paylaşım yapın ve zamanlayın</p>
                </div>
                <a href="{{ route('admin.socialMedia.create') }}" class="btn-create">
                    <i class="fas fa-plus me-2"></i>
                    Yeni Paylaşım Oluştur
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            @forelse($posts as $post)
            <div class="col-md-6">
                <div class="post-card {{ $post->status }}">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">
                                @if($post->status == 'scheduled')
                                    <span class="badge bg-warning">Zamanlanmış</span>
                                @elseif($post->status == 'published')
                                    <span class="badge bg-success">Yayınlandı</span>
                                @elseif($post->status == 'failed')
                                    <span class="badge bg-danger">Başarısız</span>
                                @endif
                            </h5>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($post->scheduled_at)->format('d.m.Y H:i') }}
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.socialMedia.edit', $post->id) }}">
                                    <i class="fas fa-edit me-2"></i>Düzenle
                                </a></li>
                                @if($post->status == 'scheduled')
                                <li>
                                    <form action="{{ route('admin.socialMedia.publishNow', $post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Paylaşımı şimdi yayınlamak istediğinize emin misiniz?')">
                                        @csrf
                                        <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left; padding: 0.5rem 1rem;">
                                            <i class="fas fa-paper-plane me-2"></i>Şimdi Paylaş
                                        </button>
                                    </form>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.socialMedia.destroy', $post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bu paylaşımı silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: left; padding: 0.5rem 1rem;">
                                            <i class="fas fa-trash me-2"></i>Sil
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Platformlar:</strong><br>
                        @php
                            $platforms = json_decode($post->platforms, true) ?? [];
                            $platformNames = [
                                'instagram' => 'Instagram',
                                'instagram_reels' => 'Instagram Reels',
                                'instagram_story' => 'Instagram Story',
                                'youtube_shorts' => 'YouTube Shorts'
                            ];
                        @endphp
                        @foreach($platforms as $platform)
                            <span class="platform-badge platform-{{ $platform }}">
                                {{ $platformNames[$platform] ?? $platform }}
                            </span>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <strong>İçerik:</strong>
                        <div class="mt-2 p-2 bg-light rounded">
                            {!! Str::limit(strip_tags($post->content), 150) !!}
                        </div>
                    </div>

                    @php
                        $images = json_decode($post->images, true) ?? [];
                    @endphp
                    @if(count($images) > 0)
                    <div class="mb-3">
                        <strong>Fotoğraflar:</strong><br>
                        @foreach($images as $image)
                            <div class="image-preview">
                                <img src="{{ asset('assets/img/social_media/' . $image) }}" alt="Post Image">
                            </div>
                        @endforeach
                    </div>
                    @endif

                    @if($post->published_at)
                    <small class="text-muted">
                        <i class="fas fa-check-circle me-1"></i>
                        Yayınlandı: {{ \Carbon\Carbon::parse($post->published_at)->format('d.m.Y H:i') }}
                    </small>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Henüz paylaşım oluşturulmamış. İlk paylaşımınızı oluşturmak için yukarıdaki butona tıklayın.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

