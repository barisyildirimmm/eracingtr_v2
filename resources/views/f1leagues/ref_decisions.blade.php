@extends('layouts.layout')

@section('content')
<style>
    .complaint-scroll {
        height: 120px;
        overflow-y: auto;
        padding-right: 5px;
    }
    .complaint-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .complaint-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .complaint-scroll::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 3px;
    }
    .complaint-scroll::-webkit-scrollbar-thumb:hover {
        background: #c82333;
    }
    .decision-scroll {
        height: 300px;
        overflow-y: auto;
    }
    .decision-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .decision-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .decision-scroll::-webkit-scrollbar-thumb {
        background: #17a2b8;
        border-radius: 3px;
    }
    .decision-scroll::-webkit-scrollbar-thumb:hover {
        background: #138496;
    }
    .decision-scroll-success::-webkit-scrollbar-thumb {
        background: #28a745;
    }
    .decision-scroll-success::-webkit-scrollbar-thumb:hover {
        background: #218838;
    }
    .decision-scroll-danger::-webkit-scrollbar-thumb {
        background: #dc3545;
    }
    .decision-scroll-danger::-webkit-scrollbar-thumb:hover {
        background: #c82333;
    }
    .decision-description-scroll {
        height: 100px;
        overflow-y: auto;
        padding-right: 5px;
    }
    .decision-description-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .decision-description-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .decision-description-scroll-success::-webkit-scrollbar-thumb {
        background: #28a745;
        border-radius: 3px;
    }
    .decision-description-scroll-success::-webkit-scrollbar-thumb:hover {
        background: #218838;
    }
    .decision-description-scroll-danger::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 3px;
    }
    .decision-description-scroll-danger::-webkit-scrollbar-thumb:hover {
        background: #c82333;
    }
    .defense-made {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.25) 100%);
        border: 2px solid #28a745;
        color: #155724;
    }
    .defense-not-made {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 193, 7, 0.25) 100%);
        border: 2px solid #ffc107;
        color: #856404;
    }
    .decision-section {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(23, 162, 184, 0.2) 100%);
        border-top: 3px solid #17a2b8;
    }
    .decision-description {
        background: rgba(23, 162, 184, 0.15);
        border: 1px solid #17a2b8;
        color: #0c5460;
    }
    .penalty-badge-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }
    .penalty-badge-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #856404;
        border: none;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }
</style>
    <!-- Page Heading
                              ================================================== -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">{{ __('common.referee_decisions') }}</h1>
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
            <!-- {{ __('common.track_selection_cards') }} -->
            @if(isset($tracks) && $tracks->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @foreach($tracks as $track)
                            <a href="{{ route('f1Leagues.refDecisions', ['leagueLink' => $link, 'trackId' => $track->f1_league_track_id]) }}"
                               class="btn track-tab px-4 py-2 fw-bold shadow-sm rounded-pill m-1
                                {{ isset($trackId) && $trackId == $track->f1_league_track_id ? 'btn-danger text-white' : 'btn-outline-secondary' }}">
                                <i class="fas fa-flag-checkered"></i> {{ $track->track_name }}
                                @if($track->sprint_status)
                                    <span class="badge bg-warning text-dark ml-1">{{ __('common.sprint') }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if(isset($selectedTrack) && isset($complaints))
            <!-- {{ __('common.selected_track_info') }} -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-gavel mr-1"></i>
                        {{ $selectedTrack->track_name }}
                        @if($selectedTrack->sprint_status)
                            <span class="badge bg-warning text-dark ml-1">{{ __('common.sprint') }}</span>
                        @endif
                        <small class="ml-2 text-muted">{{ $selectedTrack->race_date_formatted }}</small>
                    </h4>
                </div>
            </div>

            <!-- {{ __('common.complaints') }} -->
            @if(count($complaints) > 0)
                <div class="row">
                    @foreach ($complaints as $complaint)
                        @php
                            // Soldaki çubuk rengini belirle
                            $borderColor = '#dc3545'; // Varsayılan: kırmızı (şikayet)
                            if ($selectedTrack->referee_decision_complete == 0) {
                                $borderColor = '#17a2b8'; // Mavi (karar bekleniyor)
                            } elseif ($selectedTrack->referee_decision_complete == 1) {
                                // Ceza kontrolü: penalty değeri üzerinden kontrol et
                                $penaltyValue = $complaint['penalty'] ?? '';
                                $hasPenalty = !empty($penaltyValue) && trim($penaltyValue) != __('common.no_penalty_required_text');
                                if (!$hasPenalty) {
                                    $borderColor = '#28a745'; // Yeşil (ceza yok)
                                } else {
                                    $borderColor = '#dc3545'; // Kırmızı (ceza var)
                                }
                            }
                        @endphp
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card shadow-sm h-100" style="border-left: 5px solid {{ $borderColor }}; border-radius: 0.5rem; background: #f8f9fa;">
                                <!-- Header -->
                                <div class="card-header" style="background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); border-bottom: 2px solid {{ $borderColor }};">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-danger" style="font-size: 0.85rem;">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ str_replace(':id', $complaint['id'], __('common.complaint_number')) }}
                                        </h6>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                                            {{ $complaint['complainant_name'] }} → {{ $complaint['complained_name'] }}
                                        </small>
                                        <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                                            <i class="fas fa-clock mr-1"></i>{{ $complaint['created_at'] }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="card-body" style="background: #f8f9fa;">
                                    <!-- Şikayet -->
                                    <div class="mb-3">
                                        <h6 class="text-danger fw-semibold mb-2" style="font-size: 0.8rem;">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ __('common.complaint') }}
                                        </h6>
                                        @if($complaint['reminder'])
                                            <div class="p-2 rounded border border-danger complaint-scroll" style="background: rgba(220, 53, 69, 0.1); font-size: 0.75rem; color: #721c24;">
                                                <p class="mb-0" style="line-height: 1.4;">{{ $complaint['reminder'] }}</p>
                                            </div>
                                        @else
                                            <div class="p-2 rounded border border-danger complaint-scroll" style="background: rgba(220, 53, 69, 0.1); font-size: 0.75rem;">
                                                <p class="mb-0 text-muted">{{ __('common.no_complaint_text') }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Savunma Durumu -->
                                    <div class="mb-3">
                                        <h6 class="text-info fw-semibold mb-2" style="font-size: 0.8rem;">
                                            <i class="fas fa-shield-alt mr-1"></i>{{ __('common.defense_title') }}
                                        </h6>
                                        @if($complaint['has_defense'])
                                            <div class="p-2 rounded defense-made" style="font-size: 0.75rem;">
                                                <p class="mb-0 fw-bold">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    {{ __('common.defense_made') }}
                                                    @if($complaint['comp_date'])
                                                        <br><small style="opacity: 0.8;">({{ $complaint['comp_date'] }})</small>
                                                    @endif
                                                </p>
                                            </div>
                                        @else
                                            <div class="p-2 rounded defense-not-made" style="font-size: 0.75rem;">
                                                <p class="mb-0 fw-bold">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    {{ __('common.defense_not_made') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Hakem Kararı (Card Altında) -->
                                @if($selectedTrack->referee_decision_complete == 0)
                                    <!-- Karar Bekleniyor - Info (Mavi) -->
                                    <div class="card-footer border-top decision-scroll" style="background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(23, 162, 184, 0.2) 100%); border-top: 3px solid #17a2b8;">
                                        <div class="text-center py-2">
                                            <i class="fas fa-clock mb-2" style="color: #17a2b8; font-size: 1.2rem;"></i>
                                            <p class="mb-0 fw-bold" style="font-size: 0.75rem; color: #0c5460;">{{ __('common.decision_pending') }}</p>
                                        </div>
                                    </div>
                                @else
                                    @php
                                        // Ceza kontrolü: penalty değeri üzerinden kontrol et
                                        $penaltyValue = $complaint['penalty'] ?? '';
                                        $hasPenalty = !empty($penaltyValue) && trim($penaltyValue) != __('common.no_penalty_required_text');
                                    @endphp
                                    @if(!$hasPenalty)
                                        <!-- Cezaya Gerek Görülmedi - Success (Yeşil) -->
                                        <div class="card-footer border-top decision-scroll decision-scroll-success" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.2) 100%); border-top: 3px solid #28a745;">
                                            <h6 class="fw-semibold mb-2" style="font-size: 0.8rem; color: #155724;">
                                                <i class="fas fa-gavel mr-1"></i>{{ __('common.referee_decision') }}
                                            </h6>
                                            
                                            @if($complaint['description'])
                                                <div class="mb-2 p-2 rounded decision-description-scroll decision-description-scroll-success" style="background: rgba(40, 167, 69, 0.15); border: 1px solid #28a745; font-size: 0.7rem;">
                                                    <small class="d-block mb-1 fw-bold" style="color: #155724;">{{ __('common.description_label') }}</small>
                                                    <p class="mb-0" style="color: #155724; line-height: 1.4;">{{ $complaint['description'] }}</p>
                                                </div>
                                            @endif

                                            <div class="p-2 rounded" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745;">
                                                <p class="mb-0 fw-bold text-center" style="font-size: 0.75rem; color: #155724;">
                                                    <i class="fas fa-check-circle mr-1"></i>{{ __('common.no_penalty_required') }}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Ceza Verildi - Danger (Kırmızı) -->
                                        <div class="card-footer border-top decision-scroll decision-scroll-danger" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.2) 100%); border-top: 3px solid #dc3545;">
                                            <h6 class="fw-semibold mb-2" style="font-size: 0.8rem; color: #721c24;">
                                                <i class="fas fa-gavel mr-1"></i>{{ __('common.referee_decision') }}
                                            </h6>
                                            
                                            @if($complaint['description'])
                                                <div class="mb-2 p-2 rounded decision-description-scroll decision-description-scroll-danger" style="background: rgba(220, 53, 69, 0.15); border: 1px solid #dc3545; font-size: 0.7rem;">
                                                    <small class="d-block mb-1 fw-bold" style="color: #721c24;">{{ __('common.description_label') }}</small>
                                                    <p class="mb-0" style="color: #721c24; line-height: 1.4;">{{ $complaint['description'] }}</p>
                                                </div>
                                            @endif

                                            <div class="mb-2">
                                                <small class="d-block mb-1 fw-bold" style="font-size: 0.7rem; color: #721c24;">{{ __('common.penalty_label') }}</small>
                                                @if($complaint['penalty_name'])
                                                    <div class="mb-1">
                                                        <span class="badge penalty-badge-danger d-block text-start p-2" style="font-size: 0.7rem;">
                                                            <i class="fas fa-ban mr-1"></i>{{ $complaint['penalty_name'] }}
                                                            @if($complaint['penalty_point'])
                                                                <br><small style="opacity: 0.9;">{{ $complaint['penalty_point'] }} {{ __('common.points_label') }}</small>
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif
                                                @if($complaint['penalty_desc_name'])
                                                    <div>
                                                        <span class="badge penalty-badge-warning d-block text-start p-2" style="font-size: 0.7rem;">
                                                            <i class="fas fa-info-circle mr-1"></i>{{ $complaint['penalty_desc_name'] }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3"></i>
                        <p class="h5">{{ __('common.no_complaints_for_race') }}</p>
                    </div>
                </div>
            @endif
            @else
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center text-muted py-5">
                        <i class="fas fa-info-circle fa-4x mb-3"></i>
                        <p class="h5">{{ __('common.select_track_to_view_decisions') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Content / End -->
@endsection
