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
                    <input type="number" class="form-control" v-model="item_number" @keydown="enterItemNumber">
                    <span class="w-100 ml-2 small error" :class="error == '' ? 'd-none' : ''" v-text="error"></span>
                </div>
                <div class="col-md-6 text-center mt-2">
                    <button class="btn btn-dark w-50" @click.prevent="searchWindow">Search</button>
                </div>
            </div>
            <div class="alert alert-danger mt-3" :class="{ 'd-none': result_error == '' }">Not found</div>
            <div class="row mt-5" :class="{ 'd-none': disabled_request }">
                <table class="table-responsive border-bottom mt-3" cellpadding="5" style="font-weight: bold;">
                    <tr>
                        <td>TOTAL WINDOW</td>
                        <td v-text="total_qty"></td>
                    </tr>
                </table>
                <input type="hidden" name="item_number" v-model="searched_number">
                <div class="col-md-6">
                    <table class="table-responsive border-bottom mt-3" cellpadding="5" v-for="stock in stocks">
                        <tr>
                            <td>AISLE</td>
                            <td v-text="stock.aisle"></td>
                        </tr>
                        <tr>
                            <td>RACK</td>
                            <td v-text="stock.rack_number"></td>
                        </tr>

                        <tr>
                            <td>QTY</td>
                            <td v-text="stock.qty"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 text-center mt-2">

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

                </div>



            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#el',
            data: {
                item_number: '',
                searched_number: '',
                error: '',
                stocks: [],
                disabled_request: true,
                result_error: '',
                available: ''
            },
            computed: {
                total_qty: function() {
                    var total = 0;

                    this.stocks.forEach(function(stock) {
                        total += stock.qty;
                    });
                    return total;
                },
            },
            methods: {
                enterItemNumber: function() {
                    this.error = '';
                    this.result_error = '';
                },
                searchWindow: function() {
                    if (this.item_number == '') {
                        this.error = 'please input item number';
                        return;
                    }
                    var that = this;
                    var param = {
                        item_number: this.item_number
                    };
                    $.post('{{ route('search-window') }}', param, function(data) {
                        console.log(data);
                        if (data.stocks.length > 0) {
                            that.stocks = data.stocks;
                            that.searched_number = that.item_number;
                            that.disabled_request = false;
                            that.result_error = '';
                            that.available = data.total_available;
                        } else {
                            that.disabled_request = true;
                            that.result_error = 'Not Found';
                        }
                    });
                },
            },
            mounted: function() {}
        });
    </script>
@endsection
