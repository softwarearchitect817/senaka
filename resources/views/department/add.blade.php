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
            <h3>Add Department</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('department.store') }}">
                @csrf

                <div class="row form-group mt-3">
                    <label for="department" class="col-sm-4 font-weight-bold">Department Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="department" name="department" placeholder="Enter Department Name" value="{{old('department')}}" required="required" class="form-control"/>
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
<script type="text/javascript">
$(function(){
  $('#access').multiselect({
    buttonClass:'form-control',

  });
});
    </script>
@endsection
