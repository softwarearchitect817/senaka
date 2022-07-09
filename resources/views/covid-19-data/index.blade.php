@extends('master')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"
        integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <style>
        .font-15 {
            font-size: 15px;
        }

    </style>

    <style>
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999999999999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

            background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        #toastsContainerTopRight {
            position: fixed !important;
            top: 10px !important;
            right: 0px !important;
            left: 85% !important;
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }

    </style>
@endsection

@section('content')

    <div class="container-fluid my-5">
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

        <div class="" id="app">
            <div class="loading" id="full_page_loader" v-show="loading">Loading&#8230;</div>

            <div class="col-12 mb-3 text-center">
                <h1>COVID-19 screening daily report </h1>
            </div>

            <div class="row text-left pl-5 mb-3">
                <h5>Date : @{{ heading_date }} <button @click="openCalendar" class="btn btn-dark"><i
                    class="far fa-calendar-alt"></i></button>
            <vuejs-datepicker ref="calendar" @selected="handleDateChange"
                input-class="form-control d-none" placeholder="Select Date" :value="selected_date">
            </vuejs-datepicker>
        </h5>
            </div>

            <div class="row">
                <div class="col-lg-4 col-12 mb-3 table-responsive">
                    <div class="h5 text-center mb-3">Total Employees</div>
                            <table class="table table-bordered table-striped no-footer table-fluid text-center">
                                <thead>
                                    <tr class="font-15">
                                        <th>Affiliated</th>
                                        <th>Sign in</th>
                                        <th>Registerd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(emp,index) in total_employees" :key="index">
                                        <td class="text-left"> @{{ emp . category }} </td>
                                        <td> @{{ emp . sign_in }} </td>
                                        <td> @{{ emp . registered }} </td>
                                    </tr>
                                </tbody>
                            </table>
                </div>
                <div class="col-lg-4 col-12 mb-3 row  no-print">
                    <div class="col-12  text-center">
                        <div class="form-group row">
                            <label for="inputPassword"
                                class="col-sm-4 col-form-label font-15 font-weight-bold">Affiliated:</label>
                            <div class="col-sm-8">
                                <select v-model="selected_category" class="form-control d-inline">
                                    <option value="all"> Show All </option>
                                    <option value="vinyl-pro"> Vinyl-pro </option>
                                    <option value="vinyl-pro office"> Vinyl-pro Office </option>
                                    <option value="agency"> Agency </option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="inputPassword"
                                class="col-sm-4 col-form-label font-15 font-weight-bold">Department:</label>
                            <div class="col-sm-8">
                                <select v-model="selected_department" class="form-control d-inline">
                                    <option value="0"> Show All </option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"> {{ $department->department }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-sm-12 ">
                                <button type="button" class="btn btn-dark  m-1" @click="printPage">Print</button>
                                <button type="button" class="btn btn-dark  m-1" @click="exportData">Export
                                    CSV</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mb-3 text-center">
                    <canvas id="pieChart" class=""></canvas>
                </div>
            </div>

            <div class="row table-responsive mb-3">
                <table class="table table-bordered table-striped no-footer table-fluid  text-center">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                            <th>Q4</th>
                            <th>Q5</th>
                            <th>Q6</th>
                            <th>Q7</th>
                            <th>Q8</th>
                            <th>Q9</th>
                            <th>Q10</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id"
                            v-if="(selected_category == 'all' || selected_category == user.affiliated_to ) && (selected_department == '0' || selected_department == user.department_id) ">

                            <td class="text-left"> @{{ user . first_name }} @{{ user . last_name }} </td>
                            <td> @{{ user . phone }}</td>

                            <td v-if="user.covid_form_submission"> @{{ user . covid_form_submission . created_at }} </td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="bg-success text-white">Completed </td>
                            <td v-else class="bg-danger text-white"> <strong>Not</strong> </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.fever == 'no', 'text-danger': user.covid_form_submission.fever == 'yes' }">
                                @{{ user . covid_form_submission . fever }} </td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.cough == 'no', 'text-danger': user.covid_form_submission.cough == 'yes' }">
                                @{{ user . covid_form_submission . cough }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.shortness_of_breath == 'no', 'text-danger': user.covid_form_submission.shortness_of_breath == 'yes' }">
                                @{{ user . covid_form_submission . shortness_of_breath }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.trouble_in_swallowing == 'no', 'text-danger': user.covid_form_submission.trouble_in_swallowing == 'yes' }">
                                @{{ user . covid_form_submission . trouble_in_swallowing }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.stuffy_nose == 'no', 'text-danger': user.covid_form_submission.stuffy_nose == 'yes' }">
                                @{{ user . covid_form_submission . stuffy_nose }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.loss_of_taste == 'no', 'text-danger': user.covid_form_submission.loss_of_taste == 'yes' }">
                                @{{ user . covid_form_submission . loss_of_taste }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.nausea_etc == 'no', 'text-danger': user.covid_form_submission.nausea_etc == 'yes' }">
                                @{{ user . covid_form_submission . nausea_etc }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.tiredness == 'no', 'text-danger': user.covid_form_submission.tiredness == 'yes' }">
                                @{{ user . covid_form_submission . tiredness }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.ppe == 'no', 'text-danger': user.covid_form_submission.ppe == 'yes' }">
                                @{{ user . covid_form_submission . ppe }}</td>
                            <td v-else> - </td>

                            <td v-if="user.covid_form_submission" class="font-weight-bold text-uppercase"
                                :class="{ 'text-success': user.covid_form_submission.travelled_outside == 'no', 'text-danger': user.covid_form_submission.travelled_outside == 'yes' }">
                                @{{ user . covid_form_submission . travelled_outside }}</td>
                            <td v-else> - </td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/vuejs-datepicker"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
        integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script>
        Chart.defaults.global.plugins.labels = {
            render: 'percentage',
            fontSize: 20,
            fontStyle: 'bold',
            fontColor: '#000',
        };

    </script>
    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            data: {
                selected_date: new Date(),
                selected_category: "all",
                selected_department: "0",
                departments: null,
                pieChart: null,
                total_employees: [],
                users: [],
                loading: true
            },
            components: {
                vuejsDatepicker
            },
            computed: {
                heading_date: function() {
                    var date = this.selected_date.getFullYear() + '-';
                    if (this.selected_date.getMonth() >= 9) {
                        date += (this.selected_date.getMonth() + 1) + '-';
                    } else {
                        date += '0' + (this.selected_date.getMonth() + 1) + '-';
                    }
                    date += this.selected_date.getDate();
                    return date;
                }
            },
            methods: {
                setupPieChart() {
                    var ctx = document.getElementById('pieChart');
                    this.pieChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                fill: true,
                                data: [0, 0, 0],
                                backgroundColor: [
                                    'rgba(54,162,235,1)',
                                    'rgba(255,99,132,1)',
                                    'rgba(255,205,86,1)',
                                ],
                                borderColor: ['white', 'white', 'white'],
                            }],

                            // These labels appear in the legend and in the tooltips when hovering different arcs
                            labels: [
                                'Agency',
                                'Vinyl-pro',
                                'Vinyl-pro Office'
                            ]
                        },
                        options: {
                            legend: {
                                // display: false,
                                labels: {
                                    // This more specific font property overrides the global property
                                    fontSize: 20,
                                    fontColor: 'black'
                                },

                            },
                        }
                    });
                },
                fetchData() {
                    this.loading = true;

                    var date = this.selected_date.getFullYear() + '-';
                    if (this.selected_date.getMonth() >= 9) {
                        date += (this.selected_date.getMonth() + 1) + '-';
                    } else {
                        date += '0' + (this.selected_date.getMonth() + 1) + '-';
                    }
                    date += this.selected_date.getDate();

                    $.ajax({
                        type: "POST",
                        url: " {{ route('covid-19-data.getData') }} ",
                        data: {
                            date: date
                        },
                        success: (response) => {
                            this.updatePieChart(response.data.pie_chart_data);
                            this.total_employees = response.data.total_employees;
                            this.users = response.data.users;
                            this.loading = false;
                        },
                        error: (response) => {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Error !',
                                body: response.responseJSON.errors.date.join("\n")
                            })
                            this.loading = false;
                        }
                    });
                },
                handleDateChange(date) {
                    this.selected_date = date;
                    this.fetchData();
                },
                updatePieChart(data) {
                    this.pieChart.data.datasets[0].data = data;
                    this.pieChart.update();
                },
                printPage() {
                    window.print();
                },
                exportData() {
                    this.loading = true;

                    var date = this.selected_date.getFullYear() + '-';
                    if (this.selected_date.getMonth() >= 9) {
                        date += (this.selected_date.getMonth() + 1) + '-';
                    } else {
                        date += '0' + (this.selected_date.getMonth() + 1) + '-';
                    }
                    date += this.selected_date.getDate();

                    $.ajax({
                        xhrFields: {
                            responseType: 'blob',
                        },
                        type: "POST",
                        url: " {{ route('covid-19-data.export') }} ",
                        data: {
                            date: date,
                            category: this.selected_category,
                            department: this.selected_department
                        },
                        success: (result, status, xhr) => {

                            this.loading = false;

                            var disposition = xhr.getResponseHeader('content-disposition');
                            var matches = /"([^"]*)"/.exec(disposition);
                            var filename = (matches != null && matches[1] ? matches[1] :
                                `${date}_${this.selected_category}_${this.selected_department}.xlsx`
                            );

                            // The actual download
                            var blob = new Blob([result], {
                                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = filename;

                            document.body.appendChild(link);

                            link.click();
                            document.body.removeChild(link);
                        },
                        error: (response) => {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Error !',
                                body: "Opps Something went wrong!"
                            })
                            this.loading = false;
                        }
                    });
                },
                openCalendar() {
                    this.$refs.calendar.showCalendar();
                },
            },
            mounted() {
                this.setupPieChart();
                this.fetchData();
            }
        })

    </script>
@endsection
