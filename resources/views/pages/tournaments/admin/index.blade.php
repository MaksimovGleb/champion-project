@extends('layouts.admin-lte')

@section('sidebar')
    @include('pages.partials.sidebar')
@endsection

@section('menu')
    @include('pages.partials.content-header')
@endsection

@section('content')
    @include('pages.tournaments.partials.tournaments-table')
@endsection

@section('footer')
    @include('pages.partials.footer')
@endsection

@push('custom-scripts')
    @include('pages.tournaments.partials.filter_js')
@endpush
