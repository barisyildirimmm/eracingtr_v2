@extends('driverPanel.layouts.main')

@section('content')
<style>
    .appeal-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .page-header-card {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
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
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
    .defense-section {
        background: linear-gradient(to bottom, #f0f9ff 0%, #ffffff 100%);
        border-left: 4px solid #0ea5e9;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(14, 165, 233, 0.1);
    }
    .appeal-form-card {
        background: linear-gradient(to bottom, #fffbeb 0%, #ffffff 100%);
        border-left: 4px solid #f59e0b;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(245, 158, 11, 0.1);
    }
    .form-input {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    .form-input:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        outline: none;
    }
    .submit-btn {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
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
    .badge-modern {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .info-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
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

<div class="appeal-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-gavel me-2"></i>{{ __('common.my_appeals') }}
                    </h2>
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <p class="mb-0 opacity-90">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ str_replace(':days', enums()['appeal_time_limit_days'], __('common.appeal_time_info')) }}
                        </p>
                        @if($appeals->isNotEmpty())
                            @php
                                $firstAppeal = $appeals->first();
                                $hours = floor($firstAppeal->remaining_seconds / 3600);
                                $minutes = floor(($firstAppeal->remaining_seconds % 3600) / 60);
                                $seconds = $firstAppeal->remaining_seconds % 60;
                            @endphp
                            <div class="countdown-timer-header" data-deadline="{{ $firstAppeal->deadline_timestamp }}">
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
                <div class="info-badge">
                    <i class="fas fa-ticket-alt"></i>
                    <span class="fw-bold">{{ __('common.remaining_rights') }}: <span class="badge-modern bg-{{ $remainingAppeals > 0 ? 'success' : 'danger' }} ms-2">{{ $remainingAppeals }} / {{ $maxAppeals }}</span></span>
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

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 0.75rem; border: none;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($appeals->isEmpty())
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <h4 class="text-muted mb-2">{{ __('common.no_appeal_available') }}</h4>
                <p class="text-muted">{{ __('common.no_appeal_available_desc') }}</p>
            </div>
        @else
            <!-- Appeal Cards -->
            @foreach($appeals as $appeal)
                <div class="race-card">
                    <!-- Race Header -->
                    <div class="race-header">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <h5 class="mb-2 fw-bold">
                                    <i class="fas fa-flag-checkered me-2"></i>
                                    {{ $appeal->track_name }}
                                </h5>
                                <p class="mb-1 opacity-90">
                                    <i class="fas fa-trophy me-2"></i>{{ $appeal->league_name }}
                                </p>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-calendar-alt me-2"></i>{{ tarihBicimi($appeal->race_date, 4) }}
                                    @if($appeal->sprint_status)
                                        <span class="badge bg-light text-dark ms-2">{{ __('common.sprint') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="row g-4">
                            <!-- Sol Taraf: Şikayet ve Savunma -->
                            <div class="col-md-7">
                                <!-- Şikayet -->
                                @if($appeal->has_complaint)
                                    <div class="complaint-section">
                                        <h6 class="mb-3 fw-bold text-danger">
                                            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('common.my_complaints') }}
                                        </h6>
                                        <div class="row mb-3">
                                            <div class="col-sm-6 mb-2">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-user me-1"></i>{{ __('common.complainant') }}
                                                </small>
                                                <strong class="text-danger">{{ $appeal->complainant_name }}</strong>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-user-slash me-1"></i>{{ __('common.complained') }}
                                                </small>
                                                <strong class="text-danger">{{ $appeal->complained_name }}</strong>
                                            </div>
                                        </div>

                                        @if($appeal->video_link)
                                            @php
                                                $videoId = null;
                                                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $appeal->video_link, $matches)) {
                                                    $videoId = $matches[1];
                                                }
                                            @endphp
                                            @if($videoId)
                                                <div class="video-container">
                                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                </div>
                                            @endif
                                        @endif

                                        @if($appeal->reminder)
                                            <div class="mt-3">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-comment me-1"></i>{{ __('common.description') }}
                                                </small>
                                                <div class="p-3 rounded" style="background: rgba(220, 53, 69, 0.05);">
                                                    <p class="mb-0" style="line-height: 1.6;">{{ $appeal->reminder }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Savunma -->
                                @if($appeal->has_defense)
                                    <div class="defense-section">
                                        <h6 class="mb-3 fw-bold text-info">
                                            <i class="fas fa-shield-alt me-2"></i>{{ __('common.my_defenses') }}
                                        </h6>

                                        @if($appeal->comp_video)
                                            @php
                                                $compVideoId = null;
                                                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $appeal->comp_video, $matches)) {
                                                    $compVideoId = $matches[1];
                                                }
                                            @endphp
                                            @if($compVideoId)
                                                <div class="video-container">
                                                    <iframe src="https://www.youtube.com/embed/{{ $compVideoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                </div>
                                            @endif
                                        @endif

                                        @if($appeal->comp_desc)
                                            <div class="mt-3">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-file-alt me-1"></i>{{ __('common.description') }}
                                                </small>
                                                <div class="p-3 rounded" style="background: rgba(14, 165, 233, 0.05);">
                                                    <p class="mb-0" style="line-height: 1.6;">{{ $appeal->comp_desc }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Sağ Taraf: İtiraz Formu -->
                            <div class="col-md-5">
                                <div class="appeal-form-card">
                                    <h6 class="mb-3 fw-bold text-warning">
                                        <i class="fas fa-gavel me-2"></i>{{ __('common.appeal_form') }}
                                    </h6>
                                    <form method="POST" action="{{ route('driver.appeals.submit') }}" id="appealForm_{{ $appeal->decision_id }}">
                                        @csrf
                                        <input type="hidden" name="ref_id" value="{{ $appeal->decision_id }}">

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold mb-2">
                                                <i class="fas fa-file-alt me-1 text-warning"></i>{{ __('common.appeal_description') }} <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="description" rows="8" required class="form-control form-input" placeholder="{{ __('common.appeal_description_placeholder') }}"></textarea>
                                            <small class="text-muted mt-1 d-block">
                                                <i class="fas fa-info-circle me-1"></i>{{ __('common.appeal_description_info') }}
                                            </small>
                                        </div>

                                        <button type="submit" class="submit-btn">
                                            <i class="fas fa-paper-plane me-2"></i> {{ __('common.send_appeal') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Form submit confirmation
    document.querySelectorAll('form[id^="appealForm_"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '{{ __('common.are_you_sure') }}',
                text: '{{ __('common.send_appeal_confirm') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __('common.yes_send') }}',
                cancelButtonText: '{{ __('common.cancel') }}',
                confirmButtonColor: '#f59e0b'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Countdown Timer - Yarıştan sonraki 3 gün için geri sayım
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
            
            // Son 24 saatte uyarı rengi
            if (remaining < 86400) {
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
