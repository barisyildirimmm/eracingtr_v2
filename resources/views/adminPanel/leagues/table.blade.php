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
                    <h5 class="box-title">Lig </h5>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createModal">Yeni Ekle</button>
                </div>
                <div class="box-body">
                    <div class="overflow-auto table-bordered">
                        @include('components.dataTable', [
                            'id' => $tableId,
                            'columns' => $columns,
                            'rows' => $dataRows
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.modal', [
        'id' => 'createModal',
        'title' => $createModalTitle,
        'formId' => 'createForm',
        'fields' => $createFields
    ])

    @include('components.modal', [
        'id' => 'editModal',
        'title' => $editModalTitle,
        'formId' => 'editForm',
        'fields' => $editFields
    ])
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#{{ $tableId }}').DataTable({
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

        function editRecord(fields) {
            Object.keys(fields).forEach(function (key) {
                $('#edit' + key.charAt(0).toUpperCase() + key.slice(1)).val(fields[key]);
            });
        }
    </script>
@endsection
