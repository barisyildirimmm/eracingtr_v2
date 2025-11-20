@extends('adminPanel.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .race-results-page {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header-card {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
            color: white;
        }
        .track-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .track-btn {
            font-size: 0.875rem;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            border-radius: 0.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #495057;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
            text-align: center;
            min-width: 140px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .track-btn.active {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: #fff !important;
            border-color: #8b0000;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }
        .track-btn:hover {
            background: linear-gradient(135deg, #e57373 0%, #ef5350 100%);
            color: white;
            border-color: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
        .sprint-label {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            color: #000;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 700;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
        }
        .results-table-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 1.5rem;
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
        .table input, .table select {
            width: 80px;
            font-size: 0.875rem;
            padding: 0.5rem;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        .table input:focus, .table select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            outline: none;
        }
        .btn-save {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            width: 100%;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }
        .driver-name-cell {
            text-align: left !important;
            font-weight: 600;
            color: #2c3e50;
        }
        .fastest-lap-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #10b981;
        }
        .reserve-driver-select {
            width: 90px;
        }
    </style>
@endsection

@section('content')
<div class="race-results-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-flag-checkered me-2"></i>{{ __('common.race_results_title') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.race_results_desc') }}
            </p>
        </div>

        <!-- {{ __('common.track_buttons') }} -->
        <div class="results-table-card mb-4">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-road me-2"></i>{{ __('common.track_selection') }}
                </h5>
            </div>
            <div class="p-3">
                <div class="track-buttons">
                    @foreach ($tracks as $track)
                        <a href="{{ route('admin.leagues.raceResults', ['league_id' => $league_id, 'track_id' => $track->f1_league_track_id]) }}"
                           class="track-btn {{ $f1_league_track_id == $track->f1_league_track_id ? 'active' : '' }}">
                            <i class="fas fa-flag-checkered"></i>
                            {{ $track->track_name }}
                            @if ($track->sprint_status)
                                <span class="sprint-label">{{ __('common.sprint') }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- {{ __('common.race_results_table') }} -->
        <div class="results-table-card">
            <div class="table-header">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-trophy me-2"></i>
                    {{ str_replace(':track', $trackNames[$f1_league_track_id]->track_name, __('common.race_results_for_track')) }}
                    @if($trackNames[$f1_league_track_id]->sprint_status)
                        <span class="sprint-label ms-2">{{ __('common.sprint') }}</span>
                    @endif
                </h5>
            </div>
            <div class="p-4">
                <form id="updateRaceResultsForm" method="POST" action="{{ route('admin.leagues.updateRaceResults') }}">
                    @csrf
                    <input type="hidden" name="league_id" value="{{ $league_id }}">
                    <input type="hidden" name="f1_league_track_id" value="{{ $f1_league_track_id }}">

                    <!-- ÜSTTEKİ GÜNCELLEME BUTONU -->
                    <button type="submit" class="btn-save mb-4">
                        <i class="fas fa-save me-2"></i> {{ __('common.update_results') }}
                    </button>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th><i class="fas fa-user me-1"></i>{{ __('common.pilot') }}</th>
                                <th><i class="fas fa-sort-numeric-up me-1"></i>{{ __('common.q_ranking') }}</th>
                                <th><i class="fas fa-sort-numeric-up me-1"></i>{{ __('common.r_ranking') }}</th>
                                <th><i class="fas fa-star me-1"></i>{{ __('common.points') }}</th>
                                @if ($qualifyingType == 0)
                                    <th><i class="fas fa-tachometer-alt me-1"></i>{{ __('common.fastest_q') }}</th>
                                @elseif ($qualifyingType == 1)
                                    <th><i class="fas fa-tachometer-alt me-1"></i>{{ __('common.q1_speed') }}</th>
                                    <th><i class="fas fa-tachometer-alt me-1"></i>{{ __('common.q2_speed') }}</th>
                                    <th><i class="fas fa-tachometer-alt me-1"></i>{{ __('common.q3_speed') }}</th>
                                @endif
                                <th><i class="fas fa-trophy me-1"></i>{{ __('common.fastest_lap') }}</th>
                                <th><i class="fas fa-tachometer-alt me-1"></i>{{ __('common.fastest_r') }}</th>
                                <th><i class="fas fa-clock me-1"></i>{{ __('common.total_time') }}</th>
                                <th><i class="fas fa-exclamation-triangle me-1"></i>{{ __('common.race_penalty') }}</th>
                                <th><i class="fas fa-exclamation-triangle me-1"></i>{{ __('common.grid_penalty') }}</th>
                                <th><i class="fas fa-user-clock me-1"></i>{{ __('common.reserve_driver') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($raceResults as $result)
                                <tr>
                                    <td class="driver-name-cell">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2" style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.7rem;">
                                                @php
                                                    $firstChar = mb_substr($result->driver_name, 0, 1, 'UTF-8');
                                                    $secondChar = mb_substr($result->driver_surname, 0, 1, 'UTF-8');
                                                    $initials = mb_strtoupper($firstChar . $secondChar, 'UTF-8');
                                                @endphp
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <strong>{{ $result->driver_name }} {{ $result->driver_surname }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control" name="q_ranking[{{ $result->id }}]" value="{{ $result->q_ranking }}"></td>
                                    <td><input type="text" class="form-control" name="r_ranking[{{ $result->id }}]" value="{{ $result->r_ranking }}"></td>
                                    <td><input type="text" class="form-control" name="points[{{ $result->id }}]" value="{{ $result->points }}"></td>

                                    @if ($qualifyingType == 0)
                                        <td><input type="text" class="form-control" name="fast_q[{{ $result->id }}]" value="{{ $result->fast_q }}"></td>
                                    @elseif ($qualifyingType == 1)
                                        <td><input type="text" class="form-control" name="fast_q1[{{ $result->id }}]" value="{{ $result->fast_q1 }}"></td>
                                        <td><input type="text" class="form-control" name="fast_q2[{{ $result->id }}]" value="{{ $result->fast_q2 }}"></td>
                                        <td><input type="text" class="form-control" name="fast_q3[{{ $result->id }}]" value="{{ $result->fast_q3 }}"></td>
                                    @endif
                                    <!-- Fastest Lap Alanı -->
                                    <td class="text-center">
                                        <input type="checkbox" class="fastest-lap-checkbox" name="fastest_lap[{{ $result->id }}]" value="{{ $result->id }}"
                                               {{ $result->fastest_lap ? 'checked' : '' }} onclick="ensureSingleFastestLap(this)">
                                    </td>

                                    <td><input type="text" class="form-control" name="fast_r[{{ $result->id }}]" value="{{ $result->fast_r }}"></td>
                                    <td><input type="text" class="form-control" name="total_time[{{ $result->id }}]" value="{{ $result->total_time }}"></td>

                                    <td><input type="number" class="form-control" name="race_penalty[{{ $result->id }}]" value="{{ $result->race_penalty }}" step="0.01"></td>
                                    <td><input type="text" class="form-control" name="grid_penalty[{{ $result->id }}]" value="{{ $result->grid_penalty }}"></td>
                                    <td>
                                        <select class="form-control reserve-driver-select" name="reserve_driver[{{ $result->id }}]">
                                            <option value="1" {{ $result->reserve_driver == 1 ? 'selected' : '' }}>{{ __('common.yes') }}</option>
                                            <option value="0" {{ $result->reserve_driver == 0 ? 'selected' : '' }}>{{ __('common.no') }}</option>
                                        </select>
                                    </td>
                                    <input type="hidden" name="update[{{ $result->id }}]" value="1">
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn-save mt-4">
                        <i class="fas fa-save me-2"></i> {{ __('common.update_results') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function ensureSingleFastestLap(clickedCheckbox) {
            document.querySelectorAll('.fastest-lap-checkbox').forEach(cb => {
                if (cb !== clickedCheckbox) {
                    cb.checked = false;
                }
            });
        }
    </script>
@endsection
