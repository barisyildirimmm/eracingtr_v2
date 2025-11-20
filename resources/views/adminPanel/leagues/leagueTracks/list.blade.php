@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .league-tracks-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
            color: white;
        }
        .tracks-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 1.5rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-add {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }
        .table thead th {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: #fff;
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
            border: none;
        }
        .table tbody td {
            vertical-align: middle;
            text-align: center;
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: all 0.2s ease;
        }
        .action-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin: 0 0.25rem;
        }
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            color: white;
        }
        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            color: white;
        }
        .badge-sprint {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .badge-qualifying {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        .modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
            border: none;
            padding: 1.5rem;
        }
        .modal-title {
            font-weight: 600;
        }
        .btn-close {
            filter: brightness(0) invert(1);
        }
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
    </style>
@endsection
@section('content')
<div class="league-tracks-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-road me-2"></i>{{ __('common.league_tracks') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.view_create_edit_tracks') }}
            </p>
        </div>

        <!-- Tracks Table -->
        <div class="tracks-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2"></i>{{ __('common.tracks') }}
                </h5>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createLeagueTrackModal">
                    <i class="fas fa-plus me-2"></i>{{ __('common.add_new') }}
                </button>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table id="leagueTracksTable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                            <th><i class="fas fa-tag me-1"></i>{{ __('common.track_name') }}</th>
                            <th><i class="fas fa-calendar me-1"></i>{{ __('common.race_date') }}</th>
                            <th><i class="fas fa-flag-checkered me-1"></i>{{ __('common.sprint') }} {{ __('common.status') }}</th>
                            <th><i class="fas fa-list-alt me-1"></i>Qualifying Tipi</th>
                            <th><i class="fas fa-cog me-1"></i>{{ __('common.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($leagueTracks as $leagueTrack)
                            <tr>
                                <td>{{ $leagueTrack->id }}</td>
                                <td><strong>{{ $leagueTrack->name }}</strong></td>
                                <td>{{ tarihBicimi($leagueTrack->race_dateOrj) }}</td>
                                <td>
                                    @if($leagueTrack->sprint_status)
                                        <span class="badge-sprint">{{ __('common.yes') }}</span>
                                    @else
                                        <span class="text-muted">{{ __('common.no') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-qualifying">
                                        {{ $leagueTrack->qualifying_type == 0 ? 'Short Q' : 'Full Q' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-edit action-btn" data-bs-toggle="modal" data-bs-target="#editLeagueTrackModal" data-bs-league-track-id="{{ $leagueTrack->id }}" data-bs-track-id="{{ $leagueTrack->track_id }}" data-bs-race-date="{{ $leagueTrack->race_date }}" data-bs-race-time="{{ $leagueTrack->race_time }}" data-bs-sprint-status="{{ $leagueTrack->sprint_status }}" data-bs-qualifying-type="{{ $leagueTrack->qualifying_type }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-delete action-btn" onclick="deleteLeagueTrack({{ $leagueTrack->id }}, '{{ $leagueTrack->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createLeagueTrackModal" tabindex="-1" aria-labelledby="createLeagueTrackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLeagueTrackModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>{{ __('common.add_new_track') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createLeagueTrackForm" method="POST" action="{{ route('admin.leagues.createLeagueTrack') }}">
                    @csrf
                    <input type="hidden" name="league_id" value="{{ $leagueId ?? 0 }}">
                    <div class="mb-3">
                        <label for="track_id" class="form-label">{{ __('common.track') }}</label>
                        <select class="form-select" id="track_id" name="track_id" required>
                            <option value="">{{ __('common.select_status') }}</option>
                            @foreach ($allTracks as $track)
                                <option value="{{ $track->id }}" data-name="{{ $track->name }}">{{ $track->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="race_date" class="form-label">{{ __('common.race_date') }}</label>
                        <input type="date" class="form-control" id="race_date" name="race_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="race_time" class="form-label">{{ __('common.race_time') }}</label>
                        <input type="time" class="form-control" id="race_time" name="race_time" required value="21:30">
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sprint_status" name="sprint_status" value="1">
                            <label class="form-check-label" for="sprint_status">{{ __('common.sprint') }} {{ __('common.status') }}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="qualifying_type" class="form-label">Qualifying Tipi</label>
                        <select class="form-select" id="qualifying_type" name="qualifying_type" required>
                            <option value="0">Short Q</option>
                            <option value="1">Full Q</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="createLeagueTrack()">
                    <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editLeagueTrackModal" tabindex="-1" aria-labelledby="editLeagueTrackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLeagueTrackModalLabel">
                    <i class="fas fa-edit me-2"></i>{{ __('common.edit_track') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editLeagueTrackForm" method="POST" action="{{ route('admin.leagues.editLeagueTrack') }}">
                    @csrf
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="track_id_edit" class="form-label">{{ __('common.track') }}</label>
                        <select class="form-select" id="track_id_edit" name="track_id" disabled>
                            <option value="">{{ __('common.select_status') }}</option>
                            @foreach ($allTracks as $track)
                                <option value="{{ $track->id }}" data-name="{{ $track->name }}">{{ $track->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="race_date_edit" class="form-label">{{ __('common.race_date') }}</label>
                        <input type="date" class="form-control" id="race_date_edit" name="race_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="race_time_edit" class="form-label">{{ __('common.race_time') }}</label>
                        <input type="time" class="form-control" id="race_time_edit" name="race_time" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sprint_status_edit" name="sprint_status" value="1" disabled>
                            <label class="form-check-label" for="sprint_status_edit">{{ __('common.sprint') }} {{ __('common.status') }}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="qualifying_type_edit" class="form-label">Qualifying Tipi</label>
                        <select class="form-select" id="qualifying_type_edit" name="qualifying_type" required>
                            <option value="0">Short Q</option>
                            <option value="1">Full Q</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                <button type="button" class="btn btn-primary" onclick="editLeagueTrack()">
                    <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#leagueTracksTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                language: {
                    search: "{{ __('common.datatable_search') }}",
                    lengthMenu: "{{ __('common.datatable_length_menu') }}",
                    info: "{{ __('common.datatable_info') }}",
                    paginate: {
                        next: "{{ __('common.datatable_next') }}",
                        previous: "{{ __('common.datatable_previous') }}"
                    }
                }
            });
        });

        $('#editLeagueTrackModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var leagueTrackId = button.data('bs-league-track-id');
            var trackId = button.data('bs-track-id');
            var raceDate = button.data('bs-race-date');
            var raceTime = button.data('bs-race-time');
            var sprintStatus = button.data('bs-sprint-status');
            var qualifyingType = button.data('bs-qualifying-type');
            $('#editId').val(leagueTrackId);
            $('#track_id_edit').val(trackId).trigger('change');
            $('#race_date_edit').val(raceDate);
            $('#race_time_edit').val(raceTime);
            $('#sprint_status_edit').prop('checked', sprintStatus == 1).trigger('change');
            $('#qualifying_type_edit').val(qualifyingType).trigger('change');
        });

        function editLeagueTrack() {
            $.ajax({
                url: '{{ route('admin.leagues.editLeagueTrack') }}',
                type: 'POST',
                data: $('#editLeagueTrackForm').serialize(),
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            icon: 'success'
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
                        title: 'Hata',
                        text: '{{ __('common.error_occurred') }}',
                        icon: 'error'
                    });
                }
            });
        }

        function createLeagueTrack() {
            $.ajax({
                url: '{{ route('admin.leagues.createLeagueTrack') }}',
                type: 'POST',
                data: $('#createLeagueTrackForm').serialize(),
                success: function(response) {
                    if (response.hata == 0) {
                        Swal.fire({
                            title: '{{ __('common.success') }}',
                            text: response.aciklama,
                            icon: 'success'
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
                        title: 'Hata',
                        text: '{{ __('common.error_occurred') }}',
                        icon: 'error'
                    });
                }
            });
        }

        function deleteLeagueTrack(id, name) {
            Swal.fire({
                title: '{{ __('common.are_you_sure') }}',
                text: name + ' {{ __('common.delete_track_confirm') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('common.yes_delete') }}',
                cancelButtonText: '{{ __('common.cancel') }}',
                confirmButtonColor: '#ef4444'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.leagues.deleteLeagueTrack') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: function(response) {
                            if (response.hata == 0) {
                                Swal.fire({
                                    title: '{{ __('common.success') }}',
                                    text: response.aciklama,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Hata',
                                    text: response.aciklama,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Hata',
                                text: '{{ __('common.error_occurred') }}',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
