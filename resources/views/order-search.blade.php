@extends('master')

@section('style')
    <style>
        .stock_count span {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 30px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    @if (session('info_message'))
        <div class="alert alert-info alert-dismissible mt-5 text-center">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('info_message') }}
        </div>
    @endif
    <div class="container my-5">
        <form action="{{ route('upload-request') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mt-2" :class="error == '' ? '' : 'has-error'">
                    <input type="text" class="form-control" v-model="order_number" @keydown="enterItemNumber">
                    <span class="w-100 ml-2 small error" :class="error == '' ? 'd-none' : ''" v-text="error"></span>
                </div>
                <div class="col-md-6 text-center mt-2">
                    <button class="btn btn-dark w-50" @click.prevent="searchOrder">Search</button>
                </div>
            </div>
            <div class="alert alert-danger mt-3" :class="{ 'd-none': result_error == '' }">Not found</div>
            <div class="row mt-5" :class="{ 'd-none': disabled_request }">
                <table class="table border-bottom mt-3" cellpadding="5" style="font-weight: bold;">
                    <tr>
                        <td>Note:</td>
                        <td v-text="note"></td>
                    </tr>
                    <tr>
                        <td>Order number:</td>
                        <td v-text="searched_number"></td>
                        <td></td>
                        <td>Company Name:</td>
                        <td v-text="company_name"></td>
                        <td></td>
                        <td>Customer PO:</td>
                        <td v-text="customer_po"></td>
                    </tr>
                </table>
                <input type="hidden" name="order_number" v-model="searched_number">
                <div class="col-md-12">
                    <table class="table table-bordered border-bottom mt-3" cellpadding="5">
                        <thead>
                            <tr>
                                <th>Item number</th>
                                <th>Window Description</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Wrapper ID</th>
                                <th>Shipped</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="stock in stocks">
                                <td v-text="stock.line"></td>
                                <td v-text="stock.window"></td>
                                <td v-text="stock.location"
                                    v-bind:style="{ background: stock.location=='No'?'red':'green' }">
                                </td>
                                <td v-text="stock.date"></td>
                                <td v-text="stock.time"></td>
                                <td v-text="stock.wrapper"></td>
                                <td class="text-success" v-text="stock.shipped"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{-- <div class="col-md-6 text-center mt-2">

                    <div class="form-group">

                        <div class="form-group">
                            <button type="submit" class="btn btn-dark w-50">Unload Request</button>
                        </div>
                        <div class="stock_count font-weight-bolder text-center">
                            <span v-text="total_qty + '/' + available" v-if="total_qty == available"
                                style="background-color: #22B14C" class="w-50">
                            </span>

                            <span v-text="total_qty + '/' + available" v-else style="background-color: #FF7F27"
                                class="w-50"></span>
                        </div>
                    </div>

                </div> --}}



            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#el',
            data: {
                order_number: '',
                searched_number: '',
                error: '',
                match: {},
                stocks: [],
                disabled_request: true,
                result_error: '',
                available: ''
            },
            computed: {
                note: function() {
                    return this.match.note;
                },
                company_name: function() {
                    return this.match.DEALER;
                },
                customer_po: function() {
                    return this.match.PO;
                },
                // total_qty: function() {
                //     var total = 0;

                //     this.stocks.forEach(function(stock) {
                //         total += stock.qty;
                //     });
                //     return total;
                // },
            },
            methods: {
                enterItemNumber: function() {
                    this.error = '';
                    this.result_error = '';
                },
                searchOrder: function() {
                    if (this.order_number == '') {
                        this.error = 'please input item number';
                        return;
                    }
                    this.searched_number = this.order_number;
                    var that = this;
                    var param = {
                        order_number: this.order_number
                    };
                    $.post('{{ route('order-search') }}', param, function(data) {
                        if (data.orders.length > 0) {
                            console.log(data.match);
                            that.stocks = data.orders.map((order => {
                                order['line'] = order['LINE #1'];
                                order['window'] = order['WINDOW DESCRIPTION'];
                                if (order['created_at']) {
                                    let fields1 = order['created_at'].split(' ');
                                    order['date'] = fields1[0];
                                    order['time'] = fields1[1];
                                }
                                if (order['wrapper']) {
                                    let fields2 = order['wrapper'].split('(');
                                    order['wrapper'] = fields2[0];
                                }
                                return order;
                            }));
                            that.match = data.match;
                            that.disabled_request = false;
                            that.result_error = '';
                            that.available = data.total_available;
                        } else {
                            that.disabled_request = true;
                            that.result_error = 'Not Found';
                        }
                    });
                    this.order_number = '';
                },
            },
            mounted: function() {}
        });
    </script>
@endsection
