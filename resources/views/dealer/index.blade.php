@extends('master')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <style>
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .dropdown.bootstrap-select {
            position: relative;
            width: 100% !important;
        }

        .dropdown.bootstrap-select .dropdown-menu {
            min-width: 100% !important;
        }
    </style>
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
                        <select class="selectpicker" id="landing_page" name="landing_page" data-live-search="true" style="width:100%;">
                            <?php $index1 = 1 ?>
                            @foreach ($page as $row)
                                <option value="{{ $index1++ }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('landing_page'))
                            <br><span class="w-100 ml-2 small error">{{ $errors->first('landing_page') }}</span>
                        @endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="page_access">Page that have Access:<span
                            class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('page_access')) has-error @endif">
                        <select class="selectpicker" id="page_access" name="page_access" multiple data-live-search="true"
                            style="width:100%;">
                            <?php $index2 = 1 ?>
                            @foreach ($page as $row)
                                <option value="{{ $index2++ }}">{{ $row }}</option>
                            @endforeach
                        </select>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        function autocomplete(inp, arr) {
            // console.log(arr, inp);
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                // console.log(this, a)
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        // console.log(val)
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        var countries = [];

        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    </script>

    <script>
        $('body').ready(function() {
            $('.datepicker').datepicker();

            autocomplete(document.getElementById("dealer_name"), [
                @foreach ($dealer_name as $name)
                    "{{ $name }}",
                @endforeach
            ]);

            // autocomplete(document.getElementById("landing_page"), [
            //     @foreach ($page as $row)
            //         "{{ $row }}",
            //     @endforeach
            // ]);

            $('#landing_page').selectpicker();
            $('#page_access').selectpicker();
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
