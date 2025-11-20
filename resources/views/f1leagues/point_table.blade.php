@extends('layouts.layout')

@section('content')

    <style>
        /* Fix horizontal scroll - Only for this page */
        .point-table-page .site-content {
            overflow-x: hidden;
            max-width: 100%;
        }

        .point-table-page .container {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Modern Card Styling */
        .standings-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 0 2px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 100%;
        }

        .standings-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5), 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .standings-card__header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 1.5rem 2rem;
            border-bottom: 3px solid rgba(255, 255, 255, 0.1);
        }

        .standings-card__header h4 {
            margin: 0;
            color: #fff;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .standings-card__header h4 i {
            font-size: 1.75rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .standings-card__content {
            padding: 0;
            background: #1a1a1a;
            overflow-x: auto;
            overflow-y: visible;
        }

        /* Enhanced Table Styling */
        .standings-table {
            margin: 0;
            width: 100%;
            min-width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: auto;
        }

        .standings-table thead {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .standings-table thead th {
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 1.25rem 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            line-height: 1.4;
            height: auto;
            min-height: 70px;
            display: table-cell;
        }

        .standings-table thead th > div {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            min-height: 70px;
        }

        .standings-table thead th:first-child {
            border-top-left-radius: 0;
        }

        .standings-table thead th:last-child {
            border-top-right-radius: 0;
        }

        .standings-table thead th i {
            margin-right: 0.5rem;
            color: #ffd700;
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
        }

        .standings-table tbody tr {
            transition: background-color 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .standings-table tbody tr:not(.podium-row):hover {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .standings-table tbody td {
            padding: 1.25rem 1rem;
            color: #e0e0e0;
            font-size: 0.95rem;
            vertical-align: middle;
            border: none;
            white-space: nowrap;
        }

        /* Podium Styling - Fixed */
        .podium-row {
            position: relative;
        }

        .podium-row::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.1;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shimmer 3s infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .podium-row.podium-gold {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF8C00 100%) !important;
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .podium-row.podium-silver {
            background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 50%, #808080 100%) !important;
            box-shadow: 0 4px 20px rgba(192, 192, 192, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .podium-row.podium-bronze {
            background: linear-gradient(135deg, #CD7F32 0%, #B87333 50%, #A0522D 100%) !important;
            box-shadow: 0 4px 20px rgba(205, 127, 50, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .podium-row td {
            color: #fff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .podium-icon {
            display: inline-block;
            margin-right: 0.5rem;
            font-size: 1.25rem;
            vertical-align: middle;
        }

        /* Rank Badge - Fixed */
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            font-weight: 800;
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            vertical-align: middle;
        }

        .podium-row .rank-badge {
            background: rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        /* Driver/Team Name */
        .driver-name, .team-name {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }

        .driver-name i, .team-name i {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        /* Driver Photo */
        .driver-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
        }

        .podium-row .driver-photo {
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
        }

        /* Team Logo */
        .team-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            padding: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
        }

        /* Align rank, name and points */
        .standings-table tbody td:first-child {
            vertical-align: middle;
        }

        .standings-table tbody td:nth-child(2) {
            vertical-align: middle;
        }

        .standings-table tbody td:nth-child(3) {
            vertical-align: middle;
        }

        /* Points Display */
        .points-display {
            font-size: 1.25rem;
            font-weight: 800;
            color: #24d9b0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
        }

        .podium-row .points-display {
            color: #fff !important;
            font-size: 1.4rem;
        }

        /* Track Points */
        .track-points {
            font-weight: 700;
            font-size: 1rem;
            color: #e0e0e0;
        }

        .podium-row .track-points {
            color: #fff !important;
        }

        /* Fastest Lap - Purple */
        .track-points.fastest-lap {
            color: #9b59b6 !important;
            font-weight: 700;
        }

        .podium-row .track-points.fastest-lap {
            color: #d4a5ff !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .track-rank {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.5);
            margin-left: 0.25rem;
            font-weight: 500;
            vertical-align: sub;
            position: relative;
            top: 0.2em;
        }

        .podium-row .track-rank {
            color: rgba(0, 0, 0, 0.6) !important;
            font-weight: 600;
        }

        /* Rank Colors - Gold, Silver, Bronze */
        .track-rank.rank-1 {
            color: #FFD700 !important;
            font-weight: 800;
            text-shadow: 0 0 8px rgba(255, 215, 0, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3);
            filter: brightness(1.2);
        }

        .track-rank.rank-2 {
            color: #C0C0C0 !important;
            font-weight: 800;
            text-shadow: 0 0 8px rgba(192, 192, 192, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3);
            filter: brightness(1.2);
        }

        .track-rank.rank-3 {
            color: #CD7F32 !important;
            font-weight: 800;
            text-shadow: 0 0 8px rgba(205, 127, 50, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3);
            filter: brightness(1.2);
        }

        .podium-row .track-rank.rank-1 {
            color: #FFD700 !important;
            text-shadow: 0 0 10px rgba(255, 215, 0, 1), 0 2px 6px rgba(0, 0, 0, 0.5);
        }

        .podium-row .track-rank.rank-2 {
            color: #E8E8E8 !important;
            text-shadow: 0 0 10px rgba(232, 232, 232, 1), 0 2px 6px rgba(0, 0, 0, 0.5);
        }

        .podium-row .track-rank.rank-3 {
            color: #D4A574 !important;
            text-shadow: 0 0 10px rgba(212, 165, 116, 1), 0 2px 6px rgba(0, 0, 0, 0.5);
        }

        /* Sprint Badge */
        .sprint-badge {
            display: block;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #000;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            margin-top: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            height: 1.5rem;
            line-height: 1.1rem;
            box-sizing: border-box;
        }


        /* Regular Row Styling */
        .regular-row {
            background: rgba(255, 255, 255, 0.02);
        }

        .regular-row:nth-child(even) {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Team Standings Specific */
        .team-points {
            font-size: 1.15rem;
            font-weight: 700;
            color: #10b981;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Table Responsive Fix */
        .point-table-page .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .standings-card__header {
                padding: 1rem 1.5rem;
            }

            .standings-card__header h4 {
                font-size: 1.25rem;
            }

            .standings-table thead th,
            .standings-table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }

            .points-display {
                font-size: 1.1rem;
            }

            .rank-badge {
                width: 2rem;
                height: 2rem;
                font-size: 0.9rem;
            }
        }

        /* Loading Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .standings-card {
            animation: fadeIn 0.6s ease-out;
        }

        .standings-card:nth-child(2) {
            animation-delay: 0.2s;
        }
    </style>

    <!-- Page Heading -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">{{ __('common.point_table_title') }}</h1>
                </div>
            </div>
        </div>
    </div>

    @include('f1leagues.components.nav')

    <!-- Content -->
    <div class="site-content py-5 point-table-page">
        <div class="container">

            <!-- Driver Standings -->
            <div class="standings-card">
                <div class="standings-card__header">
                    <h4>
                        <i class="fas fa-trophy"></i>
                        {{ __('common.drivers_championship') }}
                    </h4>
                </div>
                <div class="standings-card__content">
                    <div class="table-responsive">
                        <table class="standings-table table text-center align-middle">
                            <thead>
                            <tr>
                                <th style="width: 60px;">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <span>#</span>
                                    </div>
                                </th>
                                <th class="text-start">
                                    <div style="display: flex; flex-direction: column; align-items: flex-start; justify-content: center;">
                                        <span>{{ __('common.driver') }}</span>
                                    </div>
                                </th>
                                <th>
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <span><i class="fas fa-trophy"></i> {{ __('common.total') }}</span>
                                    </div>
                                </th>
                                @foreach ($tracks as $trackD)
                                    <th class="d-none d-md-table-cell">
                                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                            <span>{{ $trackD->track_name }}</span>
                                            @if ($trackD->sprint_status)
                                                <span class="sprint-badge">{{ __('common.sprint') }}</span>
                                            @endif
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($driverStandings as $index => $driverData)
                                @php
                                    $isPodium = $index < 3;
                                    $podiumClass = '';
                                    $podiumIcon = '';
                                    
                                    if ($index == 0) {
                                        $podiumClass = 'podium-gold';
                                        $podiumIcon = '🥇';
                                    } elseif ($index == 1) {
                                        $podiumClass = 'podium-silver';
                                        $podiumIcon = '🥈';
                                    } elseif ($index == 2) {
                                        $podiumClass = 'podium-bronze';
                                        $podiumIcon = '🥉';
                                    }
                                @endphp
                                <tr class="regular-row">
                                    <td style="text-align: center; vertical-align: middle;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            @if($isPodium)
                                                <span class="podium-icon">{{ $podiumIcon }}</span>
                                            @endif
                                            <span class="rank-badge">{{ $index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td class="text-start" style="vertical-align: middle;">
                                        <div class="driver-name">
                                            <img src="{{ asset('assets/img/drivers/' . $driverData['driver']->id . '.png') }}" 
                                                 alt="{{ $driverData['driver']->name }} {{ $driverData['driver']->surname }}"
                                                 class="driver-photo"
                                                 onerror="this.src='{{ asset('assets/img/drivers/default.png') }}'">
                                            <a href="{{ route('driver.show', driverSlug($driverData['driver']->name, $driverData['driver']->surname, $driverData['driver']->id)) }}" 
                                               style="color: inherit; text-decoration: none; transition: color 0.3s ease;"
                                               onmouseover="this.style.color='#24d9b0';"
                                               onmouseout="this.style.color='inherit';">
                                                <span>{{ $driverData['driver']->name }} {{ $driverData['driver']->surname }}</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="points-display">{{ $driverData['total_points'] }}</span>
                                    </td>
                                    @foreach ($tracks as $trackD)
                                        <td class="d-none d-md-table-cell" style="vertical-align: middle;">
                                            @if(isset($driverData['track_points'][$trackD->f1_league_track_id]['point']))
                                                @php
                                                    $isFastestLap = isset($driverData['track_points'][$trackD->f1_league_track_id]['fastest_lap']) && $driverData['track_points'][$trackD->f1_league_track_id]['fastest_lap'] == 1;
                                                    $rank = $driverData['track_points'][$trackD->f1_league_track_id]['rank'] ?? null;
                                                    $rankClass = '';
                                                    if ($rank == 1) {
                                                        $rankClass = 'rank-1';
                                                    } elseif ($rank == 2) {
                                                        $rankClass = 'rank-2';
                                                    } elseif ($rank == 3) {
                                                        $rankClass = 'rank-3';
                                                    }
                                                @endphp
                                                <span class="track-points {{ $isFastestLap ? 'fastest-lap' : '' }}">{{ $driverData['track_points'][$trackD->f1_league_track_id]['point'] }}</span>
                                                <span class="track-rank {{ $rankClass }}">/ {{ $rank ?? '-' }}</span>
                                            @else
                                                <span style="color: rgba(255, 255, 255, 0.3);">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Team Standings -->
            <div class="standings-card">
                <div class="standings-card__header">
                    <h4>
                        <i class="fas fa-users"></i>
                        {{ __('common.teams_championship') }}
                    </h4>
                </div>
                <div class="standings-card__content">
                    <div class="table-responsive">
                        <table class="standings-table table text-center align-middle">
                            <thead>
                            <tr>
                                <th style="width: 60px;">
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 70px;">
                                        <span>#</span>
                                    </div>
                                </th>
                                <th class="text-start">
                                    <div style="display: flex; flex-direction: column; align-items: flex-start; justify-content: center; height: 100%; min-height: 70px;">
                                        <span>{{ __('common.team') }}</span>
                                    </div>
                                </th>
                                <th>
                                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 70px;">
                                        <span><i class="fas fa-trophy"></i> {{ __('common.total') }}</span>
                                    </div>
                                </th>
                                @foreach ($tracks as $trackD)
                                    <th class="d-none d-md-table-cell">
                                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 70px;">
                                            <span>{{ $trackD->track_name }}</span>
                                            @if ($trackD->sprint_status)
                                                <span class="sprint-badge">{{ __('common.sprint') }}</span>
                                            @endif
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($teamStandings as $index => $teamData)
                                <tr class="regular-row">
                                    <td style="text-align: center; vertical-align: middle;">
                                        <div style="display: flex; align-items: center; justify-content: center;">
                                            <span class="rank-badge">{{ $loop->iteration }}</span>
                                        </div>
                                    </td>
                                    <td class="text-start" style="vertical-align: middle;">
                                        <div class="team-name">
                                            @if(isset($teamData['team_id']))
                                                <img src="{{ asset('assets/img/team_logo2/' . $teamData['team_id'] . '.png') }}" 
                                                     alt="{{ $teamData['team_name'] }}"
                                                     class="team-logo"
                                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                                <i class="fas fa-users team-icon-fallback" style="display: none;"></i>
                                            @else
                                                <i class="fas fa-users"></i>
                                            @endif
                                            <span>{{ $teamData['team_name'] }}</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="team-points">{{ $teamData['total_points'] }}</span>
                                    </td>
                                    @foreach ($tracks as $trackD)
                                        <td class="d-none d-md-table-cell" style="vertical-align: middle;">
                                            <span class="track-points">{{ $teamData['track_points'][$trackD->f1_league_track_id] ?? '-' }}</span>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')
    <!-- Font Awesome (CDN) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
