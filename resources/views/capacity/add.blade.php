@extends('master')
@section('style')

<link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
@endsection
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
            <h3>Capacity Reset</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('capacity.store') }}">
                @csrf
                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="rack_number">RACK/GATE NUMBER:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('rack_number')) has-error @endif">
                        <input type="text" id="rack_number" name="rack_number" class="form-control" placeholder="Enter Rack Number"
                               v-model="rack_number" @input="changeRackNumber" required>
                        <span class="w-100 ml-2 small font-italic">should be rack number format with aisle. ex: AA150</span>
                        @if ($errors->has('rack_number'))<br><span class="w-100 ml-2 small error">{{ $errors->first('rack_number') }}</span>@endif
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="capacity">CAPACITY:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('capacity')) has-error @endif">

                        <div style="text-align: center; width : 19% ; display:inline-block">
                            0% <input type="radio"  id="capacity" name="capacity" value="0" required v-model="capacity" />
                        </div>
                        <div style="text-align: center; width : 19% ; display:inline-block">
                            25% <input type="radio"  id="capacity" name="capacity" value="25" required v-model="capacity" />
                        </div>
                        <div style="text-align: center; width : 19% ; display:inline-block">
                             50% <input type="radio"  id="capacity" name="capacity" value="50" required v-model="capacity" />
                        </div>
                        <div style="text-align: center; width : 19% ; display:inline-block">
                            75% <input type="radio"  id="capacity" name="capacity" value="75" required v-model="capacity" />
                        </div>
                        <div style="text-align: center; width : 19% ; display:inline-block">
                            100% <input type="radio"  id="capacity" name="capacity" value="100" required v-model="capacity" />
                       </div>
                        @if ($errors->has('capacity'))<span class="w-100 ml-2 small error">{{ $errors->first('capacity') }}</span>@endif
                    </div>
                </div>




                <div class=" form-group mt-3 text-center">
                    <button type="submit" class="btn btn-dark text-light"> Submit </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#el',
            data: {
                rack_number: '{{ old('rack_number') }}',
                capacity:null,
            },
            methods: {

                changeRackNumber: function() {
                    var that = this;
                        var param = {
                            rack_number: this.rack_number
                        };
                        that.capacity = null;
                        this.rack_number.length == 5 && $.get('get-current-capacity', param, function(data) {

                            if(data.status == 200){
                                that.capacity = data.capacity;
                            }
                        });
                }
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

