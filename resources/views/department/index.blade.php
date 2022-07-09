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
            <h3>All Department Data</h3>
        </div>
    </div>
    <div class="text-right"> <a class="btn btn-dark text-light" href="{{ route('department.create') }}"> Add Department</a> </div>
    <div class="row mt-5">
        <div class="col-12">
            <table id="users-data" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Department </th>
                    <th style="width: 150px">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1 ?>
                @foreach($departments as $department)
                    <tr>
                        <td>{{ $index++ }}</td>
                  
                        <td>{{ $department->department }}</td>

                        <td>
                         <form id="logout-form" action="{{ route('department.destroy',['department' => $department->id]) }}" method="POST" style="display: inline">
                             @csrf
                             @method("DELETE")
                             <button type="submit"> Delete </button>
                         </form>
                            &nbsp;
                         <a href="{{ route('department.edit',['department' => $department->id ]) }}" class="btn btn-dark text-light"> Edit </a>
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
        $('#users-data').dataTable({
            "lengthMenu": [[10,50,100, 250, 500, -1], [10,50,100, 250, 500, "All"]]
        });
    </script>
@endsection
