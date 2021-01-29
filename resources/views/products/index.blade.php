@extends('layouts.master')
@section('title',__('frontend.products'))
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
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ __('frontend.settings') }}</h4><span
                class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.products') }}</span>
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
                    <h4 class="card-title mg-b-0">{{ __('frontend.products') }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                @can('create_product')
                <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-flip-horizontal"
                        data-toggle="modal" href="#create_modal">{{ __('frontend.create_new_product') }}</a>
                </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example2">
                        <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">{{ __('frontend.name') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('frontend.description') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('frontend.section') }}</th>
                                <th class="wd-5p border-bottom-0">{{ __('frontend.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('frontend.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->section->name }}</td>
                                <td class="text-center">
                                    @if ($product->status == 0)
                                    <span class="label text-danger d-flex">
                                        {{ $product->getStatus() }}
                                    </span>
                                    @else
                                    <span class="label text-success d-flex">
                                        {{ $product->getStatus() }}
                                    </span>
                                    @endif
                                </td>
                                <td class="btn-icon-list">
                                    @can('edit_product')
                                    <a href="#editModal" class="btn btn-warning btn-sm btn-icon"
                                        data-effect="effect-flip-horizontal" data-toggle="modal"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-description="{{ $product->description }}">
                                        <i class="typcn typcn-edit"></i></a>
                                    @endcan
                                    @can('delete_product')
                                    <a href="#deleteModal" class="btn btn-danger btn-sm btn-icon"
                                        data-effect="effect-flip-horizontal" data-toggle="modal"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}">
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
    @can('create_product')
    <div class="modal" id="create_modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __('frontend.create_new_product') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('products.store') }}" id="submit-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="{{ __('frontend.name') }}">
                        </div>
                        <div class="form-group">
                            <p class="mg-b-10">{{ __('frontend.section') }}</p>
                            <select class="form-control SlectBox" name="section_id" style="width: 100%;color: #4d5875">
                                <option label=" {{ __('frontend.choose_section') }}" disabled>
                                    {{ __('frontend.choose_section') }}
                                </option>
                                @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description"
                                placeholder="{{ __('frontend.description') }}"
                                rows="3">{{ old('description') }}</textarea>
                        </div>
                        <input type="hidden" name="created_by" value="gg">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit"
                        onclick="event.preventDefault();document.getElementById('submit-data').submit()">
                        {{ __('frontend.create') }}</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                        type="button">{{ __('frontend.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('edit_product')
    <div class="modal" id="editModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __('frontend.edit_product') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('products.update', 0) }}" id="submit-edit-data"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="{{ __('frontend.name') }}">
                        </div>
                        <div class="form-group">
                            <p class="mg-b-10">{{ __('frontend.section') }}</p>
                            <select class="form-control SlectBox" name="section_id" style="width: 100%;color: #4d5875;">
                                <option label="{{ __('frontend.choose_section') }}" disabled>
                                    {{ __('frontend.choose_section') }}
                                </option>
                                @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description"
                                placeholder="{{ __('frontend.description') }}" id="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit"
                        onclick="event.preventDefault();document.getElementById('submit-edit-data').submit()">{{ __('frontend.edit') }}</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                        type="button">{{ __('frontend.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('delete_product')
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __('frontend.delete_product') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-20 mg-x-20"> {{ __('frontend.sure_delete_product') }} <span id="product_name"
                            style="font-weight: bold"></span> ؟</p>
                    <form class="form-horizontal" action="{{ route('products.destroy', 0) }}" id="submit-delete-data"
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
<script>
    $('#editModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var description = button.data('description');
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #description').val(description);
        document.getElementById('submit-edit-data').action = "{{ route('products.update','') }}/"+id;
    });
    $('#deleteModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        document.getElementById('submit-delete-data').action = "{{ route('products.destroy','') }}/"+id;
        document.getElementById('product_name').textContent = name;
    });
</script>
@endsection
