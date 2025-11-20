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
                    <h5 class="box-title">{{ __('common.ready_posts') }}</h5>
                </div>
                <div class="box-body">
                    <div class="overflow-auto table-bordered">
                        <h1>STANDING</h1>
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
