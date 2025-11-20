@extends('driverPanel.layouts.main')

@section('content')
<style>
    .defense-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .page-header-card {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(14, 165, 233, 0.3);
        color: white;
    }
    .race-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .race-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
    .race-header {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .race-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    .complaint-section {
        background: linear-gradient(to bottom, #fff5f5 0%, #ffffff 100%);
        border-left: 4px solid #dc3545;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(220, 53, 69, 0.1);
    }
    .defense-form-card {
        background: linear-gradient(to bottom, #f0f9ff 0%, #ffffff 100%);
        border-left: 4px solid #0ea5e9;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(14, 165, 233, 0.1);
    }
    .defense-completed-card {
        background: linear-gradient(to bottom, #f0fdf4 0%, #ffffff 100%);
        border-left: 4px solid #10b981;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.1);
    }
    .form-input {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    .form-input:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        outline: none;
    }
    .submit-btn {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.5);
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        margin: 1rem 0;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .empty-state-icon {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    .countdown-timer-header {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: inline-flex;
        align-items: center;
    }
    .countdown-display-header {
        font-family: 'Courier New', monospace;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .countdown-expired {
        color: #ffc107 !important;
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<div class="defense-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-shield-alt me-2"></i>{{ __('common.my_defenses') }}
                    </h2>
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <p class="mb-0 opacity-90">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ str_replace(':hours', enums()['defense_time_limit_minutes'] / 60, __('common.defense_time_info')) }}
                        </p>
                        @if($tracks->isNotEmpty())
                            @php
                                $firstTrack = $tracks->first();
                                $hours = floor($firstTrack->remaining_seconds / 3600);
                                $minutes = floor(($firstTrack->remaining_seconds % 3600) / 60);
                                $seconds = $firstTrack->remaining_seconds % 60;
                            @endphp
                            <div class="countdown-timer-header" data-deadline="{{ $firstTrack->deadline_timestamp }}">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-clock me-1"></i>
                                    <span class="fw-bold">{{ __('common.remaining_time') }}: </span>
                                    <span class="countdown-display-header fw-bold" style="font-size: 1.1rem; letter-spacing: 1px;">
                                        <span class="hours">{{ str_pad($hours, 2, '0', STR_PAD_LEFT) }}</span>:<span class="minutes">{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}</span>:<span class="seconds">{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}</span>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 0.75rem; border: none;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($tracks->isEmpty())
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="text-muted mb-2">{{ __('common.no_complaint_to_defend') }}</h4>
                <p class="text-muted">{{ __('common.no_complaint_to_defend_desc') }}</p>
            </div>
        @else
            <!-- Defense Cards -->
            @foreach($tracks as $track)
                <div class="race-card">
                    <!-- Race Header -->
                    <div class="race-header">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <h5 class="mb-2 fw-bold">
                                    <i class="fas fa-flag-checkered me-2"></i>
                                    {{ $track->track_name }}
                                </h5>
                                <p class="mb-1 opacity-90">
                                    <i class="fas fa-trophy me-2"></i>{{ $track->league_name }}
                                </p>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-calendar-alt me-2"></i>{{ tarihBicimi($track->race_date, 4) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <!-- Complaint Section -->
                        <div class="complaint-section">
                            <h6 class="mb-3 fw-bold text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ __('common.complaint_received') }}
                            </h6>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-user me-1"></i>{{ __('common.complainant') }}
                                </small>
                                <strong class="text-danger">{{ $track->complainant_name }}</strong>
                            </div>

                            @if($track->video_link)
                                @php
                                    $videoId = null;
                                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $track->video_link, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if($videoId)
                                    <div class="video-container">
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @endif
                            @endif

                            @if($track->reminder)
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-1">
                                        <i class="fas fa-comment me-1"></i>{{ __('common.complaint_description') }}
                                    </small>
                                    <div class="p-3 rounded" style="background: rgba(220, 53, 69, 0.05);">
                                        <p class="mb-0" style="line-height: 1.6;">{{ $track->reminder }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($track->has_defense)
                            <!-- Completed Defense -->
                            <div class="defense-completed-card">
                                <h6 class="mb-3 fw-bold text-success">
                                    <i class="fas fa-check-circle me-2"></i>{{ __('common.defense_completed') }}
                                </h6>
                                
                                @if($track->comp_video)
                                    @php
                                        $compVideoId = null;
                                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $track->comp_video, $matches)) {
                                            $compVideoId = $matches[1];
                                        }
                                    @endphp
                                    @if($compVideoId)
                                        <div class="video-container">
                                            <iframe src="https://www.youtube.com/embed/{{ $compVideoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    @endif
                                @endif

                                @if($track->comp_desc)
                                    <div class="mt-3">
                                        <small class="text-muted d-block mb-1">
                                            <i class="fas fa-file-alt me-1"></i>{{ __('common.defense_description') }}
                                        </small>
                                        <div class="p-3 rounded" style="background: rgba(16, 185, 129, 0.05);">
                                            <p class="mb-0" style="line-height: 1.6;">{{ $track->comp_desc }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Defense Form -->
                            <div class="defense-form-card">
                                <h6 class="mb-3 fw-bold text-info">
                                    <i class="fas fa-shield-alt me-2"></i>{{ __('common.defense_form') }}
                                </h6>
                                <form method="POST" action="{{ route('driver.defenses.submit') }}" id="defenseForm_{{ $track->decision_id }}">
                                    @csrf
                                    <input type="hidden" name="decision_id" value="{{ $track->decision_id }}">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="fab fa-youtube me-1 text-info"></i>{{ __('common.defense_video_youtube') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="url" name="comp_video" required class="form-control form-input" placeholder="https://www.youtube.com/watch?v=...">
                                        <small class="text-muted mt-1 d-block">
                                            <i class="fas fa-info-circle me-1"></i>{{ __('common.enter_defense_video_link') }}
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="fas fa-file-alt me-1 text-info"></i>{{ __('common.defense_description') }} <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="comp_desc" rows="5" required class="form-control form-input" placeholder="{{ __('common.defense_description_placeholder') }}"></textarea>
                                    </div>

                                    <button type="submit" class="submit-btn mt-3">
                                        <i class="fas fa-paper-plane me-2"></i> {{ __('common.send_defense') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Form submit confirmation
    document.querySelectorAll('form[id^="defenseForm_"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '{{ __('common.are_you_sure') }}',
                text: '{{ __('common.send_defense_confirm') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __('common.yes_send') }}',
                cancelButtonText: '{{ __('common.cancel') }}',
                confirmButtonColor: '#0ea5e9'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Countdown Timer - Şikayetten sonraki 24 saat için geri sayım
    document.addEventListener('DOMContentLoaded', function() {
        const headerTimer = document.querySelector('.countdown-timer-header');
        
        if (!headerTimer) {
            console.log('Countdown timer element not found');
            return;
        }
        
        const deadlineAttr = headerTimer.getAttribute('data-deadline');
        if (!deadlineAttr) {
            console.error('data-deadline attribute not found');
            return;
        }
        
        const deadline = parseInt(deadlineAttr);
        if (isNaN(deadline) || deadline <= 0) {
            console.error('Invalid deadline timestamp:', deadlineAttr);
            return;
        }
        
        const hoursEl = headerTimer.querySelector('.hours');
        const minutesEl = headerTimer.querySelector('.minutes');
        const secondsEl = headerTimer.querySelector('.seconds');
        
        if (!hoursEl || !minutesEl || !secondsEl) {
            console.error('Countdown time elements not found');
            return;
        }
        
        function updateCountdown() {
            const now = Math.floor(Date.now() / 1000);
            const remaining = deadline - now;
            
            if (remaining <= 0) {
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';
                headerTimer.classList.add('countdown-expired');
                const display = headerTimer.querySelector('.countdown-display-header');
                if (display) {
                    display.innerHTML = '<span class="text-warning fw-bold">{{ __('common.time_expired') }}</span>';
                }
                return false; // Interval'i durdur
            }
            
            const hours = Math.floor(remaining / 3600);
            const minutes = Math.floor((remaining % 3600) / 60);
            const seconds = remaining % 60;
            
            hoursEl.textContent = String(hours).padStart(2, '0');
            minutesEl.textContent = String(minutes).padStart(2, '0');
            secondsEl.textContent = String(seconds).padStart(2, '0');
            
            // Son 1 saatte uyarı rengi
            if (remaining < 3600) {
                headerTimer.classList.add('countdown-expired');
            } else {
                headerTimer.classList.remove('countdown-expired');
            }
            
            return true; // Devam et
        }
        
        // İlk güncelleme
        updateCountdown();
        
        // Her saniye güncelle
        const interval = setInterval(function() {
            if (!updateCountdown()) {
                clearInterval(interval);
            }
        }, 1000);
    });
</script>
@endsection
