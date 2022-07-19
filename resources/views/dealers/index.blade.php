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
                <h3>Dealer Information</h3>
            </div>
        </div>
        <div class="text-right"> <a class="btn btn-dark text-light" href="{{ route('dealer.registration') }}"> Add
                Dealer</a>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table id="users-data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Dealer Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Landing Page</th>
                            {{-- <th>Access</th> --}}
                            <th style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        @foreach ($dealers as $row)
                            <tr>
                                <td>{{ $index++ }}</td>

                                <td>{{ $row->dealer_name }}</td>
                                <td>{{ $row->dealer_address }}</td>
                                <td>{{ $row->dealer_email }}</td>
                                <td>{{ $row->dealer_username }}</td>

                                <td>
                                    @if (is_null($row->landing_page))
                                        Home
                                    @else
                                        {{ ucfirst($row->landing_page) }}
                                    @endif
                                </td>
                                {{-- <td>
                                    @foreach ($row->pagesAccess as $page)
                                        {{ $page->page }}, <br>
                                    @endforeach
                                </td> --}}
                                <td>

                                    <form id="logout-form-1"
                                        action="{{ route('dealers.destroy', ['dealer' => $row->id]) }}" method="POST"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"> Delete </button>
                                    </form>
                                    &nbsp;
                                    <a href="{{ route('dealers.edit', ['dealer' => $row->id]) }}"
                                        class="btn btn-dark text-light"> Edit </a>
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
            "lengthMenu": [
                [10, 50, 100, 250, 500, -1],
                [10, 50, 100, 250, 500, "All"]
            ]
        });
    </script>
@endsection
