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
    <div class="row mt-5">
        <div class="col-12">
            <h3>All Stock Data</h3>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <table id="stock-data" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>RACK NUMBER</th>
                    <th>WEIGHT</th>
                    <th>ITEM NUMBERS</th>
                    <th>NAME</th>
                    <th>NOTE</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1 ?>
                @foreach($stocks as $data)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $data['rack_number'] }}</td>
                        <td>{{ $data['weight'] }}</td>
                        <td>{{ $data['item_number'] }}</td>
                        <td>{{ $data['name'] }}</td>
                        <td>{{ $data['note'] }}</td>
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
        $('#stock-data').dataTable({
            "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]]
        });
    </script>
@endsection
