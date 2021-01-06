@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                تعديل الصلاحيات</span>
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
                <h4 class="card-title mb-1">تعديل فاتورة</h4>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('roles.update' ,$role->id) }}" method="POST" data-parsley-validate="">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="form-group col-lg-12">
                            <h4>اسم الدور: {{ $role->name }}</h4>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <h4>الصلاحيات: </h4><br>
                        <div class="row" @error('permissions') style="border: 1px solid red;padding-bottom:10px"
                            @enderror>
                            @foreach ($rolePermissions as $permission)
                            <div class="col-lg-3 mg-t-15" style="font-size: 16px">
                                {{$permission->name}}
                            </div>
                            @endforeach
                        </div>
                        @error('permissions')
                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                            <li class="parsley-required">{{ $message }}</li>
                        </ul>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-0">تعديل</button>
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