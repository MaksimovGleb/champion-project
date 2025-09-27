@extends('layouts.admin-lte')

@section('sidebar')
    @include('pages.partials.sidebar')
@endsection

@section('menu')
    @include('pages.partials.content-header')
@endsection

@section('content')
    @include('pages.champions.partials.edit')
@endsection

@section('footer')
    @include('pages.partials.footer')
@endsection

@push('custom-scripts')
        @include('pages.champions.partials.filter_js')
@endpush
