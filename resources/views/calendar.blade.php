@extends('layouts.master')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-12 mt-4 mb-2">
                <hr />
                    <h1 class="text-center mb-0">{{ $year }}</h1>
                <hr />
            </div>
        </div>

        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <table class="table table-bordered shadow-sm mb-0">
                    <thead>
                        <tr>
                            <th class="text-left">Holiday</th>
                            <th class="text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($holidays as $month => $monthData)
                        @foreach($monthData as $date => $name)
                        <tr>
                            <td class="text-left">
                                {{ $name }}
                            </td>
                            <td class="text-left">
                                {{ $date }} {{ $month }}
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>

            </div>
            <hr class="mt-4" />
        </div>

        <div class="row">

            @foreach($months as $month)
                {!! $month !!}
            @endforeach

        </div>

    </div>
@endsection
