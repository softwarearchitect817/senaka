@extends('master')

@section('content')
<div class="container my-5">

    <div class="row mt-5">
        <div class="col-12">
            <h3>Location Information</h3>
        </div>
    </div>
    <hr/>
    <div class="row form-group mt-3">
        <label class="col-sm-4 text-center" for="rack_number"><b>RACK/GATE NUMBER: </b><span class="required">*</span></label>
        <div class="col-sm-8 @if ($errors->has('rack_number')) has-error @endif">
            <input type="text" id="rack_number" name="rack_number" class="form-control" placeholder="Enter Rack Number"
                   v-model="rack_number" @input="changeRackNumber" required>
            <span class="w-100 ml-2 small font-italic">should be rack number format with aisle. ex: AA150</span>
            @if ($errors->has('rack_number'))<br><span class="w-100 ml-2 small error">{{ $errors->first('rack_number') }}</span>@endif
        </div>
    </div>

    <hr/>
    <div class="alert alert-danger alert-dismissible mt-5" v-show="isError">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        @{{message}}
    </div>
    <div class="col-12" v-show="isSuccess">
        <h2> @{{rack_number_to_show}} </h2>
    </div>

    <div class="row mt-5" v-show="isSuccess">
        <div class="col-12">
            <table id="location-information-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Item Number</th>
                    <th>Weight</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Note</th>
                </tr>
                </thead>
                <tbody>

                    <tr v-for="(item, index) in items" >
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ item.item_number }}</td>
                        <td>@{{ item.weight }}</td>
                        <td>@{{ item.name }}</td>
                        <td>@{{ getDate(item.created_at) }}</td>
                        <td>@{{ tConvert(getTime(item.created_at)) }}</td>
                        <td>@{{ item.note }}</td>

                    </tr>

                </tbody>
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
            rack_number: '{{ old('rack_number') }}',
            rack_number_to_show : "",
            items : [],
            isError : false,
            message : "",
            isSuccess : false
        },
        methods: {
            changeRackNumber: function() {
                var that = this;
                    var param = {
                        rack_number: this.rack_number
                    };
                    (this.rack_number.length == 5) && $.get('get-location-information', param, function(data) {

                        if(data.status == 1){
                        that.rack_number_to_show = that.rack_number
                        that.isSuccess = true;
                        that.items = data.items;
                        that.isError = false;

                        }else{
                            that.isSuccess = false;
                            that.items = [];
                            that.isError = true;
                        }
                        that.message = data.message;
                    });

            },
            getDate(date){
                const months = [
                    "Jan","Feb","March","April","May","June","July","Aug","Sep","Oct","Nov","Dec"
                ];
                var d = new Date(date);
                dt = d.getDate();
                if(dt < 10){
                    dt = '0' + dt;
                }
                m = months[d.getMonth()];
                y = d.getFullYear();
                return ( dt + '-' + m + '-' +y );
            },
            getTime(date){
                var d = new Date(date);
                var h = d.getHours();
                var m = d.getMinutes();
                var s = d.getSeconds();

                if(h < 10){
                    h = '0' + h;
                }
                if(m < 10){
                    m = '0' + m;
                }
                if(s < 10){
                    s = '0' + s;
                }

                return h+":"+m+":"+s;

            },
            tConvert (time) {
                   // Check correct time format and split into components
                   time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                   if (time.length > 1) { // If time format correct
                     time = time.slice (1);  // Remove full string match value
                     time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                     time[0] = +time[0] % 12 || 12; // Adjust hours
                   }
                   return time.join (''); // return adjusted time or original string
                 }
         }
    });
</script>

@endsection
