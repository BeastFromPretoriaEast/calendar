<div class="col-xl-4 col-lg-6 col-md-6 mb-3">

    <h3 class="pl-3">{{ $month }}</h3>

    <table class="table table-bordered shadow-sm">
        <thead>
            <tr>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
            </tr>
        </thead>
        <tbody>

        @for($x = 1; $x <= $monthData['firstWeekday']['number'] - 1; $x++)
                @php
                    $increment++
                @endphp
            @if($increment == 1)
                <tr>
            @endif
                    <td></td>
            @if($increment == 7)
                @php
                    $increment = 0
                @endphp
                </tr>
            @endif
        @endfor

        @foreach($monthData['days'] as $day => $holiday)
            @php
                $increment++
            @endphp
            @if($increment == 1)
                <tr>
            @endif
                    <td>
                        @if($holiday)
                            <span class="badge badge-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $holiday }}">{{ $day }}</span>
                        @else
                            {{ $day }}
                        @endif
                    </td>
            @if($increment == 7)
                @php
                    $increment = 0
                @endphp
                </tr>
            @endif
        @endforeach

        @while ($increment != 7)
            @if($increment == 0)
                @break
            @endif

            @php
                $increment++
            @endphp
            <td></td>
            @if($increment == 7)
            </tr>
            @endif
        @endwhile

</tbody>
</table>
</div>
