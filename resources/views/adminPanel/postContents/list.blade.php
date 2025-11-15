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
                    <h5 class="box-title">Hazır Paylaşımlar</h5>
                </div>
                <div class="box-body">
                    <div class="overflow-auto table-bordered">
                        <table id="basic-table" class="ti-custom-table ti-striped-table ti-custom-table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Adı</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Pole</td>
                                <td><a href="{{ route('admin.postContents.pole') }}" class="btn btn-primary">Git</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Kazanan</td>
                                <td><a href="{{ route('admin.postContents.pole') }}" class="btn btn-primary">Git</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Podyum</td>
                                <td><a href="{{ route('admin.postContents.podium') }}" class="btn btn-primary">Git</a></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Puan Tablosu</td>
                                <td><a href="{{ route('admin.postContents.podium') }}" class="btn btn-primary">Git</a></td>
                            </tr>
{{--                                <tr>--}}
{{--                                    <td>2</td>--}}
{{--                                    <td>Yarış Kazanan</td>--}}
{{--                                    <td><a href="{{ route('admin.postContents.winner') }}" class="btn btn-primary">Git</a></td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>3</td>--}}
{{--                                    <td>Puan Tablosu</td>--}}
{{--                                    <td><a href="{{ route('admin.postContents.standings') }}" class="btn btn-primary">Git</a></td>--}}
{{--                                </tr>--}}
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endsection
