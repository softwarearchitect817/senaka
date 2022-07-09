<!DOCTYPE html>
<html lang="en">
<head>
    <title>senaka</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.css') }}">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>

    <script src="{{ asset('assets/js/vue/vue.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.css" integrity="sha512-DJ1SGx61zfspL2OycyUiXuLtxNqA3GxsXNinUX3AnvnwxbZ+YQxBARtX8G/zHvWRG9aFZz+C7HxcWMB0+heo3w==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js" integrity="sha512-ljeReA8Eplz6P7m1hwWa+XdPmhawNmo9I0/qyZANCCFvZ845anQE+35TuZl9+velym0TKanM2DXVLxSJLLpQWw==" crossorigin="anonymous"></script>
    
    <style>
        #toastsContainerTopRight{
            position: fixed !important;
            top: 40% !important;
            left: 40% !important;
        }
    </style>
        @yield('style')
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark">
    <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">

            <li class="nav-item @if($menu == 'home') active @endif">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.complete_order'))->first())
            <li class="nav-item @if($menu == 'completeorders') active @endif">
                <a class="nav-link" href="{{ route('completeorders') }}">Complete Orders</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.search_window'))->first())
            <li class="nav-item @if($menu == 'search') active @endif">
                <a class="nav-link" href="{{ route('search-window') }}">Search Window</a>
            </li>
            @endif


            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.stock_window'))->first())
            <li class="nav-item @if($menu == 'stock') active @endif">
                <a class="nav-link" href="{{ route('stock-window') }}">Stock Window</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.window_relocate'))->first())
            <li class="nav-item @if($menu == 'relocate') active @endif">
                <a class="nav-link" href="{{ route('window-relocate') }}">Window Relocate</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.capacity_reset'))->first())
            <li class="nav-item @if($menu == 'capacity') active @endif">
                <a class="nav-link" href="{{ route('capacity.create') }}">Capacity Reset</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.edit_record'))->first())
            <li class="nav-item @if($menu == 'record') active @endif">
                <a class="nav-link" href="{{ route('edit-records') }}">Edit Records</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.upload_request'))->first())
            <li class="nav-item @if($menu == 'upload') active @endif">
                <a class="nav-link" href="{{ route('upload-request') }}">Unload Request</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.database'))->first())
            <li class="nav-item @if($menu == 'database') active @endif">
                <a class="nav-link" href="{{ route('all-data') }}">Database</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.rack_info'))->first())
            <li class="nav-item @if($menu == 'rack') active @endif">
                <a class="nav-link" href="#">Rack Information</a>
                <ul class="sub-menu">
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'A') }}">Rack A</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'B') }}">Rack B</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'C') }}">Rack C</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'D') }}">Rack D</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'E') }}">Rack E</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'F') }}">Rack F</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'G') }}">Rack G</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'H') }}">Rack H</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'I') }}">Rack I</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'J') }}">Rack J</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'K') }}">Rack K</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'L') }}">Rack L</a>
                    </li>
                    <li class="sub-menu-item">
                        <a class="nav-link" href="{{ route('rack-info', 'M') }}">Rack M</a>
                    </li>
                </ul>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.settings'))->first())
            <li class="nav-item @if($menu == 'setting' || $menu == 'departments') active @endif">
                <a class="nav-link" href="{{ route('settings') }}">Settings</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.users'))->first())
            <li class="nav-item @if($menu == 'users') active @endif">
                <a class="nav-link" href="{{ route('user.index') }}">Users</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.location_information'))->first())
            <li class="nav-item @if($menu == 'location_information') active @endif">
                <a class="nav-link" href="{{ route('location-information') }}">Location Information</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.covid_19_questions'))->first())
            <li class="nav-item @if($menu == 'covid_19_questions') active @endif">
                <a class="nav-link" href="{{ route('covid-19-data.create') }}">Covid-19 screening</a>
            </li>
            @endif

            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.covid_19_data'))->first())
            <li class="nav-item @if($menu == 'covid_19_data') active @endif">
                <a class="nav-link" href="{{ route('covid-19-data.index') }}">Covid-19 screening Data</a>
            </li>
            @endif

           


            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                 {{ __('Logout') }}
             </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
             </form>
            </li>
        </ul>

    </div>


</nav>

<div id="el">

    @yield('content')

</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>
@yield('script')
</body>
</html>
