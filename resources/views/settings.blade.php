@extends('master')

@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="container my-5">
    <form action="{{ route('post-settings') }}" method="POST">
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
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="row form-group mt-3">
                    <label class="col-sm-9 text-right" for="rack_a_max">RACK "A" TOTLA WEIGHT MUST LESS THAN:<span class="required">*</span></label>
                    <div class="col-sm-3 @if ($errors->has('rack_a_max')) has-error @endif">
                        <input type="number" id="rack_a_max" name="rack_a_max" class="form-control"
                               value="{{ old('rack_a_max', empty($setting['rack_a_max']) ? '' : $setting['rack_a_max']) }}" required>
                        @if ($errors->has('rack_a_max'))<br><span class="w-100 ml-2 small error">{{ $errors->first('rack_a_max') }}</span>@endif
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label class="col-sm-9 text-right" for="rack_b_max">RACK "B" TOTLA WEIGHT MUST LESS THAN:<span class="required">*</span></label>
                    <div class="col-sm-3 @if ($errors->has('rack_b_max')) has-error @endif">
                        <input type="number" id="rack_b_max" name="rack_b_max" class="form-control"
                               value="{{ old('rack_b_max', empty($setting['rack_b_max']) ? '' : $setting['rack_b_max']) }}" required>
                        @if ($errors->has('rack_b_max'))<br><span class="w-100 ml-2 small error">{{ $errors->first('rack_b_max') }}</span>@endif
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label class="col-sm-9 text-right" for="orderdate">Complete Order Date:<span class="required">*</span></label>
                    <div class="col-sm-3 @if ($errors->has('orderdate')) has-error @endif">
                        <input type="text" id="orderdate" name="orderdate" class="form-control"
                               value="{{ old('orderdate', empty($setting['orderdate']) ? '' : $setting['orderdate']) }}" required>
                        @if ($errors->has('orderdate'))<br><span class="w-100 ml-2 small error">{{ $errors->first('orderdate') }}</span>@endif
                    </div>
                </div>
                <div class="row text-center mt-5">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-dark w-50">SAVE</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </form>
</div>
<hr>
<div class="container my-5">
    <div class="row">
        <div class="col-md-12 text-center">
            @if (auth()->user()->pagesAccess()->where('pages.id',config('constant.PAGES.departments'))->first())
        <a class="btn btn-dark" href="{{ route('department.index') }}">Departments</a>
    @endif
        </div>
    </div>
</div>
@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
  <script>
      $(document).ready(function() {
          $("#orderdate").datepicker({
            dateFormat: "yy-mm-dd"
          });
      })
</script>
@endsection