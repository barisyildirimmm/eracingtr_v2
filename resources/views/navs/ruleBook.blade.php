@extends('layouts.layout')

@section('content')
    <div class="site-content">
        <div class="container">
            <div class="row">
{{--                <iframe src="{{ asset('assets/docs/rules.pdf') }}" width="100%" height="1000px"></iframe>--}}
                <iframe src="https://docs.google.com/gview?embedded=true&url={{ asset('assets/docs/rules.pdf') }}" width="100%" height="1000px"></iframe>
            </div>
        </div>
    </div>
@endsection
