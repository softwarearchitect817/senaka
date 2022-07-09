@extends('master')

@section('content')
<div class="container my-5">
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
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3 mt-2" :class="error == '' ? '' : 'has-error'">
            <input type="text" class="form-control" v-model="item_number" @keydown="enterItemNumber">
            <span class="w-100 ml-2 small error" :class="error == '' ? 'd-none' : ''" v-text="error"></span>
        </div>
        <div class="col-md-3 text-center mt-2">
            <button class="btn btn-dark w-50" @click.prevent="pullRecord">Search</button>
        </div>
        <div class="col-md-3"></div>
    </div>
    <form action="{{ route('delete-records') }}" method="POST">
        @csrf
        <div class="row mt-5" :class="{'d-none': selected == 0}">
            <div class="col-12">
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="all" @click="selectAll"> <label for="all" class="mb-0">Select All</label></th>
                        <th>RACK NUMBER</th>

                        <th>WEIGHT</th>
                        <th>ITEM NUMBERS</th>
                        <th>NAME</th>
                        <th>NOTE</th>
                        <th style="width: 70px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="stock in stocks">
                        <td align="center"><input type="checkbox" name="ids[]" :value="stock.id" @click="selectAll"></td>
                        <td v-text="stock.rack_number"></td>

                        <td v-text="stock.weight"></td>
                        <td v-text="stock.item_number"></td>
                        <td v-text="stock.name"></td>
                        <td v-text="stock.note"></td>
                        <td>
                            <a href="javascript:void(0);" @click="editRecord(stock.id)" class="btn btn-dark">Edit</a>
                        </td>
                    </tr>
                    <tr :class="stocks.length > 0 ? 'd-none' : ''">
                        <td colspan="8">no data found</td>
                    </tr>
                    </tbody>
                </table>
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
                error: '',
                stocks: [],
                selected: 0
            },
            computed: {
            },
            methods: {
                enterItemNumber: function() {
                    this.error = '';
                },
                pullRecord: function() {
                    if (this.item_number == '') {
                        this.error = 'please input item number';
                        return;
                    }
                    var that = this;
                    var param = {
                        item_number: this.item_number
                    };
                    $.post('{{ route('get-records') }}', param, function(data) {
                        that.stocks = data.stocks;
                    });
                },
                editRecord: function (id) {
                    window.location.href="{{ URL::to('edit-record') }}/" + id;
                },
                selectAll: function(event) {
                    if (event.target.id == 'all') $("[name='ids[]']").prop('checked', event.target.checked);
                    this.selected = $("[name='ids[]']:checked").length
                }
            },
            mounted: function() {
            }
        });
    </script>
@endsection
