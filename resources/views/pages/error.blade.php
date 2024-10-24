@extends('layouts.appLayout')
@section('viewTitle')
    {{ $news->title }}
@endsection

@section('main')
    <div class="py-3">
        <h2 class="pt-5 my-5 text-center text-danger fw-bold"> Lỗi! </h2>
        <div class="py-5 text-center  "> @if (session('error'))
            {{session('error')}}
        @endif </div>
    </div>
@endsection
