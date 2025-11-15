@extends('layouts.layout')

@section('content')

    <!-- Page Heading -->
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h1 class="page-heading__title">PUAN <span class="highlight">TABLOSU</span></h1>
                </div>
            </div>
        </div>
    </div>

    @include('f1leagues.components.nav')

    <!-- Content -->
    <div class="site-content py-4">
        <div class="container">

            <!-- Driver Standings -->
            <div class="card card--has-table">
                <div class="card__header">
                    <h4>PİLOTLAR ŞAMPİYONASI</h4>
                </div>
                <div class="card__content">
                    <div class="table-responsive">
                        <table class="table table-hover table-standings table-standings--full text-center align-middle">
                            <thead style="background: linear-gradient(135deg, #222, #444); color: #fff;">
                            <tr>
                                <th>#</th>
                                <th>Sürücü</th>
                                <th><i class="fas fa-trophy"></i> Toplam</th>
                                @foreach ($tracks as $trackD)
                                    <th class="d-none d-md-table-cell">
                                        {{ $trackD->track_name }}
                                        @if ($trackD->sprint_status)
                                            <span class="badge bg-warning text-dark">Sprint</span>
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($driverStandings as $index => $driverData)
                                @php
                                    // İlk 3 için renk geçişi, sadece text rengi düzeltildi
                                    $rowStyle = '';
                                    $textColor = 'text-white';
                                    $titleTextColor = '#a31a1a';
                                    $rankColor = '#6c757d ';
                                    $nameBold = '100';

                                    if ($index == 0) {
                                        $rowStyle = 'background: linear-gradient(90deg, #D4AF37, #B8860B);';
                                        $textColor = 'text-white';
                                        $titleTextColor = '#24d9b0';
                                        $rankColor = '#000';
                                        $nameBold = '900';
                                    } elseif ($index == 1) {
                                        $rowStyle = 'background: linear-gradient(90deg, #A9A9A9, #696969);';
                                        $textColor = 'text-white';
                                        $titleTextColor = '#24d9b0';
                                        $rankColor = '#000';
                                        $nameBold = '900';
                                    } elseif ($index == 2) {
                                        $rowStyle = 'background: linear-gradient(90deg, #8B4513, #A0522D);';
                                        $textColor = 'text-white';
                                        $titleTextColor = '#24d9b0';
                                        $rankColor = '#000';
                                        $nameBold = '900';
                                    }
                                @endphp
                                <tr style="{{ $rowStyle }}">
                                    <td class="fw-bold text-white">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-start text-nowrap text-white" style="white-space: nowrap; min-width: 150px; overflow: hidden; text-overflow: ellipsis; font-weight: {{ $nameBold }}">
                                        <i class="fas fa-user mr-1"></i>
                                        {{ $driverData['driver']->name }} {{ $driverData['driver']->surname }}
                                    </td>
                                    <td class="fw-bold fs-5 text-white" style="white-space: nowrap; color: {{$titleTextColor}} !important; font-size: 14px">
                                        <strong>{{ $driverData['total_points'] }}</strong>
                                    </td>
                                    @foreach ($tracks as $trackD)
                                        <td class="d-none d-md-table-cell text-nowrap text-white" style="white-space: nowrap;">
                                            @if(isset($driverData['track_points'][$trackD->f1_league_track_id]['point']))
                                                <strong>{{ $driverData['track_points'][$trackD->f1_league_track_id]['point'] }}</strong>
                                                <small class="fw-bold" style="color: {{ $rankColor }}; vertical-align: -5px"> /
                                                    {{ $driverData['track_points'][$trackD->f1_league_track_id]['rank'] ?? '-' }}
                                                </small>
                                            @else
                                                -
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
            <div class="card card--has-table">
                <div class="card__header">
                    <h4>TAKIMLAR ŞAMPİYONASI</h4>
                </div>
                <div class="card__content">
                    <div class="table-responsive">
                        <table class="table table-hover table-standings table-standings--full text-center align-middle">
                            <thead style="background: linear-gradient(135deg, #222, #444); color: #fff;">
                            <tr>
                                <th>#</th>
                                <th>Takım</th>
                                <th><i class="fas fa-trophy"></i> Toplam</th>
                                @foreach ($tracks as $trackD)
                                    <th class="d-none d-md-table-cell">
                                        {{ $trackD->track_name }}
                                        @if ($trackD->sprint_status)
                                            <span class="badge bg-warning text-dark">Sprint</span>
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($teamStandings as $index => $teamData)
                                <tr>
                                    <td class="fw-bold text-white">{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-start text-nowrap text-white" style="white-space: nowrap; min-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $teamData['team_name'] }}
                                    </td>
                                    <td class="fw-bold fs-5 text-success" style="font-size: 14px">
                                        <strong>{{ $teamData['total_points'] }}</strong>
                                    </td>
                                    @foreach ($tracks as $trackD)
                                        <td class="d-none d-md-table-cell text-white">
                                            {{ $teamData['track_points'][$trackD->f1_league_track_id] ?? '-' }}
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
