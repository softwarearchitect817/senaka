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
            <h3>Add User</h3>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 offset-2" >
            <form class="form" method="POST" action="{{ route('user.store') }}">
                @csrf
                <div class="row form-group mt-3">
                    <label for="first_name" class="col-sm-4 font-weight-bold">First Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" value="{{old('first_name')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="last_name" class="col-sm-4 font-weight-bold">Last Name:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" value="{{old('last_name')}}" required="required" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="emp_id" class="col-sm-4 font-weight-bold">Employee ID:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="emp_id" name="emp_id" placeholder="Enter Employee ID" value="{{old('emp_id')}}"  class="form-control">

                    </div>
                </div>
               
                <div class="row form-group mt-3">
                    <label for="username" class="col-sm-4 font-weight-bold">Username:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="text" id="username" name="username" placeholder="Enter Username" value="{{old('username')}}" required="required" class="form-control">

                    </div>
                </div>

                
                <div class="row form-group mt-3">
                    <label for="password" class="col-sm-4 font-weight-bold">Password:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="password" id="password" name="password" placeholder="Enter Password" value="" required="required" class="form-control">
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="password" class="col-sm-4 font-weight-bold">Password Confirmation:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="" required="required" class="form-control">
                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="phone" class="col-sm-4 font-weight-bold">Phone:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="phone" name="phone" placeholder="Enter Phone" value="{{old('phone')}}"  class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="email" class="col-sm-4 font-weight-bold">Email:</label>
                     <div class="col-sm-8 ">
                         <input type="email" id="email" name="email" placeholder="Enter Email" value="{{old('email')}}" class="form-control">

                    </div>
                </div>
                <div class="row form-group mt-3">
                    <label for="mailing_address" class="col-sm-4 font-weight-bold">Mailing Address:</label>
                     <div class="col-sm-8 ">
                         <input type="text" id="mailing_address" name="mailing_address" placeholder="Enter Mailing Address" value="{{old('mailing_address')}}"  class="form-control">

                    </div>
                </div>

                
                <div class="row form-group mt-3">
                    <label for="affiliated_to" class="col-sm-4 font-weight-bold">Affiliated to:</label>
                     <div class="col-sm-8 ">
                         <select id="affiliated_to" name="affiliated_to" class="form-control">
                            <option value="" selected> -- Select Affiliated to -- </option>
                            <option value="vinyl-pro" > Vinyl-pro </option>
                            <option value="agency" > Agency </option>
                            <option value="vinyl-pro office" > Vinyl-pro Office </option>
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="department" class="col-sm-4 font-weight-bold">Department:</label>
                     <div class="col-sm-8 ">
                         <select id="department" name="department"  class="form-control">
                            <option value="" selected> -- Select Department -- </option>
                            @foreach ($departments as $department)
                           <option value="{{$department->id}}"  > {{$department->department}} </option>
                           @endforeach
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="access" class="col-sm-4 font-weight-bold">Pages Access:<span class="required">*</span></label>
                     <div class="col-sm-8 ">
                         <select id="access" name="access[]"  value="" required="required" multiple="multiple">

                             @foreach ($pages as $page)
                             <option value="{{$page->id}}"> {{$page->page}} </option>
                             @endforeach
                         </select>
                    </div>
                </div>

                <div class="row form-group mt-3">
                    <label for="landing_page" class="col-sm-4 font-weight-bold">Landing Page:</label>
                     <div class="col-sm-8 ">
                         <select id="landing_page" name="landing_page"  value="{{old('landing_page')}}" required="required" class="form-control">
                            <option value="0" selected> home </option>
                             @foreach ($pages as $page)
                             @if($page->id != config("constant.PAGES.rack_info")) 
                             <option value="{{$page->id}}"> {{$page->page}} </option>
                             @endif
                             @endforeach
                         </select>
                         <span class="w-100 ml-2 small font-italic">make sure you have given this page access to the user</span>
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
