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
                    <h5 class="box-title">Yöneticiler</h5>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createAdminModal">
                        Yeni Ekle
                    </button>
                </div>
                <div class="box-body">
                    <div class="overflow-auto table-bordered">
                        <table id="adminsTable" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Adı</th>
                                <th>Soyadı</th>
                                <th>Kullanıcı Adı</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->surname }}</td>
                                    <td>{{ $admin->user_name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editAdminModal"
                                                onclick="editAdmin({{ $admin->id }}, '{{ $admin->name }}', '{{ $admin->surname }}', '{{ $admin->user_name }}')">
                                            Düzenle
                                        </button>
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
    <div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAdminModalLabel">Yeni Yönetici Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createAdminForm" method="POST" action="{{ route('admin.admins.create') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Soyadı</label>
                            <input type="text" class="form-control" id="surname" name="surname" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">Yönetici Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAdminForm" method="POST" action="{{ route('admin.admins.edit', ['id' => $admin->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Adı</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSurname" class="form-label">Soyadı</label>
                            <input type="text" class="form-control" id="editSurname" name="surname" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="editUserName" name="user_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Şifre</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="editPassword" name="password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleEditPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
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
            $('#adminsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
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

            $('#togglePassword').click(function () {
                const passwordInput = $('#password');
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });

            $('#toggleEditPassword').click(function () {
                const passwordInput = $('#editPassword');
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });
        });

        $('#createAdminForm').on('submit', function (e) {
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
                    $('#createAdminForm')[0].reset();
                    $('#createAdminModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı',
                        text: 'Yönetici başarıyla oluşturuldu.',
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

        $('#editAdminForm').on('submit', function (e) {
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
                    $('#editAdminModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı',
                        text: 'Yönetici başarıyla güncellendi.',
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

        function editAdmin(id, name, surname, user_name) {
            $('#editId').val(id);
            $('#editName').val(name);
            $('#editSurname').val(surname);
            $('#editUserName').val(user_name);
        }

        function deleteAdmin(id) {
            if (confirm('Bu yöneticiyi silmek istediğinizden emin misiniz?')) {
                // AJAX request for delete
            }
        }
    </script>
@endsection
