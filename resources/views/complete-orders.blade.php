@extends('master')


@section('style')
    <style type="text/css">
        @media (min-width: 576px) {
            div.mycontainer {
                max-width: 80%;
            }
        }

        h1 {
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

        a.btn-info {
            max-width: 254px;
        }
    </style>
@endsection

@section('content')
    <div class="mycontainer container my-5">
        <div class="row">
            <div class="col-sm-6">
                <h1>Complete Orders</h1>
            </div>
            <div class="col-sm-6 text-right text-danger">
                <h1>Total - {{ $total }}</h1>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <table id="complete-orders" class="table table-striped table-bordered w-100">
                    <thead>
                    <tr>
                        <th>Dealer Name</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Information</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $dealer => $order)
                        <tr>
                            <td>{{ $dealer }}</td>
                            <td class="text-center">{{ $order['number'] }}</td>
                            <td class="d-flex justify-content-center">
                                <a class="btn btn-block btn-info" href="{{ route('orderdetail', $order['id']) }}">
                                    Information
                                </a>
                            </td>
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
            $('#complete-orders').dataTable({
                "lengthMenu": [100, 250, 500],
                "order": [[ 1, "desc" ]],
                "columnDefs": [{
                    "sortable": false,
                    "targets": 2,
                }, {
                    "searchable": false,
                    "targets": [1, 2]
                }]
            });
        });
    </script>
@endsection