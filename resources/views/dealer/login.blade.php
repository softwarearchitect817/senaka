@extends('layouts.app')


@section('css')
    <style>
        body {
            background-color: #000000;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('error_message'))
                    <div class="alert alert-danger alert-dismissible mt-5">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ session('error_message') }}
                    </div>
                @endif
                <div class="card" style="background-color: #000000 !important; color:white; margin-top:45%">
                    <div class="card-body">
                        <form method="POST" action="{{ route('post-dealer-login') }}">
                            @csrf
                            @if (session('info_message'))
                                <div class="alert alert-info alert-dismissible mt-5">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    {{ session('info_message') }}
                                </div>
                            @endif
                            @if (session('error_message'))
                                <div class="alert alert-danger alert-dismissible mt-5">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    {{ session('error_message') }}
                                </div>
                            @endif
                            <div class="mt-5">
                                <div class="form-group row">
                                    <label for="username"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Dealer Username') }}</label>
                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Dealer Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                    </div>
                                </div>

                                <div class="form-group text-center mb-0 col-md-6 offset-3 mt-5">
                                    <button type="submit" style="background-color: #000000; border:none; color:white;">
                                        {{ __('Login as Dealer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




{{-- @extends('master')
@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
@endsection

@section('content')
    <div class="card" style="background-color: #000000 !important; color:white; height: 100vh;">

        <div class="container my-5">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-6 text-right">Date: <span v-text="nowDate"></span></div>
                        <div class="col-6">Time: <span v-text="nowTime"></span></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#el',
            data: {
                nowDate: '',
                nowTime: '',
            },
            computed: {},
            methods: {
                refreshTime: function() {
                    var dateString = new Date().toLocaleString("en-US", {
                        timeZone: "America/New_York"
                    });
                    var formattedString = dateString.split(", ");
                    this.nowDate = formattedString[0];
                    this.nowTime = formattedString[1];
                    setTimeout(this.refreshTime, 1000);
                }
            },
            mounted: function() {
                this.refreshTime();
            }
        });
    </script>

    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('1b63b637002f69e4bd6c', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            console.log(data)

            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'URGENT !!!',
                // subtitle: 'Subtitle',
                body: data.message
            })
        });
    </script>
@endsection --}}
