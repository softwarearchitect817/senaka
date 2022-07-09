@extends('master')
@section('style')

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
@endsection
@section('content')
    <div class="container my-5">
     



        <div class="row mt-5">
            <div class="col-12 img-responsive text-center">
                <img src="{{ asset('assets/images/covid19.png') }}" class="img-fluid" />
            </div>
        </div>

        <div class="row mt-5">



            <div class="col-md-2"></div>
            <div class="col-md-8 text-center">

                <h1 class="mb-5 pb-1" style="border-bottom: 5px solid black"> COVID-19 screening</h1>

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

                <form class="form" method="POST" action="{{route("covid-19-data.store")}}">
                  @csrf
                    <div class="form-group row">
                        <label for="employee_name" class="col-sm-3 col-form-label">Name of employee:</label>
                        <div class="col-sm-9">
                            <input  value="{{auth()->user()->first_name . ' '. auth()->user()->last_name}}" required  type="text" class="form-control  @error('employee_name') is-invalid @enderror" id="employee_name"
                                placeholder="Name of employee" name="employee_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="employee_id" class="col-sm-3 col-form-label">Employee ID:</label>
                        <div class="col-sm-9">
                            <input  value="{{auth()->user()->emp_id}}" required  type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id"
                                placeholder="Employee ID">
                        </div>
                    </div>

                    <hr>


                    <div class="form-group">
                        <label class="@error('fever') text-danger @enderror" for="fever" >Do you have fever? </label><br>
                        <div class="form-check form-check-inline">
                            <input @if(old('fever') == 'yes') checked @endif required  class="form-check-input" type="radio" name="fever" id="fever_yes" value="yes">
                            <label class="form-check-label" for="fever_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('fever') == 'no') checked @endif required  class="form-check-input" type="radio" name="fever" id="fever_no" value="no">
                            <label class="form-check-label" for="fever_no">No</label>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label  class="@error('cough') text-danger @enderror" for="cough">Do you have cough? </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('cough') == 'yes') checked @endif required class="form-check-input" type="radio" name="cough" id="cough_yes" value="yes">
                            <label class="form-check-label" for="cough_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('cough') == 'no') checked @endif required class="form-check-input" type="radio" name="cough" id="cough_no" value="no">
                            <label class="form-check-label" for="cough_no">No</label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label  class="@error('shortness_of_breath') text-danger @enderror" for="shortness_of_breath">Do you experience difficult in breathing or shortness of breath?
                        </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('shortness_of_breath') == 'yes') checked @endif required  class="form-check-input" type="radio" name="shortness_of_breath"
                                id="shortness_of_breath_yes" value="yes">
                            <label class="form-check-label" for="shortness_of_breath_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('shortness_of_breath') == 'no') checked @endif required  class="form-check-input" type="radio" name="shortness_of_breath"
                                id="shortness_of_breath_no" value="no">
                            <label class="form-check-label" for="shortness_of_breath_no">No</label>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label  class="@error('trouble_in_swallowing') text-danger @enderror" for="trouble_in_swallowing">Do you have sore throat, trouble in swallowing? </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('trouble_in_swallowing') == 'yes') checked @endif required  class="form-check-input" type="radio" name="trouble_in_swallowing"
                                id="trouble_in_swallowing_yes" value="yes">
                            <label class="form-check-label" for="trouble_in_swallowing_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('trouble_in_swallowing') == 'no') checked @endif required  class="form-check-input" type="radio" name="trouble_in_swallowing"
                                id="trouble_in_swallowing_no" value="no">
                            <label class="form-check-label" for="trouble_in_swallowing_no">No</label>
                        </div>
                    </div>


                    <hr>
                    <div class="form-group">
                        <label  class="@error('stuffy_nose') text-danger @enderror" for="stuffy_nose">Do you have runny/stuffy nose? </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('stuffy_nose') == 'yes') checked @endif required  class="form-check-input" type="radio" name="stuffy_nose" id="stuffy_nose_yes"
                                value="yes">
                            <label class="form-check-label" for="stuffy_nose_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('stuffy_nose') == 'no') checked @endif required  class="form-check-input" type="radio" name="stuffy_nose" id="stuffy_nose_no"
                                value="no">
                            <label class="form-check-label" for="stuffy_nose_no">No</label>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label  class="@error('loss_of_taste') text-danger @enderror" for="loss_of_taste">Are you experiencing decreasing or loss of taste or smell? </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('loss_of_taste') == 'yes') checked @endif required  class="form-check-input" type="radio" name="loss_of_taste"
                                id="loss_of_taste_yes" value="yes">
                            <label class="form-check-label" for="loss_of_taste_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('loss_of_taste') == 'no') checked @endif required  class="form-check-input" type="radio" name="loss_of_taste" id="loss_of_taste_no"
                                value="no">
                            <label class="form-check-label" for="loss_of_taste_no">No</label>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label  class="@error('nausea_etc') text-danger @enderror" for="nausea_etc">Do you have any nausea, vomiting or diarrhea? </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('nausea_etc') == 'yes') checked @endif required  class="form-check-input" type="radio" name="nausea_etc" id="nausea_etc_yes"
                                value="yes">
                            <label class="form-check-label" for="nausea_etc_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('nausea_etc') == 'no') checked @endif required  class="form-check-input" type="radio" name="nausea_etc" id="nausea_etc_no"
                                value="no">
                            <label class="form-check-label" for="nausea_etc_no">No</label>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label  class="@error('tiredness') text-danger @enderror" for="tiredness"> Do you experience any extreme tiredness or sore muscles? </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('tiredness') == 'yes') checked @endif required  class="form-check-input" type="radio" name="tiredness" id="tiredness_yes"
                                value="yes">
                            <label class="form-check-label" for="tiredness_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('tiredness') == 'no') checked @endif required  class="form-check-input" type="radio" name="tiredness" id="tiredness_no"
                                value="no">
                            <label class="form-check-label" for="tiredness_no">No</label>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label  class="@error('ppe') text-danger @enderror" for="ppe"> Have you had close contact with a confirmed or probable case of COVID – 19 without
                            wearing appropriate PPE? </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('ppe') == 'yes') checked @endif required  class="form-check-input" type="radio" name="ppe" id="ppe_yes" value="yes">
                            <label class="form-check-label" for="ppe_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('ppe') == 'no') checked @endif required  class="form-check-input" type="radio" name="ppe" id="ppe_no" value="no">
                            <label class="form-check-label" for="ppe_no">No</label>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label  class="@error('travelled_outside') text-danger @enderror" for="travelled_outside">Have you travelled outside of Canada in the past 14 days?
                        </label><br>
                        <div class="form-check form-check-inline">
                            <input  @if(old('travelled_outside') == 'yes') checked @endif required  class="form-check-input" type="radio" name="travelled_outside"
                                id="travelled_outside_yes" value="yes">
                            <label class="form-check-label" for="travelled_outside_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input  @if(old('travelled_outside') == 'no') checked @endif required  class="form-check-input" type="radio" name="travelled_outside"
                                id="travelled_outside_no" value="no">
                            <label class="form-check-label" for="travelled_outside_no">No</label>
                        </div>
                    </div>
                    <hr>

                    <div class=" form-group mt-3 text-center">
                        <button type="submit" class="btn btn-dark text-light"> Submit </button>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="{{ asset('js/adminlte.min.js') }}"></script>


    <script>


    </script>

@endsection
