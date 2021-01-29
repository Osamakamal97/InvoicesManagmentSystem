@extends('layouts.master')
@section('title',__('frontend.users'))
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<!---Internal Owl Carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
@if (config('app.locale') == 'ar')
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@else
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.css')}}">
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
@endif
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{ route('users.index') }}">{{ __('frontend.users') }}</a>
            </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.users_list') }}</span>
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
                    <h4 class="card-title mg-b-0">{{ __('frontend.users') }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <div class="row">
                    @can('create_user')
                    <div class="col-sm-6 col-md-6 col-xl-3 mg-t-20">
                        <a class="btn btn-outline-primary btn-block" href="{{ route('users.create') }}">
                            {{ __('frontend.create_new_user') }}
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example2">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{ __('frontend.name') }}</th>
                                <th class="border-bottom-0">{{ __('frontend.email') }}</th>
                                <th class="border-bottom-0">{{ __('frontend.role') }}</th>
                                <th class="border-bottom-0">{{ __('frontend.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('frontend.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $role)
                                    {{ $role }}
                                    @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($user->status == 0)
                                    <span class="label text-danger d-flex">
                                        {{ $user->getStatus() }}
                                    </span>
                                    @else
                                    <span class="label text-success d-flex">
                                        {{ $user->getStatus() }}
                                    </span>
                                    @endif
                                </td>
                                <td class="btn-icon-list " style="float: left">
                                    @can('edit_user')
                                    <a href="{{ route('users.edit' ,$user->id) }}" data-toggle="tooltip"
                                        data-placement="top" title="{{ __('frontend.edit_user') }}"
                                        class="btn btn-warning btn-sm btn-icon">
                                        <i class="typcn typcn-edit"></i></a>
                                    @endcan
                                    @can('delete_user')
                                    <span data-toggle="tooltip" data-placement="top" class="operations-buttons"
                                        title="{{ __('frontend.delete_user_completely') }}">
                                        <a href="#deleteModal" class="btn btn-danger btn-sm btn-icon"
                                            data-effect="effect-flip-horizontal" data-toggle="modal"
                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                            <i class="typcn typcn-delete-outline"></i></a>
                                    </span>
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
    @can('create_user')
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __('frontend.delete_user') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-20 mg-x-20"> {{ __('frontend.sure_delete_user') }} <span id="user_number_delete"
                            style="font-weight: bold"></span> ؟</p>
                    <form class="form-horizontal" action="{{ route('users.destroy', 0) }}" id="submit-delete-data"
                        method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-danger" type="submit"
                        onclick="event.preventDefault();document.getElementById('submit-delete-data').submit()">{{ __('frontend.sure_delete_attachment') }}</button>
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
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@if (config('app.locale') == 'ar')
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js-rtl/table-data.js')}}"></script>
@else
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endif
{{-- for select2 from form-elements --}}
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!--Internal  Form-elements js-->
<script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
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
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
<script>
    $('#deleteModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        document.getElementById('submit-delete-data').action = "{{ route('users.destroy','') }}/"+id;
        document.getElementById('user_number_delete').textContent = name;
    });
</script>
@endsection
