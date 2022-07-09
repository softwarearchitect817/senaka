@extends('master')

@section('content')
<div class="container my-5">

    <div class="row mt-5">
        <div class="col-12">
            <h3>Edit Record</h3>
        </div>
    </div>

    <form action="{{ route('edit-record', $stock['id']) }}" method="POST">
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
        <div class="col-12 mt-5">

                <div class="row form-group mt-3">
                    <label class="col-sm-4 text-right" for="rack_number">RACK NUMBER:<span class="required">*</span></label>
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
                        <input type="text" id="item_number" name="item_number" class="form-control" placeholder="Enter Item Numbers"
                        value="{{ old('item_number', $stock['item_number']) }}" required>
                        @if ($errors->has('item_number'))<span class="w-100 ml-2 small error">{{ $errors->first('item_number') }}</span>@endif
                    </div>
                </div>

                <div class="row form-group mt-3" :class="{'d-none': !weight_required}">
                    <label class="col-sm-4 text-right" for="weight">WEIGHT:<span class="required">*</span></label>
                    <div class="col-sm-8 @if ($errors->has('weight')) has-error @endif">
                        <input type="number" id="weight" name="weight" class="form-control" placeholder="Enter Weight"
                               value="{{ old('weight', $stock['weight']) }}" :required="weight_required">
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
                            25% <input type="radio"  id="capacity" name="capacity" value="25" required v-model="capacity"  />
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
                        <textarea id="note" name="note" class="form-control" style="height: 145px;">{{ old('note', $stock['note']) }}</textarea>
                        @if ($errors->has('note'))<span class="w-100 ml-2 small error">{{ $errors->first('note') }}</span>@endif
                    </div>
                </div>


        </div>
        <div class="row text-center mt-5">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-dark w-50">SAVE</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#el',
            data: {
                rack_number: '{{ old('rack_number', $stock['rack_number']) }}',
                weight_required: true,
                available_weight: '',
                capacity: '{{ old('capacity', $stock['capacity']) }}',
            },
            computed: {
            },
            methods: {
                changeRackNumber: function() {
                    var that = this;
                    var rack_type = this.rack_number.substr(1, 1);
                    if (this.weight_required = !(rack_type == "G" || rack_type == 'g')) {
                        var param = {
                            stock_id: '{{ $stock['id'] }}',
                            rack_number: this.rack_number
                        };
                        $.get('{{ route('get-current-weight') }}', param, function(data) {
                            that.available_weight = data.message;
                        });
                    }
                }
            },
            mounted: function() {
                this.changeRackNumber();
            }
        });
    </script>
@endsection
