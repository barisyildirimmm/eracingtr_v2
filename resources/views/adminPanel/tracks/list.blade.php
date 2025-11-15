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
                    <h5 class="box-title">Pistler</h5>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createTrackModal">Yeni Ekle</button>
                </div>
                <div class="box-body">
                    <div class="overflow-auto table-bordered">
                        <table id="tracksTable" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Adı</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tracks as $track)
                                <tr>
                                    <td>{{ $track->id }}</td>
                                    <td>{{ $track->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTrackModal" onclick="editTrack({{ $track->id }}, '{{ $track->name }}')">Düzenle</button>
{{--                                        <button class="btn btn-sm btn-danger" onclick="deleteTrack({{ $track->id }})">Sil</button>--}}
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
    <div class="modal fade" id="createTrackModal" tabindex="-1" aria-labelledby="createTrackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTrackModalLabel">Yeni Pist Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createTrackForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editTrackModal" tabindex="-1" aria-labelledby="editTrackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrackModalLabel">Pist Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTrackForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Adı</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
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
            $('#tracksTable').DataTable({
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
        });

        function editTrack(id, name) {
            $('#editId').val(id);
            $('#editName').val(name);
        }

        function deleteTrack(id) {
            if (confirm('Bu pisti silmek istediğinizden emin misiniz?')) {
                // AJAX request for delete
            }
        }
    </script>
@endsection
