@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .page-header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .btn-view {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }
        .penalty-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-top: 2rem;
        }
        .penalty-table-header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            padding: 1.5rem;
            color: white;
        }
        .penalty-table-header h5 {
            margin: 0;
            font-weight: 700;
        }
        .penalty-table-card .table {
            margin-bottom: 0;
        }
        .penalty-table-card .table thead th {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: #fff;
            text-align: center;
            font-weight: 600;
            padding: 1rem;
            border: none;
        }
        .penalty-table-card .table tbody td {
            vertical-align: middle;
            padding: 1rem;
        }
        .penalty-table-card .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: all 0.2s ease;
        }
        .penalty-badge {
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
            font-weight: 700;
        }
        .penalty-details {
            font-size: 0.75rem;
            line-height: 1.4;
            color: #6b7280;
            padding: 0.25rem 0;
        }
        .penalty-detail-item {
            padding: 0.15rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .penalty-detail-item:last-child {
            border-bottom: none;
        }
        .penalty-detail-track {
            font-weight: 600;
            color: #374151;
        }
        .penalty-detail-complainant {
            color: #6b7280;
            font-size: 0.7rem;
        }
        .penalty-detail-point {
            color: #ef4444;
            font-weight: 700;
        }
    </style>
@endsection
@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="col-span-12">
            <!-- Page Header -->
            <div class="page-header-card">
                <h2 class="mb-2 fw-bold">
                    <i class="fas fa-gavel me-2"></i>{{ __('common.referee_decisions_title') }}
                </h2>
                <p class="mb-0 opacity-90">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('common.view_and_manage_complaints_defenses_appeals') }}
                </p>
            </div>

            <div class="box">
                <div class="box-body">
                    <div class="row">
                        @foreach ($leagueTracks as $track)
                            <div class="col-md-12 mb-3">
                                <div class="card shadow-sm" style="border: 1px solid #dee2e6; border-radius: 0.75rem; overflow: hidden;">
                                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-1 fw-bold">
                                                    <i class="fas fa-flag-checkered me-2"></i>{{ $track->track_name }}
                                                </h5>
                                                <small class="opacity-75">
                                                    <i class="fas fa-calendar me-1"></i>{{ $track->race_date_formatted }}
                                                    @if($track->sprint_status)
                                                        <span class="badge bg-warning text-dark ms-2">Sprint</span>
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="me-4">
                                                    <span class="badge bg-danger bg-opacity-75 me-2" style="font-size: 0.9rem;">
                                                        <i class="fas fa-exclamation-triangle"></i> {{ __('common.complaint_count') }}: {{ $track->complaint_count }}
                                                    </span>
                                                    <span class="badge bg-info bg-opacity-75 me-2" style="font-size: 0.9rem;">
                                                        <i class="fas fa-shield-alt"></i> {{ __('common.defense_count') }}: {{ $track->defense_count }}
                                                    </span>
                                                    <span class="badge bg-warning bg-opacity-75" style="font-size: 0.9rem;">
                                                        <i class="fas fa-gavel"></i> {{ __('common.appeal_count') }}: {{ $track->appeal_count }}
                                                    </span>
                                                </div>
                                                <a href="{{ route('admin.leagues.refDecisions.track', ['league_id' => $leagueId, 'track_id' => $track->league_track_id]) }}" class="btn-view">
                                                    <i class="fas fa-eye"></i>{{ __('common.show_complaints') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if(count($leagueTracks) == 0)
                            <div class="col-md-12">
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-flag-checkered fa-4x mb-3"></i>
                                    <p class="h5">{{ __('common.no_race_yet') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pilot Bazlı Toplam Ceza Puanları -->
            @if(count($driverPenaltyPoints) > 0)
            <div class="penalty-table-card">
                <div class="penalty-table-header">
                    <h5>
                        <i class="fas fa-chart-bar me-2"></i>{{ __('common.driver_based_total_penalty_points') }}
                    </h5>
                </div>
                <div class="p-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 60px;" class="text-center">#</th>
                                    <th style="width: 200px;"><i class="fas fa-user me-1"></i>{{ __('common.pilot') }}</th>
                                    <th class="text-center" style="width: 150px;"><i class="fas fa-exclamation-triangle me-1"></i>{{ __('common.total_penalty_points') }}</th>
                                    <th class="text-center" style="width: 150px;"><i class="fas fa-gavel me-1"></i>{{ __('common.total_decision_count') }}</th>
                                    <th><i class="fas fa-list me-1"></i>{{ __('common.details') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($driverPenaltyPoints as $index => $driver)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-primary" style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <strong style="font-size: 1rem;">{{ trim(($driver->name ?? '') . ' ' . ($driver->surname ?? '')) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger penalty-badge">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ number_format($driver->total_penalty_points, 0) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info" style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                                            <i class="fas fa-gavel me-1"></i>{{ $driver->total_decisions }}
                                        </span>
                                    </td>
                                    <td class="penalty-details">
                                        @if(isset($driver->penalty_details) && count($driver->penalty_details) > 0)
                                            @foreach($driver->penalty_details as $detail)
                                                <div class="penalty-detail-item">
                                                    <span class="penalty-detail-track">{{ $detail->track_name }}</span>
                                                    <span class="text-muted" style="font-size: 0.65rem;"> ({{ date('d.m.Y', strtotime($detail->race_date)) }})</span>
                                                    <span class="penalty-detail-complainant"> - {{ $detail->complainant_name }}</span>
                                                    <span class="penalty-detail-point"> -{{ $detail->penalty_point }}p</span>
                                                    @if($detail->penalty)
                                                        <span class="text-muted" style="font-size: 0.65rem;"> ({{ $detail->penalty }})</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted" style="font-size: 0.7rem;">{{ __('common.detail_not_found') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
@endsection
