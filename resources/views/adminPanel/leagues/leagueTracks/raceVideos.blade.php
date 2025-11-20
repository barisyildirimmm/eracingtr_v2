@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .race-videos-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
            color: white;
        }
        .videos-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }
        .video-item-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .video-item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-color: #8b5cf6;
        }
        .track-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .track-date {
            color: #6b7280;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .badge-sprint {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            outline: none;
        }
        .btn-save {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            width: 100%;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
@endsection
@section('content')
<div class="race-videos-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-video me-2"></i>{{ __('common.race_videos') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.race_videos_desc') }}
            </p>
        </div>

        <!-- Videos Card -->
        <div class="videos-card">
            @if(count($leagueTracks) > 0)
                @foreach ($leagueTracks as $leagueTrack)
                    <div class="video-item-card">
                        <div class="row align-items-center">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <div class="track-name">
                                    <i class="fas fa-flag-checkered me-2"></i>{{ $leagueTrack->name }}
                                </div>
                                <div class="track-date">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $leagueTrack->race_date_formatted }}</span>
                                    @if($leagueTrack->sprint_status)
                                        <span class="badge-sprint">Sprint</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7 mb-3 mb-md-0">
                                <input type="text" 
                                       class="form-control race-video-input" 
                                       id="video_{{ $leagueTrack->id }}" 
                                       value="{{ $leagueTrack->race_video ?? '' }}" 
                                       placeholder="https://www.youtube.com/watch?v=... veya https://youtu.be/...">
                            </div>
                            <div class="col-md-2">
                                <button type="button" 
                                        class="btn btn-save" 
                                        onclick="saveVideo({{ $leagueTrack->id }})">
                                    <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-video"></i>
                    <h5>{{ __('common.no_race_yet_videos') }}</h5>
                    <p class="text-muted">{{ __('common.videos_will_appear') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const leagueId = {{ $leagueId }};

        function saveVideo(leagueTrackId) {
            const $input = $('#video_' + leagueTrackId);
            const videoUrl = $input.val();
            const $btn = $input.closest('.video-item-card').find('.btn-save');
            const originalHtml = $btn.html();

            // Disable button and show loading
            $btn.prop('disabled', true);
            $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __('common.loading') }}');

            $.ajax({
                url: '{{ route('admin.leagues.updateRaceVideo') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    league_track_id: leagueTrackId,
                    race_video: videoUrl
                },
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __('common.error') }}',
                            text: response.aciklama,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.error_occurred') }}',
                        icon: 'error'
                    });
                },
                complete: function() {
                    // Re-enable button
                    $btn.prop('disabled', false);
                    $btn.html(originalHtml);
                }
            });
        }

        // Enter tuşu ile kaydetme
        $('.race-video-input').on('keypress', function(e) {
            if (e.which === 13) {
                const leagueTrackId = $(this).attr('id').replace('video_', '');
                saveVideo(leagueTrackId);
            }
        });
    </script>
@endsection
