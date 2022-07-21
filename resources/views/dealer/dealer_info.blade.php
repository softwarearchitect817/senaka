@extends('master')

@section('content')
    <div class="container my-5">
        <div class="row mt-5">
            <div class="col-12">
                <h3>{{ $dealer }}</h3>
            </div>
        </div>

        <ul class="nav nav-pills mb-3 mt-5" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                    aria-controls="pills-home" aria-selected="true">Order Status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                    aria-controls="pills-profile" aria-selected="false">Shipped orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                    aria-controls="pills-contact" aria-selected="false">Order receiving</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                {{-- <div class="text-right"> <a class="btn btn-dark text-light" href="{{ route('user.create') }}"> Add
                        User</a> </div> --}}
                <div class="row mt-5">
                    <div class="col-12">
                        <table id="dealer-data-1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer PO</th>
                                    <th>Processing</th>
                                    <th>In Production</th>
                                    <th>Assemble start</th>
                                    <th>Ready to ship</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dealer_infos as $row)
                                    <tr>
                                        <td>{{ $row['ORDER#'] }}</td>
                                        <td>{{ $row['CUST PO'] }}</td>
                                        <td class="text-center">
                                            @if ($row['processing'])
                                                <i class="green fas fa-check fa-1x"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($row['in_production'])
                                                <i class="green fas fa-check fa-1x"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row['assemble_start'])
                                                <i class="green fas fa-check fa-1x"></i>
                                            @endif
                                        </td>
                                        <td @if ($row['total_qty'] && $row['total_qty'] == $row['total_qty']) class="bg-success" @endif>
                                            {{ $row['total_qty'] }}/<span
                                                style="font-weight: bold;">{{ $row['total_qty'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-end">
                            {{ $dealer_infos->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row mt-3">
                    <label class="col-sm-2 text-right" for="batch_number">Batch number</label>
                    <div class="col-sm-4">
                        <input type="text" id="batch_number" name="batch_number" autocomplete="off">
                    </div>
                </div>
                {{-- <div class="text-right"> <a class="btn btn-dark text-light" href="{{ route('user.create') }}"> Add
                        User</a> </div> --}}
                <div class="row mt-5">
                    <div class="col-12">
                        <table id="dealer-data-2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order number</th>
                                    <th>Customer PO</th>
                                    <th>Windows</th>
                                    <th>Casing</th>
                                    <th>SU</th>
                                    <th>Patio doors</th>
                                    <th>Batch number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dealer_infos as $row)
                                    <tr>
                                        <td>{{ $row['ORDER#'] }}</td>
                                        <td>{{ $row['CUST PO'] }}</td>
                                        <td>{{ $row['windows_total'] - $row['SU'] }}/<span
                                                style="font-weight: bold;">{{ $row['windows_total'] }}</span></td>
                                        <td>0/<span style="font-weight: bold;">0</span></td>
                                        <td>{{ $row['SU'] }}/<span
                                                style="font-weight: bold;">{{ $row['windows_total'] }}</span></td>
                                        <td>0/<span style="font-weight: bold;">0</span></td>
                                        <td>{{ $row['batch_number'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-end">
                            {{ $dealer_infos->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <form action="{{ route('post-receive-order') }}" method="POST">
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
                    <div class="row mt-3">
                        <label class="col-sm-2 text-right" for="data_input">Data input</label>
                        <div class="col-sm-2">
                            <input type="text" id="data_input" name="data_input" autocomplete="off">
                        </div>
                        <label class="col-sm-2 text-right" for="location">Location</label>
                        <div class="col-sm-2">
                            <input type="text" id="location" name="location"
                                @if (session('location')) value={{ session('location') }} @endif
                                autocomplete="off">
                        </div>
                        <label class="col-sm-1 text-right" for="name">Name</label>
                        <div class="col-sm-2">
                            <input type="text" id="name" name="name"
                                @if (session('name')) value={{ session('name') }} @endif autocomplete="off">
                        </div>
                    </div>
                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-dark btn-block">Receive</button>
                    </div>
                </form>
                <div class="row mt-5">
                    <div class="col-12">
                        <table id="dealer-data-3" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shipped as $row)
                                    <tr>
                                        <td>{{ $row['Order'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        {{-- <div class="d-flex justify-content-end">
                            {{ $shipped->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#dealer-data-3').dataTable({
            "lengthMenu": [
                [10, 50, 100, 250, 500, -1],
                [10, 50, 100, 250, 500, "All"]
            ]
        });
    </script>
@endsection
