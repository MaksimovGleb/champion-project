@extends('layouts.admin-lte')

@section('sidebar')
    @include('pages.partials.sidebar')
@endsection

@section('menu')
    @include('pages.partials.content-header')
@endsection

@section('content')
    @foreach($tournament->grid as $ageKey => $category)
        <h2>{{ $ageKey }}</h2>
        @foreach($category as $weightsKey => $weightCategory)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">{{ $weightsKey }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body p-3 table-responsive">
                    <tournament-table
                        :tournament-id="{{ $tournament->id }}"
                        :groups='@json($weightCategory)'
                        :participants-arr='@json($tournament->participants)'
                        :age-category="'{{ $ageKey }}'"
                        :weight-class="'{{ $weightsKey }}'"
                        :separator-image-url="'{{ mix('/client/img/champion.logo.jpg') }}'"
                    ></tournament-table>
                </div>
            </div>
        @endforeach
    @endforeach

@endsection

@section('footer')
    @include('pages.partials.footer')
@endsection

@push('custom-scripts')
@endpush
