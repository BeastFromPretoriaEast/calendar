<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">

    <div class="container">

        <a class="navbar-brand mr-5" href="#">
            <img class="logo" src="{{ asset('images/logo.png') }}" alt="Calendar Logo" >
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item mt-lg-0 mt-md-3 mr-3">
                    <button class="btn @if($holidays) btn-outline-primary @else btn-outline-secondary disabled @endif my-2 my-sm-0" @if(!$holidays) disabled @endif type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Display Holidays
                    </button>
                </li>
                <li class="nav-item mt-lg-0 mt-md-3">
                    <a href="{{ route('download.pdf') }}" target="_blank" class="btn @if($holidays) btn-outline-primary @else btn-outline-secondary disabled @endif my-2 my-sm-0" @if(!$holidays) disabled @endif>Print Calendar</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item active mt-lg-0 mt-md-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="darkSwitch" />
                        <label class="custom-control-label" for="darkSwitch">Dark Mode</label>
                    </div>
                </li>
            </ul>

        </div>

    </div>

</nav>
