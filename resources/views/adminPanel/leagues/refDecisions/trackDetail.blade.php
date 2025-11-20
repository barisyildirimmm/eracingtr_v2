@extends('adminPanel.layouts.main')
@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="box-title mb-0">
                                <a href="{{ route('admin.leagues.refDecisions', $leagueId) }}" class="text-primary text-decoration-none me-2">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                {{ $track->track_name }}{{ __('common.referee_decisions_for_track') }}
                            </h5>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $track->race_date_formatted }}
                                @if($track->sprint_status)
                                    <span class="badge bg-warning text-dark ms-2">{{ __('common.sprint') }}</span>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    @if(count($complaints) > 0)
                        @foreach ($complaints as $complaint)
                            <div class="card mb-4 shadow-sm" style="border-left: 5px solid #dc3545; border-radius: 0.5rem;">
                                <!-- Header -->
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1 fw-bold text-danger">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                {{ str_replace(':id', $complaint['id'], __('common.complaint_number')) }} - {{ $complaint['complainant_name'] }} → {{ $complaint['complained_name'] }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>{{ $complaint['created_at'] }}
                                            </small>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="openDetailModal({{ $complaint['id'] }}, {{ $complaint['penalty_id'] ?? 'null' }}, {{ $complaint['penalty_desc_id'] ?? 'null' }}, {{ json_encode($complaint['description'] ?? '') }})">
                                            <i class="fas fa-edit me-1"></i> {{ __('common.detail') }}
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Sol Taraf: Şikayet ve Savunma -->
                                        <div class="col-md-8">
                                            <!-- Şikayet -->
                                            <div class="mb-3 pb-3 border-bottom">
                                                <h6 class="text-danger fw-semibold mb-2">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ __('common.complaint') }}
                                                </h6>
                                                @if($complaint['video_link'])
                                                    @php
                                                        // YouTube video ID çıkar
                                                        $videoId = null;
                                                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $complaint['video_link'], $matches)) {
                                                            $videoId = $matches[1];
                                                        }
                                                    @endphp
                                                    @if($videoId)
                                                        <div class="mb-3">
                                                            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 0.5rem;">
                                                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
                                                            </div>
                                                            <a href="{{ $complaint['video_link'] }}" target="_blank" class="btn btn-sm btn-outline-danger mt-2">
                                                                <i class="fas fa-external-link-alt me-1"></i> {{ __('common.open_on_youtube') }}
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="mb-2">
                                                            <a href="{{ $complaint['video_link'] }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-video me-1"></i> {{ __('common.watch_video') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if($complaint['reminder'])
                                                    <div class="p-2 bg-light rounded">
                                                        <p class="mb-0">{{ $complaint['reminder'] }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Savunma -->
                                            @if($complaint['has_defense'])
                                                <div class="mb-3 pb-3 border-bottom">
                                                    <h6 class="text-info fw-semibold mb-2">
                                                        <i class="fas fa-shield-alt me-1"></i>{{ __('common.defense_title') }}
                                                        @if($complaint['comp_date'])
                                                            <small class="text-muted ms-2">({{ $complaint['comp_date'] }})</small>
                                                        @endif
                                                    </h6>
                                                    @if($complaint['comp_video'])
                                                        @php
                                                            // YouTube video ID çıkar
                                                            $compVideoId = null;
                                                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $complaint['comp_video'], $matches)) {
                                                                $compVideoId = $matches[1];
                                                            }
                                                        @endphp
                                                        @if($compVideoId)
                                                            <div class="mb-3">
                                                                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 0.5rem;">
                                                                    <iframe src="https://www.youtube.com/embed/{{ $compVideoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
                                                                </div>
                                                                <a href="{{ $complaint['comp_video'] }}" target="_blank" class="btn btn-sm btn-outline-info mt-2">
                                                                    <i class="fas fa-external-link-alt me-1"></i> {{ __('common.open_on_youtube') }}
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="mb-2">
                                                                <a href="{{ $complaint['comp_video'] }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                                    <i class="fas fa-video me-1"></i> {{ __('common.watch_video') }}
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if($complaint['comp_desc'])
                                                        <div class="p-2 bg-light rounded">
                                                            <p class="mb-0">{{ $complaint['comp_desc'] }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <!-- İtirazlar -->
                                            @if(count($complaint['appeals']) > 0)
                                                <div class="mb-3">
                                                    <h6 class="text-warning fw-semibold mb-2">
                                                        <i class="fas fa-gavel me-1"></i>{{ __('common.appeals_title') }} 
                                                        <span class="badge bg-warning text-dark">{{ count($complaint['appeals']) }}</span>
                                                    </h6>
                                                    @foreach($complaint['appeals'] as $appeal)
                                                        <div class="card border-warning mb-2" style="border-left: 3px solid #ffc107;">
                                                            <div class="card-body p-2">
                                                                <div class="small">
                                                                    <strong>{{ $appeal['driver_name'] }}</strong>
                                                                    @if($appeal['description'])
                                                                        <p class="mb-1 mt-1">{{ $appeal['description'] }}</p>
                                                                    @endif
                                                                    @if($appeal['result'] || $appeal['confirm'])
                                                                        <div>
                                                                            @if($appeal['result'])
                                                                                <span class="badge bg-success">{{ $appeal['result'] }}</span>
                                                                            @endif
                                                                            @if($appeal['confirm'])
                                                                                <span class="badge bg-info">{{ $appeal['confirm'] }}</span>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Sağ Taraf: Hakem Kararı -->
                                        <div class="col-md-4 border-start ps-3">
                                            <h6 class="text-success fw-semibold mb-3">
                                                <i class="fas fa-gavel me-1"></i>{{ __('common.referee_decision') }}
                                            </h6>
                                            
                                            @if($complaint['description'])
                                                <div class="mb-3 p-2 bg-info bg-opacity-10 rounded border border-info">
                                                    <small class="text-muted d-block mb-1">{{ __('common.description_label') }}</small>
                                                    <p class="mb-0 small">{{ $complaint['description'] }}</p>
                                                </div>
                                            @endif

                                            @if($complaint['penalty_name'] || $complaint['penalty_desc_name'])
                                                <div class="mb-3">
                                                    <small class="text-muted d-block mb-2">{{ __('common.penalty_label') }}</small>
                                                    @if($complaint['penalty_name'])
                                                        <div class="mb-2">
                                                            <span class="badge bg-danger d-block text-start p-2">
                                                                <i class="fas fa-ban me-1"></i>{{ $complaint['penalty_name'] }}
                                                                @if($complaint['penalty_point'])
                                                                    <br><small class="opacity-75">{{ $complaint['penalty_point'] }} {{ __('common.points_label') }}</small>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if($complaint['penalty_desc_name'])
                                                        <div>
                                                            <span class="badge bg-warning text-dark d-block text-start p-2">
                                                                <i class="fas fa-info-circle me-1"></i>{{ $complaint['penalty_desc_name'] }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-muted small">
                                                    <i class="fas fa-info-circle me-1"></i>{{ __('common.no_penalty_yet') }}
                                                </div>
                                            @endif

                                            <!-- Yorumlar -->
                                            @if(isset($complaint['comments']) && count($complaint['comments']) > 0)
                                                <div class="mt-3 pt-3 border-top">
                                                    <small class="text-muted d-block mb-2">
                                                        <i class="fas fa-comments me-1"></i>{{ __('common.comments_title') }} ({{ count($complaint['comments']) }})
                                                    </small>
                                                    @foreach($complaint['comments'] as $comment)
                                                        <div class="p-3 bg-light rounded mb-2">
                                                            <div class="mb-2">
                                                                <strong class="text-muted d-block mb-1">
                                                                    <i class="fas fa-user me-1"></i>{{ $comment['user_name'] }}
                                                                </strong>
                                                            </div>
                                                            <div class="mb-2">
                                                                <p class="mb-0 small">{{ $comment['comment'] }}</p>
                                                            </div>
                                                            @if($comment['penalty_id'] || $comment['penalty_desc_id'])
                                                                <div class="mt-2 pt-2 border-top">
                                                                    <small class="text-muted d-block mb-1 fw-semibold">
                                                                        <i class="fas fa-gavel me-1"></i>{{ __('common.penalty_given') }}
                                                                    </small>
                                                                    <div>
                                                                        @if($comment['penalty_id'] && $comment['penalty_name'])
                                                                            <span class="badge bg-danger me-1">
                                                                                <i class="fas fa-ban me-1"></i>P: {{ $comment['penalty_name'] }}
                                                                            </span>
                                                                        @endif
                                                                        @if($comment['penalty_desc_id'] && $comment['penalty_desc_name'])
                                                                            <span class="badge bg-warning text-dark">
                                                                                <i class="fas fa-info-circle me-1"></i>PD: {{ $comment['penalty_desc_name'] }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-4x mb-3"></i>
                            <p class="h5">{{ __('common.no_complaints_for_race') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detay Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">{{ __('common.decision_details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="detailForm">
                        <input type="hidden" id="modal_decision_id" name="decision_id">
                        <div class="mb-3">
                            <label for="penalty_id" class="form-label">{{ __('common.penalty_name') }}</label>
                            <select class="form-control" id="penalty_id" name="penalty_id">
                                <option value="">{{ __('common.select_penalty') }}</option>
                                @foreach ($penalties as $penalty)
                                    <option value="{{ $penalty->id }}">{{ $penalty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="penalty_desc_id" class="form-label">{{ __('common.penalty_description_name') }}</label>
                            <select class="form-control" id="penalty_desc_id" name="penalty_desc_id">
                                <option value="">{{ __('common.select_penalty_desc') }}</option>
                                @foreach ($penaltyDescs as $penaltyDesc)
                                    <option value="{{ $penaltyDesc->id }}">{{ $penaltyDesc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('common.referee_description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="{{ __('common.referee_description_placeholder') }}"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                    <button type="button" class="btn btn-primary" onclick="saveDetail()">{{ __('common.save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // Tooltip'leri aktif et
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        function openDetailModal(decisionId, penaltyId, penaltyDescId, description) {
            $('#modal_decision_id').val(decisionId);
            $('#penalty_id').val(penaltyId && penaltyId !== 'null' && penaltyId !== null ? penaltyId : '');
            $('#penalty_desc_id').val(penaltyDescId && penaltyDescId !== 'null' && penaltyDescId !== null ? penaltyDescId : '');
            try {
                const desc = typeof description === 'string' ? JSON.parse(description) : (description || '');
                $('#description').val(desc);
            } catch(e) {
                $('#description').val(description || '');
            }
            $('#detailModal').modal('show');
        }

        function saveDetail() {
            const decisionId = $('#modal_decision_id').val();
            const penaltyId = $('#penalty_id').val();
            const penaltyDescId = $('#penalty_desc_id').val();
            const description = $('#description').val();

            $.ajax({
                url: '{{ route('admin.leagues.updateDecisionDetail') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    decision_id: decisionId,
                    penalty_id: penaltyId || null,
                    penalty_desc_id: penaltyDescId || null,
                    description: description || null
                },
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
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
                }
            });
        }
    </script>
@endsection
