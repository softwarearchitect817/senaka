@extends('master')
@section('style')

<link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">

@endsection
@section('content')
<div class="container my-5">
    <div class="row" :class="{'d-none' : uploads.length == 0}">
        <div class="col-sm-6">
            <a href="#" class="btn btn-danger" @click="deleteRecord(0)">CLEAR ALL</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <table id="uploads" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>AISLE</th>
                    <th>RACK</th>

                    <th>QTY</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th style="width: 70px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(upload, index) in uploads">
                    <td v-text="index + 1"></td>
                    <td v-text="upload.aisle"></td>
                    <td v-text="upload.rack_number"></td>

                    <td v-text="upload.qty"></td>
                    <td v-text="upload.date"></td>
                    <td v-text="upload.time"></td>
                    <td>
                        <a href="javascript:void(0);" @click="deleteRecord(upload.id)" class="btn btn-danger">CLEAR</a>
                    </td>
                </tr>
                <tr :class="{'d-none' : uploads.length > 0}">
                    <td colspan="8">No data</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th>AISLE</th>
                    <th>RACK</th>
                    <th>QTY</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#el',
            data: {
                uploads: [],
            },
            computed: {
            },
            methods: {
                getUploadRequest: function() {
                    var that = this;
                    $.get('{{ route('get-upload-request') }}', function(data) {
                        that.uploads = data.uploads;
                    });
                    setTimeout(function() {
                        that.getUploadRequest();
                    }, 1000);
                },
                deleteRecord: function(id) {
                    var msg = "Are you sure delete " + (id == 0 ? "all" : "this") + " record?";
                    if (confirm(msg)) {
                        window.location.href="{{ URL::to('delete-upload') }}/" + id;
                    }
                }
            },
            mounted: function() {
                this.getUploadRequest();
            }
        });
    </script>

<script src="{{asset('js/adminlte.min.js')}}"></script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('1b63b637002f69e4bd6c', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        console.log(data)

      $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'URGENT !!!',
        // subtitle: 'Subtitle',
        body: data.message
      })
    });
  </script>
@endsection
