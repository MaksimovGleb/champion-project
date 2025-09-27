@extends('layouts.admin-lte')

@section('sidebar')
    @include('pages.partials.sidebar')
@endsection

@section('menu')
    @include('pages.partials.content-header')
@endsection

@section('content')
    @include('pages.judges.partials.create')
    @include('pages.judges.partials.judges-table')
@endsection

@section('footer')
    @include('pages.partials.footer')
@endsection

@push('custom-scripts')
        @include('pages.judges.partials.filter_js')
@endpush
