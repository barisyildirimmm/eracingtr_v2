@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .leagues-page {
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
        .leagues-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            color: white;
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }
        .status-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .status-inactive {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .action-btn {
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-weight: 600;
            font-size: 0.75rem;
            transition: all 0.3s ease;
            border: none;
            margin: 0 0.25rem;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            color: white;
        }
        #basic-table_wrapper {
            padding: 1rem;
        }
        #basic-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        #basic-table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #495057;
            font-weight: 600;
            padding: 0.75rem 0.5rem;
            border-bottom: 2px solid #dee2e6;
            font-size: 0.875rem;
        }
        #basic-table tbody td {
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.875rem;
            vertical-align: middle;
        }
        #basic-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .action-link {
            width: 36px;
            height: 36px;
            border-radius: 0.375rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }
        .action-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .action-link.primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
        }
        .action-link.secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5c636a 100%);
            color: white;
        }
        .action-link.danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        .action-link.info {
            background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
            color: white;
        }
        .action-link.success {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            color: white;
        }
        .action-link.warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            color: white;
        }
        .rank-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }
        .point-rate-badge {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
        }
        /* Custom Tooltip Styles */
        .tooltip {
            font-size: 0.875rem;
        }
        .tooltip-inner {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            max-width: 200px;
        }
        .tooltip-arrow::before {
            border-top-color: #1f2937 !important;
        }
        /* Edit Modal Enhancements */
        .modal-content {
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .form-control:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
        }
        .form-label {
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            padding: 0.625rem 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:hover {
            border-color: #adb5bd;
        }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5) !important;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }
    </style>
@endsection
@section('content')
<div class="leagues-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-trophy me-2"></i>{{ __('common.league_list') }}
                    </h2>
                    <p class="mb-0 opacity-90">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('common.league_list_desc') }}
                    </p>
                </div>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createLeagueModal">
                    <i class="fas fa-plus me-2"></i>{{ __('common.add_new_league') }}
                </button>
            </div>
        </div>

        <!-- Leagues Table Card -->
        <div class="leagues-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-table me-2"></i>{{ __('common.leagues_table') }}
                </h5>
            </div>
            <div class="overflow-auto">
                <table id="basic-table" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('common.league_name') }}</th>
                            <th>{{ __('common.rank') }}</th>
                            <th>{{ __('common.point_rate') }}</th>
                            <th>{{ __('common.status') }}</th>
                            <th style="text-align: center">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leagues as $league)
                            <tr>
                                <td><strong>#{{ $league->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="width: 32px; height: 32px; border-radius: 0.375rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.75rem;">
                                            <i class="fas fa-trophy"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $league->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-link me-1"></i>{{ $league->link }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="rank-badge">
                                        <i class="fas fa-star me-1"></i>{{ $league->rank }}
                                    </span>
                                </td>
                                <td>
                                    <span class="point-rate-badge">
                                        <i class="fas fa-chart-line me-1"></i>{{ $league->point_rate }}
                                    </span>
                                </td>
                                <td>
                                    @if($league->status)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle me-1"></i>{{ __('common.active') }}
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle me-1"></i>{{ __('common.inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.leagues.raceResults', ['league_id' => $league->id, 'track_id' => $league->last_track_id]) }}" 
                                           class="action-link primary" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           data-bs-title="{{ __('common.results') }}">
                                            <i class="fas fa-list-ol"></i>
                                        </a>
                                        <a href="{{ route('admin.leagues.leaguesTracks', ['league_id' => $league->id]) }}" 
                                           class="action-link secondary" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           data-bs-title="{{ __('common.tracks') }}">
                                            <i class="fas fa-road"></i>
                                        </a>
                                        <a href="{{ route('admin.leagues.leagueDrivers', ['league_id' => $league->id]) }}" 
                                           class="action-link danger" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           data-bs-title="{{ __('common.drivers') }}">
                                            <i class="fas fa-users"></i>
                                        </a>
                                        <a href="{{ route('admin.leagues.raceVideos', ['league_id' => $league->id]) }}" 
                                           class="action-link info" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           data-bs-title="{{ __('common.race_videos') }}">
                                            <i class="fas fa-video"></i>
                                        </a>
                                        <a href="{{ route('admin.leagues.refDecisions', ['league_id' => $league->id]) }}" 
                                           class="action-link success" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           data-bs-title="{{ __('common.referee_decisions') }}">
                                            <i class="fas fa-balance-scale"></i>
                                        </a>
                                        <a href="{{ route('admin.leagues.tryouts', ['league_id' => $league->id]) }}" 
                                           class="action-link" 
                                           style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white;" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top" 
                                           data-bs-title="Seçmeler">
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                        <a href="" 
                                           class="action-link warning" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#editLeagueModal" 
                                           data-bs-tooltip-title="{{ __('common.edit') }}"
                                           onclick="editLeague({{ $league->id }}, '{{ $league->name }}', '{{ $league->status }}', '{{ $league->link }}', '{{ $league->rank }}', '{{ $league->point_rate }}', '{{ $league->reserve_driver_point }}', '{{ $league->reserve_driver_team_point }}', '{{ $league->tryouts_visibility ?? 0 }}', '{{ $league->tryouts_track_id ?? '' }}')">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createLeagueModal" tabindex="-1" aria-labelledby="createLeagueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold" id="createLeagueModalLabel">
                    <i class="fas fa-trophy me-2"></i>{{ __('common.add_new_league') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createLeagueForm" method="POST" action="{{ route('admin.leagues.create') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">{{ __('common.league_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="{{ __('common.league_name_placeholder') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link" class="form-label fw-semibold">{{ __('common.link') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="link" name="link" required placeholder="{{ __('common.link_placeholder') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="rank" class="form-label fw-semibold">{{ __('common.rank') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="rank" name="rank" required placeholder="{{ __('common.rank_placeholder') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="point_rate" class="form-label fw-semibold">{{ __('common.point_rate') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="point_rate" name="point_rate" required placeholder="{{ __('common.point_rate_placeholder') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label fw-semibold">{{ __('common.status') }} <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">{{ __('common.active') }}</option>
                                <option value="0">{{ __('common.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="reserve_driver_point" class="form-label fw-semibold">{{ __('common.reserve_driver_point') }} <span class="text-danger">*</span></label>
                            <select class="form-control" id="reserve_driver_point" name="reserve_driver_point" required>
                                <option value="1">{{ __('common.has') }}</option>
                                <option value="0">{{ __('common.has_not') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="reserve_driver_team_point" class="form-label fw-semibold">{{ __('common.reserve_driver_team_point') }} <span class="text-danger">*</span></label>
                            <select class="form-control" id="reserve_driver_team_point" name="reserve_driver_team_point" required>
                                <option value="1">{{ __('common.has') }}</option>
                                <option value="0">{{ __('common.has_not') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-save me-2"></i>{{ __('common.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editLeagueModal" tabindex="-1" aria-labelledby="editLeagueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 1rem; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 1rem 1rem 0 0;">
                <h5 class="modal-title fw-bold" id="editLeagueModalLabel">
                    <i class="fas fa-edit me-2"></i>{{ __('common.edit_league') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editLeagueForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editLeagueId" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editName" class="form-label fw-semibold">
                                <i class="fas fa-trophy me-2"></i>{{ __('common.league_name') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editName" name="name" required placeholder="Lig adını girin">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editLink" class="form-label fw-semibold">
                                <i class="fas fa-link me-2"></i>{{ __('common.link') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="editLink" name="link" required placeholder="Lig linkini girin">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="editRank" class="form-label fw-semibold">
                                <i class="fas fa-star me-2"></i>{{ __('common.rank') }} <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="editRank" name="rank" required placeholder="Sıra">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="editPointRate" class="form-label fw-semibold">
                                <i class="fas fa-chart-line me-2"></i>{{ __('common.point_rate') }} <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="editPointRate" name="point_rate" required placeholder="Puan oranı">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="editStatus" class="form-label fw-semibold">
                                <i class="fas fa-toggle-on me-2"></i>{{ __('common.status') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="1">{{ __('common.active') }}</option>
                                <option value="0">{{ __('common.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editReserveDriverPoint" class="form-label fw-semibold">
                                <i class="fas fa-user-clock me-2"></i>{{ __('common.reserve_driver_point') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="editReserveDriverPoint" name="reserve_driver_point" required>
                                <option value="1">{{ __('common.has') }}</option>
                                <option value="0">{{ __('common.has_not') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editReserveDriverTeamPoint" class="form-label fw-semibold">
                                <i class="fas fa-users-cog me-2"></i>{{ __('common.reserve_driver_team_point') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="editReserveDriverTeamPoint" name="reserve_driver_team_point" required>
                                <option value="1">{{ __('common.has') }}</option>
                                <option value="0">{{ __('common.has_not') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 2px solid #dee2e6; border-radius: 0.75rem;">
                                <div class="card-body p-3">
                                    <h6 class="card-title fw-bold mb-3" style="color: #495057;">
                                        <i class="fas fa-clipboard-check me-2" style="color: #8b5cf6;"></i>Seçmeler Ayarları
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="editTryoutsVisibility" class="form-label fw-semibold">
                                                <i class="fas fa-eye me-2"></i>Seçmeler Görünürlüğü
                                            </label>
                                            <select class="form-control" id="editTryoutsVisibility" name="tryouts_visibility">
                                                <option value="1">Açık</option>
                                                <option value="0">Kapalı</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Seçmelerin görünür olup olmayacağını belirler
                                            </small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="editTryoutsTrackId" class="form-label fw-semibold">
                                                <i class="fas fa-road me-2"></i>Seçmeler Pist
                                            </label>
                                            <select class="form-control" id="editTryoutsTrackId" name="tryouts_track_id">
                                                <option value="">Pist Seçiniz</option>
                                                @foreach($tracks as $track)
                                                    <option value="{{ $track->id }}">{{ $track->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Seçmeler için kullanılacak pisti seçin
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>{{ __('common.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-warning" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);">
                            <i class="fas fa-save me-2"></i>{{ __('common.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#basic-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                pageLength: 25,
                order: [[4, 'asc']],
                language: {
                    search: "{{ __('common.datatable_search') }}",
                    lengthMenu: "{{ __('common.datatable_length_menu') }}",
                    info: "{{ __('common.datatable_info') }}",
                    infoEmpty: "{{ __('common.datatable_info_empty') }}",
                    infoFiltered: "{{ __('common.datatable_info_filtered') }}",
                    paginate: {
                        next: "{{ __('common.datatable_next') }}",
                        previous: "{{ __('common.datatable_previous') }}"
                    },
                    zeroRecords: "{{ __('common.datatable_zero_records') }}"
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                responsive: true,
                drawCallback: function() {
                    // Initialize tooltips after table redraw
                    initializeTooltips();
                }
            });

            // Initialize Bootstrap tooltips
            function initializeTooltips() {
                // Destroy existing tooltips first to avoid duplicates
                var existingTooltips = document.querySelectorAll('[data-bs-toggle="tooltip"], [data-bs-tooltip-title]');
                existingTooltips.forEach(function(el) {
                    var existingTooltip = bootstrap.Tooltip.getInstance(el);
                    if (existingTooltip) {
                        existingTooltip.dispose();
                    }
                });

                // Initialize tooltips for buttons with data-bs-toggle="tooltip"
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl, {
                        placement: 'top',
                        trigger: 'hover',
                        animation: true
                    });
                });

                // Initialize tooltips for edit button (which has data-bs-toggle="modal" instead)
                var editButtons = document.querySelectorAll('[data-bs-tooltip-title]');
                editButtons.forEach(function(button) {
                    var title = button.getAttribute('data-bs-tooltip-title');
                    if (title) {
                        new bootstrap.Tooltip(button, {
                            title: title,
                            placement: 'top',
                            trigger: 'hover',
                            animation: true
                        });
                    }
                });
            }

            // Initialize tooltips on page load
            initializeTooltips();
        });

        $('#createLeagueForm').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __('common.please_wait') }}',
                text: '{{ __('common.saving') }}',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                success: function (response) {
                    if (response.hata == 0) {
                        $('#createLeagueForm')[0].reset();
                        $('#createLeagueModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('common.success') }}',
                            text: response.aciklama || '{{ __('common.league_created_success') }}',
                            confirmButtonText: '{{ __('common.ok') }}'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('common.error') }}',
                            text: response.aciklama || '{{ __('common.error_occurred') }}',
                            confirmButtonText: '{{ __('common.ok') }}'
                        });
                    }
                },
                error: function (xhr) {
                    var errorMsg = '{{ __('common.error_occurred') }}';
                    if (xhr.responseJSON && xhr.responseJSON.aciklama) {
                        errorMsg = xhr.responseJSON.aciklama;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('common.error') }}',
                        text: errorMsg,
                        confirmButtonText: '{{ __('common.ok') }}'
                    });
                }
            });
        });

        $('#editLeagueForm').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __('common.please_wait') }}',
                text: '{{ __('common.updating') }}',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = $(this);
            var leagueId = $('#editLeagueId').val();
            form.attr('action', '/admin/lig-duzenle/' + leagueId);
            
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                success: function (response) {
                    if (response.hata == 0) {
                        $('#editLeagueModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('common.success') }}',
                            text: response.aciklama || '{{ __('common.league_updated_success') }}',
                            confirmButtonText: '{{ __('common.ok') }}'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('common.error') }}',
                            text: response.aciklama || '{{ __('common.error_occurred') }}',
                            confirmButtonText: '{{ __('common.ok') }}'
                        });
                    }
                },
                error: function (xhr) {
                    var errorMsg = '{{ __('common.error_occurred') }}';
                    if (xhr.responseJSON && xhr.responseJSON.aciklama) {
                        errorMsg = xhr.responseJSON.aciklama;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('common.error') }}',
                        text: errorMsg,
                        confirmButtonText: '{{ __('common.ok') }}'
                    });
                }
            });
        });

        function editLeague(id, name, status, link, rank, pointRate, reserveDriverPoint, reserveDriverTeamPoint, tryoutsVisibility, tryoutsTrackId) {
            $('#editLeagueId').val(id);
            $('#editName').val(name);
            $('#editStatus').val(status);
            $('#editLink').val(link);
            $('#editRank').val(rank);
            $('#editPointRate').val(pointRate);
            $('#editReserveDriverPoint').val(reserveDriverPoint);
            $('#editReserveDriverTeamPoint').val(reserveDriverTeamPoint);
            $('#editTryoutsVisibility').val(tryoutsVisibility || 0);
            $('#editTryoutsTrackId').val(tryoutsTrackId || '');
        }
    </script>
@endsection
