@extends('layouts.master')
@section('title',__('frontend.roles'))
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{ route('roles.index') }}">{{ __('frontend.users') }}</a></h4><span
                class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.roles_and_permissions') }}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <!--div-->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ __('frontend.roles') }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                    @can('create_role')
                    <a class="btn btn-outline-primary btn-block" data-effect="effect-flip-horizontal"
                        href="{{ route('roles.create') }}">{{ __('frontend.create_new_role') }}</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example2">
                        <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="border-bottom-0">{{ __('frontend.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('frontend.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="btn-icon-list">
                                    @can('show_role')
                                    <a href="{{ route('roles.show',$role->id) }}"
                                        class="btn btn-success btn-sm btn-icon">
                                        <i class="typcn typcn-eye"></i></a>
                                    @endcan
                                    @can('edit_role')
                                    <a href="{{ route('roles.edit',$role->id) }}"
                                        class="btn btn-warning btn-sm btn-icon">
                                        <i class="typcn typcn-edit"></i></a>
                                    @endcan
                                    @can('delete_role')
                                    <a href="#deleteModal" class="btn btn-danger btn-sm btn-icon"
                                        data-effect="effect-flip-horizontal" data-toggle="modal"
                                        data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                        <i class="typcn typcn-delete-outline"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    <!--/div-->
    <!-- Modal effects -->
    @can('delete_role')
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __('frontend.delete_role') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-20 mg-x-20"> {{ __('frontend.sure_delete_role') }} <span id="role_name"
                            style="font-weight: bold"></span> ؟</p>
                    <form class="form-horizontal" action="{{ route('roles.destroy', 0) }}" id="submit-delete-data"
                        method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-danger" type="submit"
                        onclick="event.preventDefault();document.getElementById('submit-delete-data').submit()">{{ __('frontend.delete') }}</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                        type="button">{{ __('frontend.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    @endcan
    <!-- End Modal effects-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
@if (config('app.locale') == 'ar')
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js-rtl/table-data.js')}}"></script>
@else
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endif
<script>
    $('#deleteModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        document.getElementById('submit-delete-data').action = "{{ route('roles.destroy','') }}/"+id;
        document.getElementById('role_name').textContent = name;
    });
</script>
@endsection
