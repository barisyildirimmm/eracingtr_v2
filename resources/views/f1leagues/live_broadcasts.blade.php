@extends('layouts.layout')

@section('content')
<style>
    .broadcast-card {
        background: linear-gradient(135deg, rgba(30, 30, 30, 0.95) 0%, rgba(20, 20, 20, 0.95) 100%);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .broadcast-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(255, 255, 255, 0.2);
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .track-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    .track-flag {
        width: 40px;
        height: 30px;
        border-radius: 4px;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
    }
    .track-flag-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
    }
    .track-name {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }
    .race-date {
        color: #999;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .race-type-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .race-type-badge.sprint {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        color: #856404;
    }
    .race-type-badge.race {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    .youtube-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #ff0000;
        text-decoration: none;
        font-size: 0.9rem;
        margin-top: 10px;
        transition: color 0.3s;
    }
    .youtube-link:hover {
        color: #ff3333;
        text-decoration: underline;
    }
</style>
    <!-- Page Heading
              ================================================== -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">{{ __('common.live_broadcasts') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Heading / End -->

    @include('f1leagues.components.nav')

    <!-- Content
              ================================================== -->
    <div class="site-content">
        <div class="container">
            @if(isset($leagueTracks) && $leagueTracks->count() > 0)
            <div class="row">
                @foreach($leagueTracks as $track)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="broadcast-card">
                        <div class="card-body p-4">
                            <div class="track-info">
                                @php
                                    $flagPath = asset('assets/img/flags/' . $track->track_id . '_b.jpg');
                                    $flagExists = file_exists(public_path('assets/img/flags/' . $track->track_id . '_b.jpg'));
                                @endphp
                                @if($flagExists)
                                    <img src="{{ $flagPath }}" alt="{{ $track->track_name }}" class="track-flag">
                                @else
                                    <div class="track-flag-icon">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="track-name">{{ $track->track_name }}</h5>
                                    <div class="race-date">
                                        <i class="fas fa-calendar"></i>
                                        {{ $track->race_date_formatted }}
                                    </div>
                                </div>
                            </div>
                            
                            @if($track->sprint_status)
                            <div class="mb-3">
                                <span class="race-type-badge sprint">
                                    <i class="fas fa-bolt"></i> {{ __('common.sprint') }}
                                </span>
                            </div>
                            @else
                            <div class="mb-3">
                                <span class="race-type-badge race">
                                    <i class="fas fa-flag-checkered"></i> {{ __('common.race') }}
                                </span>
                            </div>
                            @endif
                            
                            @if($track->video_id)
                            <div class="video-container">
                                <iframe src="https://www.youtube.com/embed/{{ $track->video_id }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen></iframe>
                            </div>
                            <a href="https://www.youtube.com/watch?v={{ $track->video_id }}" 
                               target="_blank" 
                               class="youtube-link">
                                <i class="fab fa-youtube"></i>
                                {{ __('common.open_on_youtube') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <!-- Content / End -->
@endsection
