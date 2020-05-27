@extends('layouts.master')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12 mt-4 mb-2">
                <h1 class="text-center">{{ $year }}</h1>
            </div>
        </div>

        <div class="row">

            @foreach($months as $month)
                {!! $month !!}
            @endforeach


        </div>

    </div>
@endsection
