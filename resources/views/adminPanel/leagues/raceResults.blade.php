@extends('adminPanel.layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        .track-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .track-btn {
            font-size: 14px;
            padding: 8px 12px;
            font-weight: bold;
            border-radius: 6px;
            background-color: #f8f9fa;
            color: #333;
            border: 2px solid #ccc;
            transition: all 0.3s ease-in-out;
            text-align: center;
            min-width: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .track-btn.active {
            background: linear-gradient(90deg, #b71c1c, #d32f2f);
            color: #fff !important;
            border-color: #8b0000;
            box-shadow: 0 0 10px rgba(183, 28, 28, 0.7);
        }
        .track-btn:hover {
            background-color: #e57373;
            color: white;
            border-color: #c62828;
        }
        .sprint-label {
            background-color: #ffc107;
            color: #000;
            font-size: 12px;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }
        .table thead th {
            background: linear-gradient(135deg, #222, #444);
            color: #fff;
            text-align: center;
        }
        .table tbody td {
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
            padding: 8px;
        }
        .table input, .table select {
            width: 80px;
            font-size: 12px;
            padding: 3px;
            text-align: center;
            display: block;
            margin: auto;
        }
        .btn-block {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <!-- Pistler için Butonlar -->
        <div class="mb-4">
            <h5 class="mb-3 font-bold text-lg">Pistler</h5>
            <div class="track-buttons">
                @foreach ($tracks as $track)
                    <a href="{{ route('admin.leagues.raceResults', ['league_id' => $league_id, 'track_id' => $track->f1_league_track_id]) }}"
                       class="btn track-btn {{ $f1_league_track_id == $track->f1_league_track_id ? 'active' : '' }}">
                        {{ $track->track_name }}
                        @if ($track->sprint_status)
                            <span class="sprint-label">Sprint</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Yarış Sonuçları Tablosu -->
        <div class="box">
            <div class="box-header">
                <h5 class="box-title text-lg font-semibold">Yarış Sonuçları ({{ $trackNames[$f1_league_track_id]->track_name }}{{ $trackNames[$f1_league_track_id]->sprint_status ? ' - Sprint' : '' }})</h5>
            </div>
            <div class="box-body">
                <form id="updateRaceResultsForm" method="POST" action="{{ route('admin.leagues.updateRaceResults') }}">
                    @csrf
                    <input type="hidden" name="league_id" value="{{ $league_id }}">
                    <input type="hidden" name="f1_league_track_id" value="{{ $f1_league_track_id }}">

                    <!-- ÜSTTEKİ GÜNCELLEME BUTONU -->
                    <button type="submit" class="btn btn-success btn-block mb-3"><i class="fas fa-save"></i> Sonuçları Güncelle</button>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Pilot</th>
                                <th>Q Sıralaması</th>
                                <th>R Sıralaması</th>
                                <th>Puan</th>
                                @if ($qualifyingType == 0)
                                    <th>En Hızlı Q</th>
                                @elseif ($qualifyingType == 1)
                                    <th>Q1 Hızı</th>
                                    <th>Q2 Hızı</th>
                                    <th>Q3 Hızı</th>
                                @endif
                                <th>Fastest Lap</th>
                                <th>En Hızlı R</th>
                                <th>Toplam Süre</th>
                                <th>Yarış Cezası</th>
                                <th>Grid Cezası</th>
                                <th>Yedek Sürücü</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($raceResults as $result)
                                <tr>
                                    <td class="text-start text-nowrap font-semibold">
                                        <i class="fas fa-user mr-1"></i>
                                        {{ $result->driver_name }} {{ $result->driver_surname }}
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
                                    <td><select class="form-control" name="reserve_driver[{{ $result->id }}]">
                                            <option value="1" {{ $result->reserve_driver == 1 ? 'selected' : '' }}>Evet</option>
                                            <option value="0" {{ $result->reserve_driver == 0 ? 'selected' : '' }}>Hayır</option>
                                        </select>
                                    </td>
                                    <input type="hidden" name="update[{{ $result->id }}]" value="1">
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success btn-block mt-3"><i class="fas fa-save"></i> Sonuçları Güncelle</button>
                </form>
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