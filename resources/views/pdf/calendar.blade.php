<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        th {
            background-color: #EFEFEF;
        }

        h3, .h3 {
            text-align: left !important;
        }

        .page-break {
            page-break-after: always;
        }

        .badge badge-primary {
            margin: auto;
        }
    </style>
</head>

<body class="text-center">

    <div class="text-center bg-light" style="padding: 5px 10px 10px 10px;">
        <img class="logo" src="{{ asset('images/logo.png') }}" alt="Calendar Logo" style="height: 50px; margin-top: 12px; margin-right: 20px;"> <span style="font-size: 3em">{{ $year }}</span>
    </div>

    <hr />

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

    <div class="page-break"></div>

    <div>
        @foreach($months as $month)
            <div>{!! $month !!}</div>
        @endforeach
    </div>

    <footer class="footer mt-2 bg-light shadow-lg">
        <div class="container bottom_border">
            <div class="row">
                <div class="col-12 pt-3 pb-3 text-center">
                    <small>
                        <img class="logo-bottom mr-2" src="{{ asset('images/logo.png') }}" alt="Calendar Logo" style="height: 20px; margin-top: 5px;"> {{ $year }} Holiday Calendar Ltd.
                    </small>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
