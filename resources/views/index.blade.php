@extends('master')


@section('content')
<div class="container text-center my-5">

    <div class="row">

        @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.search_window'))->first())
        <div class="col-sm-6 mt-5">
            <a href="{{ route('search-window') }}" class="btn btn-dark w-50">Search Window</a>
        </div>
        @endif

        @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.stock_window'))->first())

        <div class="col-sm-6 mt-5">
            <a href="{{ route('stock-window') }}" class="btn btn-dark w-50">Stock Window</a>
        </div>
        @endif

        @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.capacity_reset'))->first())

        <div class="col-sm-6 mt-5">
            <a href="{{ route('capacity.create') }}" class="btn btn-dark w-50">Capacity Reset</a>
        </div>
        @endif


        @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.upload_request'))->first())
        <div class="col-sm-6 mt-5">
            <a href="{{ route('upload-request') }}" class="btn btn-dark w-50">Upload Request</a>
        </div>

        @endif



    </div>


</div>
@endsection


