@extends('layouts.admin-lte')

@section('sidebar')
    @include('pages.partials.sidebar')
@endsection

@section('menu')
    @include('pages.partials.content-header')
@endsection

@section('content')
    <form action="{{ route('tournaments.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="btn-group w-100">
                <button type="submit"
                        class="btn btn-primary col fileinput-button dz-clickable">
                    <i class="fas fa-upload"></i>
                    <span>Отсортировать (создать турнирную таблицу)</span>
                </button>
            </div>
        </div>
    </form>
    @include('pages.champions.partials.create')
    @include('pages.champions.partials.champions-table')
@endsection

@section('footer')
    @include('pages.partials.footer')
@endsection

@push('custom-scripts')
        @include('pages.champions.partials.filter_js')
@endpush
