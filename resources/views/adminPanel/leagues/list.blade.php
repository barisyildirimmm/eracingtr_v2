@extends('adminPanel.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
@endsection
@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">Ligler</h5>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createLeagueModal">Yeni Ekle</button>
                </div>
                <div class="box-body">
                    <div class="overflow-auto table-bordered">
                        <table id="basic-table" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Adı</th>
                                <th>Rank</th>
                                <th>Puan Oranı</th>
{{--                                <th>Yedek Sürücü Puanı</th>--}}
{{--                                <th>Yedek Takım Puanı</th>--}}
                                <th>Durum</th>
                                <th style="text-align: center">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($leagues as $league)
                                <tr>
                                    <td>{{ $league->id }}</td>
                                    <td>{{ $league->name }}</td>
                                    <td>{{ $league->rank }}</td>
                                    <td>{{ $league->point_rate }}</td>
{{--                                    <td>--}}
{{--                                        @if($league->reserve_driver_point)--}}
{{--                                            <span class="text-success">Var</span>--}}
{{--                                        @else--}}
{{--                                            <span class="text-danger">Yok</span>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        @if($league->reserve_driver_team_point)--}}
{{--                                            <span class="text-success">Var</span>--}}
{{--                                        @else--}}
{{--                                            <span class="text-danger">Yok</span>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
                                    <td>
                                        @if($league->status)
                                            <span class="text-success">Aktif</span>
                                        @else
                                            <span class="text-danger">Pasif</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                            <a href="{{ route('admin.leagues.raceResults', ['league_id' => $league->id, 'track_id' => $league->last_track_id]) }}" class="hs-tooltip-toggle ti-btn border-primary text-decoration-none">
                                                <i class='bx bx-list-ol text-primary'></i>
                                                <span class="hs-tooltip-content ti-main-tooltip-content !bg-primary !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700" role="tooltip">
                                                    Sonuçlar
                                                </span>
                                            </a>
                                        </div>
                                        <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                            <a href="" class="hs-tooltip-toggle ti-btn border-secondary text-decoration-none">
                                                <i class="las la-road text-secondary"></i>
                                                <span class="hs-tooltip-content ti-main-tooltip-content !bg-secondary !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700" role="tooltip">
                                                    Pistler
                                                </span>
                                            </a>
                                        </div>
                                        <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                            <a href="" class="hs-tooltip-toggle ti-btn border-danger text-decoration-none">
                                                <i class='bx bx-user text-danger'></i>
                                                <span class="hs-tooltip-content ti-main-tooltip-content !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700" role="tooltip">
                                                    Pilotlar
                                                </span>
                                            </a>
                                        </div>
                                        <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                            <a href="" class="hs-tooltip-toggle ti-btn border-info text-decoration-none">
                                                <i class='bx bx-camera-movie text-info'></i>
                                                <span class="hs-tooltip-content ti-main-tooltip-content !bg-info !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700" role="tooltip">
                                                    Kayıtlar
                                                </span>
                                            </a>
                                        </div>
                                        <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                            <a href="" class="hs-tooltip-toggle ti-btn border-success text-decoration-none">
                                                <i class="las la-balance-scale text-success"></i>
                                                <span class="hs-tooltip-content ti-main-tooltip-content !bg-success !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700" role="tooltip">
                                                    Hakem Kararları
                                                </span>
                                            </a>
                                        </div>
                                        <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                            <a href="" class="hs-tooltip-toggle ti-btn border-warning text-decoration-none" data-bs-toggle="modal" data-bs-target="#editLeagueModal" onclick="editLeague({{ $league->id }}, '{{ $league->name }}', '{{ $league->status }}', '{{ $league->link }}', '{{ $league->rank }}', '{{ $league->point_rate }}', '{{ $league->reserve_driver_point }}', '{{ $league->reserve_driver_team_point }}')">
                                                <i class='bx bxs-edit text-warning'></i>
                                                <span class="hs-tooltip-content ti-main-tooltip-content !bg-warning !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700" role="tooltip">
                                                    Düzenle
                                                </span>
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
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createLeagueModal" tabindex="-1" aria-labelledby="createLeagueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLeagueModalLabel">Yeni Lig Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createLeagueForm" method="POST" action="{{ route('admin.leagues.create') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Durum</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Aktif</option>
                                <option value="0">Pasif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Bağlantı</label>
                            <input type="text" class="form-control" id="link" name="link" required>
                        </div>
                        <div class="mb-3">
                            <label for="rank" class="form-label">Rank</label>
                            <input type="number" class="form-control" id="rank" name="rank" required>
                        </div>
                        <div class="mb-3">
                            <label for="point_rate" class="form-label">Puan Oranı</label>
                            <input type="number" class="form-control" id="point_rate" name="point_rate" required>
                        </div>
                        <div class="mb-3">
                            <label for="reserve_driver_point" class="form-label">Yedek Sürücü Puanı</label>
                            <select class="form-control" id="reserve_driver_point" name="reserve_driver_point">
                                <option value="1">Var</option>
                                <option value="0">Yok</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reserve_driver_team_point" class="form-label">Yedek Takım Puanı</label>
                            <select class="form-control" id="reserve_driver_team_point" name="reserve_driver_team_point">
                                <option value="1">Var</option>
                                <option value="0">Yok</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editLeagueModal" tabindex="-1" aria-labelledby="editLeagueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLeagueModalLabel">Lig Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLeagueForm" method="POST" action="{{ route('admin.leagues.edit', ['id' => $league->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editLeagueId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Adı</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Durum</label>
                            <select class="form-control" id="editStatus" name="status">
                                <option value="1">Aktif</option>
                                <option value="0">Pasif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editLink" class="form-label">Bağlantı</label>
                            <input type="text" class="form-control" id="editLink" name="link" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRank" class="form-label">Rank</label>
                            <input type="number" class="form-control" id="editRank" name="rank" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPointRate" class="form-label">Puan Oranı</label>
                            <input type="number" class="form-control" id="editPointRate" name="point_rate" required>
                        </div>
                        <div class="mb-3">
                            <label for="editReserveDriverPoint" class="form-label">Yedek Sürücü Puanı</label>
                            <select class="form-control" id="editReserveDriverPoint" name="editReserveDriverPoint">
                                <option value="1">Var</option>
                                <option value="0">Yok</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editReserveDriverTeamPoint" class="form-label">Yedek Takım Puanı</label>
                            <select class="form-control" id="editReserveDriverTeamPoint" name="editReserveDriverTeamPoint">
                                <option value="1">Var</option>
                                <option value="0">Yok</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#basic-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                order: [[4, 'asc']],
                language: {
                    search: "Ara:",
                    lengthMenu: "Sayfada _MENU_ kayıt göster",
                    info: "_START_ ile _END_ arası gösteriliyor, toplam _TOTAL_ kayıt",
                    paginate: {
                        next: "Sonraki",
                        previous: "Önceki"
                    }
                }
            });
        });

        $('#createLeagueForm').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Lütfen bekleyin',
                text: 'Kaydediliyor...',
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
                    $('#createLeagueForm')[0].reset();
                    $('#createLeagueModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı',
                        text: 'Lig başarıyla oluşturuldu.',
                        confirmButtonText: 'Tamam'
                    }).then(() => {
                        Swal.fire({
                            title: 'Lütfen bekleyin',
                            text: 'Sayfa Yenileniyor...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        });

        $('#editLeagueForm').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Lütfen bekleyin',
                text: 'Güncelleniyor...',
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
                    $('#editLeagueModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı',
                        text: 'Lig başarıyla güncellendi.',
                        confirmButtonText: 'Tamam'
                    }).then(() => {
                        Swal.fire({
                            title: 'Lütfen bekleyin',
                            text: 'Sayfa Yenileniyor...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        });

        function editLeague(id, name, status, link, rank, pointRate, reserveDriverPoint, reserveDriverTeamPoint) {
            $('#editLeagueId').val(id);
            $('#editName').val(name);
            $('#editStatus').val(status);
            $('#editLink').val(link);
            $('#editRank').val(rank);
            $('#editPointRate').val(pointRate);
            $('#editReserveDriverPoint').val(reserveDriverPoint);
            $('#editReserveDriverTeamPoint').val(reserveDriverTeamPoint);
        }
    </script>
@endsection
