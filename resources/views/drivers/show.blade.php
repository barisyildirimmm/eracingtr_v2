@extends('layouts.layout')

@section('content')

    <style>
        .driver-detail-page {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .driver-header-card {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(220, 53, 69, 0.4);
            color: white;
        }

        .driver-photo-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        .stat-card-detail {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .stat-card-detail:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #24d9b0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        .race-table {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .race-table thead {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        }

        .race-table thead th {
            color: #fff;
            font-weight: 700;
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            vertical-align: middle;
            text-align: center;
        }

        .race-table thead th:first-child,
        .race-table thead th:nth-child(2),
        .race-table thead th:nth-child(3) {
            text-align: left;
        }

        .race-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.3s ease;
        }

        .race-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .race-table tbody td {
            padding: 1rem;
            color: #e0e0e0;
            vertical-align: middle;
            height: 60px;
        }

        .race-table tbody td:first-child,
        .race-table tbody td:nth-child(2),
        .race-table tbody td:nth-child(3) {
            text-align: left;
        }

        .race-table tbody td:nth-child(4),
        .race-table tbody td:nth-child(5),
        .race-table tbody td:nth-child(6) {
            text-align: center;
        }

        .race-table tbody td:nth-child(4),
        .race-table tbody td:nth-child(5) {
            min-height: 60px;
        }

        .position-badge {
            display: inline-block;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            font-weight: 800;
            font-size: 1rem;
            line-height: 2.5rem;
            text-align: center;
            vertical-align: middle;
        }

        .position-1 { background: linear-gradient(135deg, #FFD700, #FFA500); color: #000; }
        .position-2 { background: linear-gradient(135deg, #C0C0C0, #A8A8A8); color: #000; }
        .position-3 { background: linear-gradient(135deg, #CD7F32, #B87333); color: #fff; }
        .position-other { background: rgba(255, 255, 255, 0.1); color: #fff; }
    </style>

    <!-- Page Heading -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">{{ __('common.driver_profile') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="site-content py-5 driver-detail-page">
        <div class="container">
            
            <!-- Driver Header -->
            <div class="driver-header-card">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        <img src="{{ asset('assets/img/drivers/' . $driver->id . '.png') }}" 
                             alt="{{ $driver->name }} {{ $driver->surname }}"
                             class="driver-photo-large"
                             onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                    </div>
                    <div class="col-md-9">
                        <h2 class="mb-2" style="font-size: 2.5rem; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                            {{ $driver->name }} {{ $driver->surname }}
                        </h2>
                        @if($driver->team_name)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                @if($driver->team_id)
                                    <img src="{{ asset('assets/img/team_logo2/' . $driver->team_id . '.png') }}" 
                                         alt="{{ $driver->team_name }}"
                                         style="width: 50px; height: 50px; object-fit: contain; background: rgba(255,255,255,0.1); padding: 4px; border-radius: 8px;"
                                         onerror="this.style.display='none'">
                                @endif
                                <div>
                                    <span style="font-size: 1.25rem; font-weight: 600;">{{ $driver->team_name }}</span>
                                    @if($driver->team_short_name)
                                        <span style="font-size: 0.9rem; opacity: 0.8;">({{ $driver->team_short_name }})</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if($driver->country)
                            <div class="mb-2">
                                <i class="fas fa-flag mr-2"></i>
                                <span>{{ $driver->country }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ $stats['total_races'] }}</div>
                        <div class="stat-label">{{ __('common.total_races') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ $stats['total_points'] }}</div>
                        <div class="stat-label">{{ __('common.total_points') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ $stats['wins'] }}</div>
                        <div class="stat-label">{{ __('common.wins') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ $stats['podiums'] }}</div>
                        <div class="stat-label">{{ __('common.podiums') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ $stats['pole_positions'] }}</div>
                        <div class="stat-label">{{ __('common.pole_positions') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ $stats['fastest_laps'] }}</div>
                        <div class="stat-label">{{ __('common.fastest_laps') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ $stats['best_position'] }}</div>
                        <div class="stat-label">{{ __('common.best_position') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card-detail text-center">
                        <div class="stat-value">{{ number_format($stats['avg_position'], 1) }}</div>
                        <div class="stat-label">{{ __('common.avg_position') }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Races -->
            <div class="card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4); overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.1);">
                <div class="card-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 1.5rem 2rem; border: none;">
                    <h4 style="margin: 0; color: #fff; font-weight: 700; font-size: 1.5rem;">
                        <i class="fas fa-flag-checkered mr-2"></i>
                        {{ __('common.recent_races') }}
                    </h4>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table race-table mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('common.race_date') }}</th>
                                    <th>{{ __('common.league') }}</th>
                                    <th>{{ __('common.track') }}</th>
                                    <th>{{ __('common.qualifying') }}</th>
                                    <th>{{ __('common.race') }}</th>
                                    <th>{{ __('common.points') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRaces as $race)
                                    @php
                                        $position = $race->r_ranking > 0 ? $race->r_ranking : null;
                                        $positionClass = '';
                                        if ($position == 1) $positionClass = 'position-1';
                                        elseif ($position == 2) $positionClass = 'position-2';
                                        elseif ($position == 3) $positionClass = 'position-3';
                                        else $positionClass = 'position-other';
                                    @endphp
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($race->race_date)->format('d.m.Y') }}</td>
                                        <td>
                                            <a href="{{ route('f1Leagues.pointTable', $race->league_link) }}" style="color: #24d9b0; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#1fb896';" onmouseout="this.style.color='#24d9b0';">
                                                {{ $race->league_name }}
                                            </a>
                                        </td>
                                        <td>{{ $race->track_name }}</td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            @if($race->q_ranking > 0)
                                                <span class="position-badge position-other">{{ $race->q_ranking }}</span>
                                            @else
                                                <span class="position-badge position-other" style="background: transparent; color: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.1);">-</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            @if($position)
                                                <span class="position-badge {{ $positionClass }}">{{ $position }}</span>
                                            @else
                                                <span class="position-badge position-other" style="background: transparent; color: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.1);">-</span>
                                            @endif
                                        </td>
                                        <td style="font-weight: 700; color: #24d9b0;">
                                            {{ (int)($race->points ?? 0) + (int)($race->s_point ?? 0) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center" style="padding: 2rem; color: rgba(255,255,255,0.5);">
                                            {{ __('common.no_race_results') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

