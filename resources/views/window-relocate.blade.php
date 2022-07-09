@extends('master')

@section('style')

<link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
@endsection

@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-6 text-right">Date: <span v-text="nowDate"></span></div>
                <div class="col-6">Time: <span v-text="nowTime"></span></div>
            </div>
        </div>
    </div>
    <form action="{{ route('post-window-relocate') }}" method="POST">
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
        <div class="col-md-12 mt-5">

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="rack_number">RACK/GATE NUMBER:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('rack_number')) has-error @endif">
                        <input type="text" id="rack_number" name="rack_number" class="form-control" placeholder="Enter Rack Number"
                               v-model="rack_number" @change="changeRackNumber" required>
                        <span class="w-100 ml-2 small font-italic">should be rack number format with aisle. ex: AA150</span>
                        @if ($errors->has('rack_number'))<br><span class="w-100 ml-2 small error">{{ $errors->first('rack_number') }}</span>@endif
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="item_number">ITEM NUMBERS:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('item_number')) has-error @endif">
                        <textarea id="item_number" name="item_number" class="form-control" style="height: 145px;" required>{{ old('item_number') }}</textarea>
                        @if ($errors->has('item_number'))<span class="w-100 ml-2 small error">{{ $errors->first('item_number') }}</span>@endif
                    </div>
                </div>


                <div class="row form-group mt-3" :class="{'d-none': !weight_required}">
                    <label class="col-sm-4 text-right" for="weight">WEIGHT:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('weight')) has-error @endif">
                        <input type="number" id="weight" name="weight" class="form-control" placeholder="Enter Weight"
                               value="{{ old('weight') }}" :required="weight_required">
                        <span class="w-100 ml-2 small" v-text="available_weight"></span>
                        @if ($errors->has('weight'))<span class="w-100 ml-2 small error">{{ $errors->first('weight') }}</span>@endif
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

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="note">NOTE:</label>
                    <div class="col-sm-8 @if ($errors->has('note')) has-error @endif">
                        <textarea v-model="note" id="note" name="note" class="form-control" style="height: 145px;">{{ old('note') }}</textarea>
                        @if ($errors->has('note'))<span class="w-100 ml-2 small error">{{ $errors->first('note') }}</span>@endif
                    </div>
                </div>

        </div>
        <div class=" text-center mt-5">
            {{-- <div class="col-sm-4 offset-4"> --}}
                <button type="submit" class="btn btn-dark btn-block">SAVE</button>
            {{-- </div> --}}
        </div>
    </form>
</div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#el',
            data: {
                nowDate: '',
                nowTime: '',
                rack_number: '{{ old('rack_number') }}',
                weight_required: false,
                available_weight: '',
                capacity:null,
                note : "",
            },
            computed: {
            },
            methods: {
                refreshTime: function() {
                    var dateString = new Date().toLocaleString("en-US", {timeZone: "America/New_York"});
                    var formattedString = dateString.split(", ");
                    this.nowDate = formattedString[0];
                    this.nowTime = formattedString[1];
                    setTimeout(this.refreshTime, 1000);
                },
                changeRackNumber: function() {
                    var that = this;
                    that.capacity = null;
                    that.note = "";
                    var rack_type = this.rack_number.substr(1, 1);
                    if (rack_type == "A" || rack_type == 'B' || rack_type == "a" || rack_type == 'b') {
                        var param = {
                            rack_number: this.rack_number
                        };
                        $.get('get-current-weight', param, function(data) {
                            if(data.status == 200){
                            that.available_weight = data.message;
                            that.weight_required = true;
                            that.capacity = data.data.capacity;
                            that.note = data.data.note;
                            }else{
                                that.weight_required = false;
                                that.capacity = null;
                            that.note = "";
                            }
                        });
                    }else{
                        that.weight_required = false;
                    }
                }
            },
            mounted: function() {
                this.refreshTime();
            }
        });
    </script>

<script src="{{asset('js/adminlte.min.js')}}"></script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

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
