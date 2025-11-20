@extends('driverPanel.layouts.main')

@section('content')
<style>
    .complaint-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .page-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
    .form-card {
        background: linear-gradient(to bottom, #fff5f5 0%, #ffffff 100%);
        border-left: 4px solid #dc3545;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(220, 53, 69, 0.1);
    }
    .form-input {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    .form-input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        outline: none;
    }
    .submit-btn {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.5);
    }
    .previous-complaints-card {
        background: linear-gradient(to bottom, #f0f9ff 0%, #ffffff 100%);
        border-left: 4px solid #0ea5e9;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    .complaint-item {
        background: white;
        border-left: 4px solid #dc3545;
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .complaint-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
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
    .defense-section {
        background: linear-gradient(to bottom, #eff6ff 0%, #ffffff 100%);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 1rem;
        border-left: 3px solid #0ea5e9;
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
    .delete-btn {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    .delete-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
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
    .countdown-timer {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .countdown-display {
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

<div class="complaint-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ __('common.my_complaints') }}
                    </h2>
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <p class="mb-0 opacity-90">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ str_replace(':hours', enums()['complaint_time_limit_minutes'] / 60, __('common.complaint_time_info')) }}
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
                @if($tracks->isNotEmpty())
                <div class="info-badge">
                    <i class="fas fa-ticket-alt"></i>
                    <span class="fw-bold">{{ __('common.remaining_rights') }}: <span class="badge-modern bg-{{ $remainingComplaints > 0 ? 'success' : 'danger' }} ms-2">{{ $remainingComplaints }} / {{ $maxComplaints }}</span></span>
                </div>
                @endif
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

        @if($tracks->isEmpty())
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h4 class="text-muted mb-2">{{ __('common.no_race_to_complain') }}</h4>
                <p class="text-muted">{{ __('common.no_race_to_complain_desc') }}</p>
            </div>
        @else
            <!-- Race Cards -->
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
                        <!-- New Complaint Form -->
                        <div class="form-card">
                            <h6 class="mb-3 fw-bold text-danger">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('common.new_complaint_send') }}
                            </h6>
                            <form method="POST" action="{{ route('driver.complaints.submit') }}" id="complaintForm_{{ $track->id }}">
                                @csrf
                                <input type="hidden" name="track_id" value="{{ $track->track_id }}">
                                <input type="hidden" name="league_id" value="{{ $track->league_id }}">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="fas fa-user me-1 text-danger"></i>{{ __('common.complained_driver') }} <span class="text-danger">*</span>
                                        </label>
                                        <select name="complained" required class="form-control form-input">
                                            <option value="">{{ __('common.select_driver') }}</option>
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}">{{ $driver->name }} {{ $driver->surname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="fab fa-youtube me-1 text-danger"></i>{{ __('common.video_link_youtube') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="url" name="video_link" required class="form-control form-input" placeholder="https://www.youtube.com/watch?v=...">
                                        <small class="text-muted mt-1 d-block">
                                            <i class="fas fa-info-circle me-1"></i>{{ __('common.enter_youtube_link') }}
                                        </small>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label fw-semibold mb-2">
                                        <i class="fas fa-file-alt me-1 text-danger"></i>{{ __('common.complaint_description') }} <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="reminder" rows="5" required class="form-control form-input" placeholder="{{ __('common.complaint_description_placeholder') }}"></textarea>
                                </div>

                                <div class="mt-3 p-3 rounded" style="background: rgba(220, 53, 69, 0.05); border-left: 3px solid #dc3545;">
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-clock me-2 text-danger"></i>
                                        {{ str_replace(':minutes', enums()['complaint_delete_time_seconds'] / 60, __('common.complaint_delete_info')) }}
                                    </small>
                                </div>

                                <button type="submit" class="submit-btn mt-4">
                                    <i class="fas fa-paper-plane me-2"></i> {{ __('common.send_complaint') }}
                                </button>
                            </form>
                        </div>

                        <!-- Previous Complaints -->
                        @if(isset($track->previous_decisions) && $track->previous_decisions->count())
                            <div class="previous-complaints-card">
                                <h6 class="mb-3 fw-bold text-info">
                                    <i class="fas fa-history me-2"></i>{{ __('common.previous_complaints') }}
                                    <span class="badge bg-info ms-2">{{ $track->previous_decisions->count() }}</span>
                                </h6>
                                <div class="row g-3">
                                    @foreach($track->previous_decisions as $decision)
                                        <div class="col-md-6">
                                            <div class="complaint-item">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div>
                                                        <small class="text-muted d-block mb-1">
                                                            <i class="fas fa-user-slash me-1"></i>{{ __('common.complained') }}
                                                        </small>
                                                        <strong class="text-danger">{{ $decision->complained_name }}</strong>
                                                    </div>
                                                    @if($decision->can_delete)
                                                        <form method="POST" action="{{ route('driver.complaints.delete', $decision->id) }}" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="delete-btn" title="{{ str_replace(':time', $decision->delete_deadline, __('common.delete_until')) }}">
                                                                <i class="fas fa-trash me-1"></i>{{ __('common.delete') }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>

                                                @if($decision->video_link)
                                                    @php
                                                        $videoId = null;
                                                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $decision->video_link, $matches)) {
                                                            $videoId = $matches[1];
                                                        }
                                                    @endphp
                                                    @if($videoId)
                                                        <div class="video-container">
                                                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        </div>
                                                    @endif
                                                @endif

                                                <div class="mb-3">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="fas fa-comment me-1"></i>{{ __('common.description') }}
                                                    </small>
                                                    <p class="mb-0" style="line-height: 1.6;">{{ $decision->reminder }}</p>
                                                </div>

                                                @if($decision->comp_video || $decision->comp_desc)
                                                    <div class="defense-section">
                                                        <small class="text-info fw-bold d-block mb-2">
                                                            <i class="fas fa-shield-alt me-1"></i>Savunma
                                                        </small>
                                                        @if($decision->comp_video)
                                                            @php
                                                                $compVideoId = null;
                                                                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $decision->comp_video, $matches)) {
                                                                    $compVideoId = $matches[1];
                                                                }
                                                            @endphp
                                                            @if($compVideoId)
                                                                <div class="video-container">
                                                                    <iframe src="https://www.youtube.com/embed/{{ $compVideoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if($decision->comp_desc)
                                                            <div class="p-3 rounded" style="background: rgba(14, 165, 233, 0.05);">
                                                                <p class="mb-0" style="line-height: 1.6;">{{ $decision->comp_desc }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
        document.querySelectorAll('form[id^="complaintForm_"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: '{{ __('common.are_you_sure') }}',
                    text: '{{ __('common.send_complaint_confirm') }}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('common.yes_send') }}',
                    cancelButtonText: '{{ __('common.cancel') }}',
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: '{{ __('common.are_you_sure') }}',
                    text: '{{ __('common.delete_complaint_confirm') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('common.yes_delete') }}',
                    cancelButtonText: '{{ __('common.cancel') }}',
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Countdown Timer - Yarıştan sonraki 4 saat için geri sayım
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
