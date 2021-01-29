@extends('layouts.master')
@section('title',__('frontend.create_user'))
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
@if (config('app.locale') == 'ar')
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
<!--Internal Sumoselect css-->
@else
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.css')}}">
@endif
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{ route('users.index') }}">{{ __('frontend.users') }}</a>
            </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.create_new_user') }}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">{{ __('frontend.create_new_user') }}</h4>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('users.store') }}" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="is_create" value="true">
                    <div class="row row-sm">
                        <div class="form-group col-lg-6">
                            <label for="name">{{ __('frontend.name') }}<span class="tx-danger">*</span></label>
                            <input type="text" name="name" autofocus
                                class="form-control @error('name') parsley-error @enderror" id="name"
                                placeholder="{{ __('frontend.name') }}" value="{{ old('name') }}">
                            @error('name')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="email">{{ __('frontend.email') }}<span class="tx-danger">*</span></label>
                            <input type="text" name="email" autofocus
                                class="form-control @error('email') parsley-error @enderror" id="email"
                                placeholder="{{ __('frontend.email') }}" value="{{ old('email') }}">
                            @error('email')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-6">
                            <label for="password">{{ __('frontend.password') }}<span class="tx-danger">*</span></label>
                            <input type="text" name="password" autofocus
                                class="form-control @error('password') parsley-error @enderror" id="password"
                                placeholder="{{ __('frontend.password') }}" value="{{ old('password') }}">
                            @error('password')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="passwordConfirmation">{{ __('frontend.confirm_password') }}<span
                                    class="tx-danger">*</span></label>
                            <input type="text" name="password_confirmation" autofocus
                                class="form-control @error('password_confirmation') parsley-error @enderror"
                                id="passwordConfirmation" placeholder="{{ __('frontend.confirm_password') }}"
                                value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-6 mg-b-20 mg-lg-b-0">
                            <p class="mg-b-10">{{ __('frontend.roles') }}</p>
                            <select multiple="multiple" @error('roles') style="border-color: red" @enderror
                                class="testselect2" name="roles[]">
                                @foreach ($roles as $role)
                                <option value="{{ $role }}" @if(old('roles') !=null)
                                    {{ Arr::exists(old('roles'), $role) ? 'selected' : '' }} @endisset>
                                    {{ $role }}
                                </option>
                                @endforeach
                            </select>
                            @error('roles')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form group col-lg-6">
                            <label for="password">{{ __('frontend.user_status') }}<span
                                    class="tx-danger">*</span></label>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label class="rdiobox" for="enable"><input checked name="status" type="radio"
                                            value="1" id="enable"><span>{{ __('frontend.enable') }}</span></label>
                                </div>
                                <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox" for="disable"><input name="status" type="radio" id="disable"
                                            value="0">
                                        <span>{{ __('frontend.disable') }}</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-0">{{ __('frontend.create') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  Form-elements js-->
<script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!-- Internal TelephoneInput js-->
<script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>
@endsection
