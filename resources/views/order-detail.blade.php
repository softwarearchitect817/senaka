@extends('master')

@section('style')
    <style type="text/css">
        @media (min-width: 576px) {
            div.mycontainer {
                max-width: 80%;
            }
        }

        h1, h3 {
            font-weight: bolder;
        }

        div.dataTables_wrapper {
            display: grid;
        }

        div.dataTables_wrapper div.row:first-child {
            display: block;
        }

        div.dataTables_wrapper div.row:first-child div.col-sm-12.col-md-6:first-child {
            float: right;
            text-align: right;
        }

        div.dataTables_wrapper div.row:first-child div.col-sm-12.col-md-6:nth-child(2) {
            float: left;
            text-align: left;
        }

        div.dataTables_wrapper div.dataTables_filter {
            text-align: left;
        }

        .dataTables_filter input {
            width: 340px !important;
        }
    </style>
@endsection

@section('content')
    <div class="mycontainer container my-5">
        <div class="row">
            <div class="col-sm-6">
                <h1>{{ $company['DEALER'] }}</h1>
            </div>
            <div class="col-sm-6 text-right text-danger">
                <h1>Total: {{ $total }}</h1>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table id="order-detail" class="table table-striped table-bordered w-100 text-center">
                    <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer PO</th>
                        <th>Order Date</th>
                        <th>Due Date</th>
                        <th>Days in Storage</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order['order'] }}</td>
                            <td>{{ $order['PO'] }}</td>
                            <td>{{ $order['ORDER DATE'] }}</td>
                            <td>{{ $order['DUE DATE'] }}</td>
                            <td>{{ $order['days'] }}</td>
                            <td>{{ $order['number'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#order-detail').dataTable({
                "lengthMenu": [100, 250, 500],
                //"order": [[ 1, "desc" ]],
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3],
                }, {
                    "searchable": false,
                    "targets": [2, 3, 4, 5]
                }]
            });
        });
    </script>
@endsection