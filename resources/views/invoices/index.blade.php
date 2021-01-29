@extends('layouts.master')
@section('title', __('frontend.invoices'))
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
{{-- @if (config('app.locale') == 'ar')
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
@else
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.css')}}">
@endif --}}
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
            <h4 class="content-title mb-0 my-auto">
                <a href="{{ route('invoices.index') }}">{{ __('frontend.invoices') }}</a></h4><span
                class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.'.$page_type.'_list') }}</span>
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
                    <h4 class="card-title mg-b-0">{{ __('frontend.invoices') }}</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <div class="row">
                    @can('create_invoice')
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <a class="btn btn-outline-primary btn-block"
                            href="{{ route('invoices.create') }}">{{__('frontend.create_new_invoice')}}</a>
                    </div>
                    @endcan
                    @can('export_invoices_excel')
                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                        <a class="btn btn-outline-primary btn-block" href="{{ route('invoices.export') }}"
                            target="_blank">
                            {{ __('frontend.export_invoices_excel') }}</a>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example2">
                        <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-12p border-bottom-0">{{ __('frontend.invoice_number') }}</th>
                                <th class="wd-12p border-bottom-0">{{ __('frontend.invoice_create_date') }}</th>
                                <th class="wd-12p border-bottom-0">{{ __('frontend.due_date') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('frontend.product') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('frontend.section') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('frontend.total_balance') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('frontend.status') }}</th>
                                <th class="border-bottom-0">{{ __('frontend.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->due_date }}</td>
                                <td>{{ $invoice->product->name }}</td>
                                <td>
                                    @if ($is_archive)
                                    <a href="#" style="color: black"
                                        onclick="event.preventDefault();document.getElementById('invoiceDetails').submit();">
                                        {{ $invoice->section->name }}</a>
                                    <form action="{{ route('archiveInvoiceDetails.index', $invoice->id) }}"
                                        id="invoiceDetails" method="POST" style="display: none">
                                        @csrf
                                        <input type="hidden" name="archive_invoice_id" value="{{ $invoice->id }}">
                                    </form>
                                    @else
                                    <a href="{{ route('invoiceDetails.index', $invoice->id) }}" style="color: black">
                                        {{ $invoice->section->name }}</a>
                                    @endif
                                </td>
                                <td>${{ $invoice->total }}</td>
                                <td class="text-center">
                                    @if ($invoice->status == 0)
                                    <span class="label text-danger d-flex">
                                        {{ $invoice->getStatus() }}
                                    </span>
                                    @elseif($invoice->status == 1)
                                    <span class="label text-success d-flex">
                                        {{ $invoice->getStatus() }}
                                    </span>
                                    @elseif($invoice->status == 2)
                                    <span class="label text-warning d-flex">
                                        {{ $invoice->getStatus() }}
                                    </span>
                                    @else
                                    <span class="label text-muted d-flex">
                                        {{ $invoice->getStatus() }}
                                    </span>
                                    @endif
                                </td>
                                <td class="btn-icon-list">
                                    @if ($is_archive)
                                    @can('unarchive_invoice')
                                    <span data-toggle="tooltip" data-placement="top"
                                        title="{{ __('frontend.cancel_archive_invoices') }}"
                                        style="margin-left: 5px;margin-right: 5px">
                                        <a href="#unarchiveModal" class="btn btn-info btn-sm btn-icon"
                                            data-effect="effect-flip-horizontal" data-toggle="modal"
                                            data-id="{{ $invoice->id }}" data-name="{{ $invoice->invoice_number }}">
                                            <i class="las la-inbox"></i></a>
                                    </span>
                                    @endcan
                                    @can('delete_invoice')
                                    <span data-toggle="tooltip" data-placement="top"
                                        title="{{ __('frontend.delete_invoice_completely') }}">
                                        <a href="#deleteModal" class="btn btn-danger btn-sm btn-icon"
                                            data-effect="effect-flip-horizontal" data-toggle="modal"
                                            data-id="{{ $invoice->id }}" data-name="{{ $invoice->invoice_number }}">
                                            <i class="typcn typcn-delete-outline"></i></a>
                                    </span>
                                    @endcan
                                    @else
                                    @can('edit_invoice_payment_status')
                                    <a href="{{ route('invoices.editStatus' ,$invoice->id) }}"
                                        class="btn btn-primary btn-sm btn-icon"
                                        title="{{ __('frontend.edit_payment_status') }}" data-toggle="tooltip"
                                        data-placement="top">
                                        <i class="las la-file-invoice-dollar"></i></a>
                                    @endcan
                                    @can('edit_invoice')
                                    <a href="{{ route('invoices.edit' ,$invoice->id) }}" data-toggle="tooltip"
                                        data-placement="top" title="{{ __('frontend.edit_invoice') }}"
                                        class="btn btn-warning btn-sm btn-icon">
                                        <i class="typcn typcn-edit"></i></a>
                                    @endcan
                                    @can('archive_invoice')
                                    <span data-toggle="tooltip" data-placement="top"
                                        title="{{ __('frontend.archive_invoice') }}"
                                        style="margin-left: 5px;margin-right: 5px">
                                        <a href="#archiveModal" class="btn btn-info btn-sm btn-icon"
                                            data-effect="effect-flip-horizontal" data-toggle="modal"
                                            data-id="{{ $invoice->id }}" data-name="{{ $invoice->invoice_number }}">
                                            <i class="las la-archive"></i></a>
                                    </span>
                                    @endcan
                                    @can('print_invoice')
                                    <a href="{{ route('invoices.print',$invoice->id) }}"
                                        class="btn btn-light btn-sm btn-icon" data-effect="effect-flip-horizontal"
                                        data-toggle="tooltip" data-placement="top"
                                        title="{{ __('frontend.print_invoice') }}" data-id="{{ $invoice->id }}">
                                        <i class="las la-print"></i></a>
                                    @endcan
                                    @endif
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
    <div class="modal" id="archiveModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('frontend.archive_invoice') }}</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-20 mg-x-20"> {{ __('frontend.are_you_sure_archive_this_invoice') }} <span
                            id="invoice_number_archive" style="font-weight: bold"></span> ؟</p>
                    <form class="form-horizontal" action="{{ route('invoices.archive', 0) }}" id="submit-archive-data"
                        method="POST">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="submit"
                        onclick="event.preventDefault();document.getElementById('submit-archive-data').submit()">{{ __('frontend.archive') }}</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                        type="button">{{ __('frontend.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="unarchiveModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __('frontend.cancel_archive_invoices') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-20 mg-x-20"> {{ __('frontend.are_you_sure_cancel_archive_this_invoice') }} <span
                            id="invoice_number_unarchive" style="font-weight: bold"></span> ؟</p>
                    <form class="form-horizontal" action="{{ route('invoices.unarchive', 0) }}"
                        id="submit-unarchive-data" method="POST">
                        @csrf
                        <input type="hidden" name="invoice_id" id="invoice_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-success" type="submit"
                        onclick="event.preventDefault();document.getElementById('submit-unarchive-data').submit()">
                        {{ __('frontend.cancel_archive') }}
                    </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                        type="button">{{ __('frontend.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ __('frontend.delete_invoice_completely') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-20 mg-x-20"> {{ __('frontend.sure_delete_invoice') }} <span
                            id="invoice_number_delete" style="font-weight: bold"></span> ؟</p>
                    <form class="form-horizontal" action="{{ route('invoices.destroy', 0) }}" id="submit-delete-data"
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
    $('#archiveModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        document.getElementById('submit-archive-data').action = "{{ route('invoices.archive', '') }}/"+id;
        document.getElementById('invoice_number_archive').textContent = name;
    });
    $('#unarchiveModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        document.getElementById('submit-unarchive-data').action = "{{ route('invoices.unarchive','') }}/"+id;
        document.getElementById('invoice_number_unarchive').textContent = name;
        document.getElementById('invoice_id').value = id;
    });
    $('#deleteModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        document.getElementById('submit-delete-data').action = "{{ route('invoices.destroy','') }}/"+id;
        document.getElementById('invoice_number_delete').textContent = name;
    });
</script>
@endsection
