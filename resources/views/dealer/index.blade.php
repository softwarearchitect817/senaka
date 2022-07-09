@extends('master')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
@endsection

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-6 text-right">Date: <span v-text="nowDate"></span></div>
                    <div class="col-6">Time: <span v-text="nowTime"></span></div>
                </div>
            </div>
        </div>
        <form action="{{ route('post-dealer-registration') }}" method="POST">
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
            <div class="col-md-12 mt-5">

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="dealer_name">Dealer Name:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('dealer_name')) has-error @endif">
                        <input type="text" id="dealer_name" name="dealer_name" class="form-control"
                            placeholder="Enter Dealer Name" required autocomplete="off">
                        <span class="w-100 ml-2 small font-italic">should be dealer name populated from 'workorder'</span>
                        @if ($errors->has('dealer_name'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('dealer_name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="dealer_address">Address:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('dealer_address')) has-error @endif">
                        <input type="text" id="dealer_address" name="dealer_address" class="form-control"
                            placeholder="Enter Address" required autocomplete="off">
                        @if ($errors->has('dealer_address'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('dealer_address') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="company_phone">Company Phone number:<span
                            class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('company_phone')) has-error @endif">
                        <input type="text" id="company_phone" name="company_phone" class="form-control"
                            placeholder="Enter Company Phone number" required autocomplete="off">
                        @if ($errors->has('company_phone'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('company_phone') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="cell_phone">Cell phone number:<span
                            class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('cell_phone')) has-error @endif">
                        <input type="text" id="cell_phone" name="cell_phone" class="form-control"
                            placeholder="Enter Cell phone number" required autocomplete="off">
                        @if ($errors->has('cell_phone'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('cell_phone') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="dealer_email">Email:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('dealer_email')) has-error @endif">
                        <input type="email" id="dealer_email" name="dealer_email" class="form-control"
                            placeholder="Enter Email" required autocomplete="off">
                        @if ($errors->has('dealer_email'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('dealer_email') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="dealer_username">User name:<span
                            class="required">*</span></label>
                    <div class="col-sm-3 @if ($errors->has('dealer_username')) has-error @endif">
                        <input type="text" id="dealer_username" name="dealer_username" class="form-control"
                            placeholder="Enter User Name" required autocomplete="off">
                        @if ($errors->has('dealer_username'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('dealer_username') }}</span>
                        @endif
                    </div>
                    <label class="col-sm-2 text-right" for="dealer_password">User Password:<span
                            class="required">*</span></label>
                    <div class="col-sm-3 @if ($errors->has('dealer_password')) has-error @endif">
                        <input type="password" id="dealer_password" name="dealer_password" class="form-control"
                            placeholder="Enter Address" required autocomplete="off">
                        @if ($errors->has('dealer_password'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('dealer_password') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="landing_page">Landing page:<span
                            class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('landing_page')) has-error @endif">
                        <input type="text" id="landing_page" name="landing_page" class="form-control"
                            placeholder="Enter Landing page" required autocomplete="off">
                        @if ($errors->has('landing_page'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('landing_page') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="page_access">Page that have Access:<span
                            class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('page_access')) has-error @endif">
                        <input type="text" id="page_access" name="page_access" class="form-control"
                            placeholder="Enter page that have Access" required autocomplete="off">
                        @if ($errors->has('page_access'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('page_access') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="date_input">Show records from this date:<span
                            class="required">*</span></label>
                    <div class="col-sm-2 @if ($errors->has('date_input')) has-error @endif">
                        <div class='input-group date' id='datepicker'>
                            <input type='text' name="show_record_date" class="form-control datepicker" required />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        {{-- <input type="text" id="date_input" name="date_input" class="form-control"
                            placeholder="Enter page that have Access" required autocomplete="off"> --}}
                        @if ($errors->has('date_input'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('date_input') }}</span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="text-center mt-5">
                {{-- <div class="col-sm-4 offset-4"> --}}
                <button type="submit" class="btn btn-dark btn-block">Register</button>
                {{-- </div> --}}
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('body').ready(function() {
            $('.datepicker').datepicker();
        })

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
@endsection
