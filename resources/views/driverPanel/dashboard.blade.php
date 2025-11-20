@extends('driverPanel.layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .driver-dashboard-page {
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
    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .stat-card.blue { border-left-color: #3b82f6; }
    .stat-card.green { border-left-color: #10b981; }
    .stat-card.orange { border-left-color: #f59e0b; }
    .stat-card.purple { border-left-color: #8b5cf6; }
    .stat-card.yellow { border-left-color: #fbbf24; }
    .stat-card.indigo { border-left-color: #6366f1; }
    .stat-card.rose { border-left-color: #f43f5e; }
    .stat-card.teal { border-left-color: #14b8a6; }
    .stat-card.cyan { border-left-color: #06b6d4; }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: white;
    }
    .stat-icon.blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .stat-icon.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-icon.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
    .stat-icon.yellow { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); }
    .stat-icon.indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    .stat-icon.rose { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }
    .stat-icon.teal { background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); }
    .stat-icon.cyan { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
    }
    .stat-card-footer {
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid #e5e7eb;
        font-size: 0.75rem;
        color: #6b7280;
        line-height: 1.6;
        text-align: center;
        font-style: italic;
    }
    .info-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        height: 100%;
    }
    .info-card-header {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .info-item {
        padding: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    .info-item:hover {
        background: #f8f9fa;
    }
    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .info-label {
        color: #374151;
        font-weight: 500;
    }
    .info-value {
        font-weight: 700;
        font-size: 1.125rem;
    }
    .info-value.best {
        color: #10b981;
    }
    .info-value.worst {
        color: #ef4444;
    }
    .info-value.avg {
        color: #3b82f6;
    }
    .table-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.5rem;
        color: white;
    }
    .table-card .table {
        margin-bottom: 0;
    }
    .table-card .table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: #fff;
        text-align: center;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.75rem 0.5rem;
        border: none;
    }
    .table-card .table tbody td {
        vertical-align: middle;
        text-align: center;
        font-size: 0.875rem;
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .table-card .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }
    .badge-modern {
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-block;
    }
    .badge-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    .badge-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    .badge-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #000;
    }
    .badge-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
    }
    .badge-indigo {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
    }
    .badge-rose {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
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
    .text-green-600 {
        color: #16a34a;
    }
    .text-rose-600 {
        color: #e11d48;
    }
    .text-xl {
        font-size: 1.25rem;
    }
    .text-muted {
        color: #6b7280;
    }
</style>

<div class="driver-dashboard-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.view_your_statistics') }}
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card blue">
                    <div class="stat-icon blue">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div class="stat-value">{{ $totalRaces }}</div>
                    <div class="stat-label">{{ __('common.total_races') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.total_races_completed') }}
                        {{ __('common.only_finished_races_counted') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card green">
                    <div class="stat-icon green">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-value">{{ number_format($totalPoints, 0) }}</div>
                    <div class="stat-label">{{ __('common.most_points') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.total_points_earned') }}
                        {{ __('common.sprint_and_main_points_included') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card orange">
                    <div class="stat-icon orange">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="stat-value">{{ $wins }}</div>
                    <div class="stat-label">{{ __('common.most_wins_title') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.first_place_finishes') }}
                        {{ __('common.most_prestigious_achievement') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card purple">
                    <div class="stat-icon purple">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="stat-value">{{ $podiums }}</div>
                    <div class="stat-label">{{ __('common.most_podiums') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.top3_finishes') }}
                        {{ __('common.podium_achievements') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card yellow">
                    <div class="stat-icon yellow">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-value">{{ $championships }}</div>
                    <div class="stat-label">{{ __('common.championships') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.championships_won') }}
                        {{ __('common.highest_points_finished_leagues') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card indigo">
                    <div class="stat-icon indigo">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div class="stat-value">{{ $polePositions }}</div>
                    <div class="stat-label">{{ __('common.pole_positions') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.first_place_starts') }}
                        {{ __('common.best_position_start') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card rose">
                    <div class="stat-icon rose">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <div class="stat-value">{{ $fastestLaps }}</div>
                    <div class="stat-label">{{ __('common.fastest_lap') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.fastest_lap_count') }}
                        {{ __('common.speed_skill_indicator') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card teal">
                    <div class="stat-icon teal">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value">{{ $avgRacePosition ?? '-' }}</div>
                    <div class="stat-label">{{ __('common.avg_race_position') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.average_finish_position') }}
                        {{ __('common.lower_value_better') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card cyan">
                    <div class="stat-icon cyan">
                        <i class="fas fa-sort-numeric-up"></i>
                    </div>
                    <div class="stat-value">{{ $avgQualifyingPosition ?? '-' }}</div>
                    <div class="stat-label">{{ __('common.avg_qualifying_position') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.avg_qualifying_position_desc') }}
                        {{ __('common.qualifying_performance_reflects') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card blue">
                    <div class="stat-icon blue">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-value">{{ $top5Finishes }}</div>
                    <div class="stat-label">{{ __('common.top5_finishes') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.top5_finishes_desc') }}
                        {{ __('common.top_level_performance') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card green">
                    <div class="stat-icon green">
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="stat-value">{{ $top10Finishes }}</div>
                    <div class="stat-label">{{ __('common.top10_finishes') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.top10_finishes_desc') }}
                        {{ __('common.good_performance_consistency') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card orange">
                    <div class="stat-icon orange">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="stat-value">{{ $positionsGained }}</div>
                    <div class="stat-label">{{ __('common.total_positions_gained') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.total_positions_gained_desc') }}
                        {{ __('common.race_performance_shows') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card rose">
                    <div class="stat-icon rose">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="stat-value">{{ $positionsLost }}</div>
                    <div class="stat-label">{{ __('common.total_positions_lost') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.total_positions_lost_desc') }}
                        {{ __('common.positions_lost_during_race') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card purple">
                    <div class="stat-icon purple">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-value">{{ $dnfCount }}</div>
                    <div class="stat-label">{{ __('common.dnf_count') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.dnf_count_desc') }}
                        {{ __('common.did_not_finish_count') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card yellow">
                    <div class="stat-icon yellow">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="stat-value">{{ $consistency ?? '-' }}</div>
                    <div class="stat-label">{{ __('common.consistency_std_dev') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.consistency_measure') }}
                        {{ __('common.low_value_more_consistent') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card cyan">
                    <div class="stat-icon cyan">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="stat-value">{{ $avgPointsPerRace }}</div>
                    <div class="stat-label">{{ __('common.avg_points_per_race') }}</div>
                    <div class="stat-card-footer">
                        {{ __('common.avg_points_per_race_desc') }}
                        {{ __('common.points_efficiency_shows') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking Details -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-trophy"></i>
                        {{ __('common.race_ranking') }}
                    </div>
                    <div class="info-item">
                        <span class="info-label">{{ __('common.best_ranking') }}</span>
                        <span class="info-value best">{{ $bestRacePosition ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">{{ __('common.worst_ranking') }}</span>
                        <span class="info-value worst">{{ $worstRacePosition ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">{{ __('common.average_ranking') }}</span>
                        <span class="info-value avg">{{ $avgRacePosition ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-timer"></i>
                        {{ __('common.qualifying_ranking') }}
                    </div>
                    <div class="info-item">
                        <span class="info-label">{{ __('common.best_ranking') }}</span>
                        <span class="info-value best">{{ $bestQualifyingPosition ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">{{ __('common.worst_ranking') }}</span>
                        <span class="info-value worst">{{ $worstQualifyingPosition ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">{{ __('common.average_ranking') }}</span>
                        <span class="info-value avg">{{ $avgQualifyingPosition ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- League Statistics -->
        @if(count($leagueStats) > 0)
        <div class="table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list-ul me-2"></i>{{ __('common.league_based_statistics') }}
                </h5>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><i class="fas fa-trophy me-1"></i>{{ __('common.league') }}</th>
                                <th><i class="fas fa-flag-checkered me-1"></i>{{ __('common.race') }}</th>
                                <th><i class="fas fa-star me-1"></i>{{ __('common.points') }}</th>
                                <th><i class="fas fa-medal me-1"></i>{{ __('common.most_wins_title') }}</th>
                                <th><i class="fas fa-award me-1"></i>{{ __('common.most_podiums') }}</th>
                                <th><i class="fas fa-flag me-1"></i>{{ __('common.pole_positions') }}</th>
                                <th><i class="fas fa-tachometer-alt me-1"></i>{{ __('common.fastest_lap') }}</th>
                                <th><i class="fas fa-chart-line me-1"></i>{{ __('common.avg_position') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leagueStats as $league)
                            <tr>
                                <td class="text-start"><strong>{{ $league['league_name'] }}</strong></td>
                                <td>{{ $league['total_races'] }}</td>
                                <td>
                                    <span class="badge-modern badge-green">{{ number_format($league['total_points'], 0) }}</span>
                                </td>
                                <td>
                                    <span class="badge-modern badge-orange">{{ $league['wins'] }}</span>
                                </td>
                                <td>
                                    <span class="badge-modern badge-purple">{{ $league['podiums'] }}</span>
                                </td>
                                <td>
                                    <span class="badge-modern badge-indigo">{{ $league['pole_positions'] }}</span>
                                </td>
                                <td>
                                    <span class="badge-modern badge-rose">{{ $league['fastest_laps'] }}</span>
                                </td>
                                <td>
                                    <span class="badge-modern badge-blue">{{ $league['avg_position'] ?? '-' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Races -->
        @if($recentRaces->count() > 0)
        <div class="table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-history me-2"></i>{{ __('common.last_10_races') }}
                </h5>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar me-1"></i>{{ __('common.race_date') }}</th>
                                <th><i class="fas fa-trophy me-1"></i>{{ __('common.league') }}</th>
                                <th><i class="fas fa-road me-1"></i>{{ __('common.track') }}</th>
                                <th><i class="fas fa-sort-numeric-up me-1"></i>Q</th>
                                <th><i class="fas fa-sort-numeric-up me-1"></i>R</th>
                                <th><i class="fas fa-star me-1"></i>{{ __('common.points') }}</th>
                                <th><i class="fas fa-flag-checkered me-1"></i>{{ __('common.sprint') }}</th>
                                <th><i class="fas fa-flag me-1"></i>{{ __('common.pole_positions') }}</th>
                                <th><i class="fas fa-tachometer-alt me-1"></i>{{ __('common.fastest_lap') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRaces as $race)
                            <tr>
                                <td>{{ tarihBicimi($race->race_date, 4) }}</td>
                                <td class="text-start"><strong>{{ $race->league_name }}</strong></td>
                                <td class="text-start">{{ $race->track_name }}</td>
                                <td>
                                    @if($race->q_ranking > 0)
                                        <span class="badge-modern badge-indigo">{{ $race->q_ranking }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($race->r_ranking > 0)
                                        @if($race->r_ranking == 1)
                                            <span class="badge-modern badge-orange">1</span>
                                        @elseif($race->r_ranking <= 3)
                                            <span class="badge-modern badge-purple">{{ $race->r_ranking }}</span>
                                        @else
                                            <span class="badge-modern badge-blue">{{ $race->r_ranking }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-modern badge-green">{{ (int)($race->points ?? 0) + (int)($race->s_point ?? 0) }}</span>
                                </td>
                                <td>
                                    @if($race->sprint_status)
                                        <span class="badge-modern badge-orange">{{ __('common.yes') }}</span>
                                    @else
                                        <span class="text-muted">{{ __('common.no') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($race->q_ranking == 1)
                                        <i class="fas fa-check text-green-600 text-xl"></i>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($race->fastest_lap)
                                        <i class="fas fa-check text-rose-600 text-xl"></i>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="table-card">
            <div class="p-4">
                <div class="empty-state">
                    <i class="fas fa-flag-checkered"></i>
                    <h5>{{ __('common.no_race_result_yet') }}</h5>
                    <p class="text-muted">{{ __('common.race_results_will_appear') }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
