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
                    <h5 class="box-title">Pilotlar</h5>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createDriverModal">Yeni Ekle</button>
                </div>
                <div class="box-body">
                    <div class="overflow-auto table-bordered">
                        <table id="basic-table" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>İsim</th>
                                <th>E-posta</th>
                                <th>Steam ID</th>
                                <th>Şehir</th>
                                <th>Telefon</th>
                                <th>Doğum Tarihi</th>
                                <th>Durum</th>
                                <th>Oluşturulma Tarihi</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->id }}</td>
                                    <td>{{ $driver->name . " " . $driver->surname }}</td>
                                    <td>{{ $driver->email }}</td>
                                    <td>{{ $driver->steam_id }}</td>
                                    <td>{{ $driver->country }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>{{ $driver->birth_date != '' ? tarihBicimi($driver->birth_date, 1) : 'Belirtilmedi' }}</td>
                                    @if($driver->status)
                                        <td class="text-success">Aktif</td>
                                    @else
                                        <td class="text-danger">Pasif</td>
                                    @endif
                                    <td>{{ tarihBicimi($driver->registration_date, 1) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDriverModal" onclick="editDriver({{ $driver->id }}, '{{ $driver->name }}', '{{ $driver->surname }}', '{{ $driver->email }}', '{{ $driver->steam_id }}', '{{ $driver->country }}', '{{ $driver->phone }}', '{{ $driver->birth_date }}', '{{ $driver->status }}')">Düzenle</button>
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
    <div class="modal fade" id="createDriverModal" tabindex="-1" aria-labelledby="createDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDriverModalLabel">Yeni Sürücü Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createDriverForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">İsim</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Soyisim</label>
                            <input type="text" class="form-control" id="surname" name="surname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="steam_id" class="form-label">Steam ID</label>
                            <input type="text" class="form-control" id="steam_id" name="steam_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Ülke</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Doğum Tarihi</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Durum</label>
                            <input type="text" class="form-control" id="status" name="status" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="editDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDriverModalLabel">Sürücü Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDriverForm">
                        <input type="hidden" id="editDriverId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">İsim</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSurname" class="form-label">Soyisim</label>
                            <input type="text" class="form-control" id="editSurname" name="surname" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">E-posta</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSteamId" class="form-label">Steam ID</label>
                            <input type="text" class="form-control" id="editSteamId" name="steam_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCountry" class="form-label">Ülke</label>
                            <input type="text" class="form-control" id="editCountry" name="country" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="editPhone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="editBirthDate" class="form-label">Doğum Tarihi</label>
                            <input type="date" class="form-control" id="editBirthDate" name="birth_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Durum</label>
                            <input type="text" class="form-control" id="editStatus" name="status" required>
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
        $.fn.dataTable.ext.type.order['date-custom-pre'] = function (date) {
            var parsedDate = date.split('.').reverse().join('-');
            return new Date(parsedDate).getTime() || 0;
        };

        $(document).ready(function () {
            $('#basic-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                columnDefs: [
                    {
                        targets: [6, 8],
                        type: 'date-custom'
                    }
                ],
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
    </script>

@endsection
