@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                عرض الصلاحيات</span>
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
            </div>
            <div class="card-body pt-0">
                <div class="row row-sm">
                    <div class="form-group col-lg-12">
                        <h4>اسم الدور: {{ $role->name }}</h4>
                    </div>
                </div>
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                    <h4>الصلاحيات: </h4><br>
                    <div class="row">
                        @foreach ($rolePermissions as $permission)
                        <div class="col-lg-3 mg-t-15" style="font-size: 16px">
                            {{$permission->name}}
                        </div>
                        @endforeach
                    </div>
                </div>
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