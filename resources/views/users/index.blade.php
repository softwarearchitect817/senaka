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
            <h3>All User Data</h3>
        </div>
    </div>
    <div class="text-right"> <a class="btn btn-dark text-light" href="{{ route('user.create') }}"> Add User</a> </div>
    <div class="row mt-5">
        <div class="col-12">
            <table id="users-data" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Landing Page</th>
                    <th >Access</th>
                    <th style="width: 150px">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1 ?>
                @foreach($users as $row)
                    <tr>
                        <td>{{ $index++ }}</td>
                  
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->first_name }}</td>
                        <td>{{ $row->last_name }}</td>
                   
                        <td>@if(is_null($row->landing)) Home @else {{ucfirst($row->landing->page)}} @endif </td>
                        <td>
                            @foreach ($row->pagesAccess as $page)
                                {{$page->page}}, <br>
                            @endforeach
                        </td>
                        <td>

                         <form id="logout-form" action="{{ route('user.destroy',['user' => $row->id]) }}" method="POST" style="display: inline">
                             @csrf
                             @method("DELETE")
                             <button type="submit"> Delete </button>
                         </form>
&nbsp;
                         <a href="{{ route('user.edit',['user' => $row->id ]) }}" class="btn btn-dark text-light"> Edit </a>
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
