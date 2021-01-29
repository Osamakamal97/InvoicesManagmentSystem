@extends('layouts.master')
@section('title',__('frontend.edit_role'))
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{ route('roles.index') }}">{{ __('frontend.users') }}</a>
            </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.edit_role') }}</span>
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
                <h4 class="card-title mb-1">{{ __('frontend.edit_role') }}</h4>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('roles.update' ,$role->id) }}" method="POST" data-parsley-validate="">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="form-group col-lg-12">
                            <label for="name">{{ __('frontend.name') }}<span class="tx-danger">*</span></label>
                            <input type="text" name="name" autofocus
                                class="form-control @error('name') parsley-error @enderror" id="name"
                                placeholder="{{ __('frontend.name') }}"
                                value="{{ old('name') == '' ? $role->name : old('name') }}">
                            @error('name')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <label for="password">{{ __('frontend.permissions') }}<span class="tx-danger">*</span></label>
                        <div class="row" @error('permissions') style="border: 1px solid red;padding-bottom:10px"
                            @enderror>
                            @foreach ($permissions as $permission)
                            <div class="col-lg-4 mg-t-15">
                                <label class="ckbox">
                                    <input type="checkbox"
                                        {{ Arr::exists($rolePermissions, $permission->id) ? 'checked' : '' }}
                                        name="permissions[{{ $permission->name }}]"><span>{{$permission->name}}</span></label>
                            </div>
                            @endforeach
                        </div>
                        @error('permissions')
                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-0">{{ __('frontend.edit') }}</button>
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
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
@endsection
