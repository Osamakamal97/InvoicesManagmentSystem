@extends('layouts.master')
@section('title','الفواتير')
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
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                قائمة الفواتير</span>
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
                    <h4 class="card-title mg-b-0">الفواتير</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                    <a class="btn btn-outline-primary btn-block" href="{{ route('invoices.create') }}">إنشاء فاتورة
                        جديد</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example2">
                        <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">رقم الفاتورة</th>
                                <th class="wd-10p border-bottom-0">تاريخ الفاتورة</th>
                                <th class="wd-10p border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="wd-5p border-bottom-0">المنتج</th>
                                <th class="wd-5p border-bottom-0">القسم</th>
                                <th class="wd-10p border-bottom-0">الرصيد الكلي</th>
                                <th class="wd-10p border-bottom-0">الحالة</th>
                                <th class="wd-10p border-bottom-0">العمليات</th>
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
                                <td><a href="{{ route('invoiceDetails.index',$invoice->id) }}" style="color: black">
                                        {{ $invoice->section->name }}</a>
                                </td>
                                <td>${{ $invoice->total }}</td>
                                <td class="text-center">
                                    @if ($invoice->status == 0)
                                    <span class="label text-danger d-flex">
                                        <div class="dot-label bg-danger ml-1"></div>{{ $invoice->getStatus() }}
                                    </span>
                                    @elseif($invoice->status == 1)
                                    <span class="label text-success d-flex">
                                        <div class="dot-label bg-success ml-1"></div>{{ $invoice->getStatus() }}
                                    </span>
                                    @elseif($invoice->status == 2)
                                    <span class="label text-warning d-flex">
                                        <div class="dot-label bg-warning ml-1"></div>{{ $invoice->getStatus() }}
                                    </span>
                                    @else
                                    <span class="label text-muted d-flex">
                                        <div class="dot-label bg-gray-300 ml-1"></div>{{ $invoice->getStatus() }}
                                    </span>
                                    @endif
                                </td>
                                <td class="btn-icon-list">
                                    <a href="{{ route('invoices.editStatus' ,$invoice->id) }}"
                                        class="btn btn-info btn-sm btn-icon">
                                        <i class="las la-file-invoice-dollar"></i></a>
                                    <a href="{{ route('invoices.edit' ,$invoice->id) }}"
                                        class="btn btn-warning btn-sm btn-icon">
                                        <i class="typcn typcn-edit"></i></a>
                                    <a href="#deleteModal" class="btn btn-danger btn-sm btn-icon"
                                        data-effect="effect-flip-horizontal" data-toggle="modal"
                                        data-id="{{ $invoice->id }}" data-name="{{ $invoice->name }}">
                                        <i class="typcn typcn-delete-outline"></i></a>
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
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">
                        حذف الفاتورة
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-20 mg-x-20"> هل أنت متأكد من حذف الفاتورة <span id="invoice_name"
                            style="font-weight: bold"></span> ؟</p>
                    <form class="form-horizontal" action="{{ route('invoices.destroy', 0) }}" id="submit-delete-data"
                        method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-danger" type="submit"
                        onclick="event.preventDefault();document.getElementById('submit-delete-data').submit()">حذف</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
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
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js-rtl/table-data.js')}}"></script>
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
    // $('#editModal').on('show.bs.modal', function(event){
    //     var button = $(event.relatedTarget);
    //     var id = button.data('id');
    //     var name = button.data('name');
    //     var description = button.data('description');
    //     var modal = $(this);
    //     modal.find('.modal-body #id').val(id);
    //     modal.find('.modal-body #name').val(name);
    //     modal.find('.modal-body #description').val(description);
    //     document.getElementById('submit-edit-data').action = "{{ route('invoices.update','') }}/"+id;
    // });
    $('#deleteModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var modal = $(this);
        document.getElementById('submit-delete-data').action = "{{ route('invoices.destroy','') }}/"+id;
        document.getElementById('invoice_name').textContent = name;
    });
</script>
@endsection