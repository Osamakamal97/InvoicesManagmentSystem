@extends('layouts.master')
@section('title','إنشاء فاتورة')
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                تعديل فاتورة</span>
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
                <form action="{{ route('invoices.updateStatus', $invoice->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="row row-sm">
                        <div class="form-group col-lg-4">
                            <label for="invoiceNumber">رقم الفاتورة </label>
                            <input type="text" class="form-control" value="{{ $invoice->invoice_number }}" readonly>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceDate">تاريخ الفاتورة </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input type="text" value="{{ $invoice->invoice_date}}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="dueDate">تاريخ الإستحقاق </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input type="text" value="{{ $invoice->due_date }}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-4">
                            <label for="sectionId">القسم </label>
                            <input type="text" value="{{ $invoice->section->name  }}" class="form-control" readonly>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="productId">المنتج </label>
                            <input type="text" value="{{ $invoice->product->name  }}" class="form-control" readonly>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceCollectionAmount">مبلغ التحصيل </label>
                            <input type="text" class="form-control" id="invoiceCollectionAmount"
                                value="{{ $invoice->collection_amount  }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                readonly>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-4">
                            <label for="invoiceCommissionAmount">مبلغ العمولة </label>
                            <input type="text" class="form-control" id="commission_amount"
                                value="{{ $invoice->commission_amount  }}" readonly>
                            @error('commission_amount')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceDiscount">الخصم </label>
                            <input type="text" class="form-control " id="discount" value="{{  $invoice->discount }}"
                                readonly>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="rateVat">نسبة ضريبة الفيمة المضافة </label>
                            <input type="text" value="%{{ $invoice->rate_vat }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-6">
                            <label for="invoiceValueVat">قيمة ضريبة القيمة المضافة</label>
                            <input type="text" class="form-control" id="value_VAT" value="{{  $invoice->value_vat }}"
                                readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="invoiceTotal">الإجمالي شامل الضريبة</label>
                            <input type="text" class="form-control " id="total" value="{{ $invoice->total }}" readonly>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-12">
                            <label for="invoiceValueVat">الملاحظات</label>
                            <textarea class="form-control" placeholder="ملاحظات" readonly
                                rows="3">{{ $invoice->note }}</textarea>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-6">
                            <label for="status">حالة الدفع<span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox" id="status" name="status"
                                style="width: 100%;color: #4d5875; @error('status') border-color: red @enderror">
                                {{-- <option label="حالة الدفع" value="33">
                                    حالة الدفع
                                </option> --}}
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>مدفوعة</option>
                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>مدفوعة جزئياً</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>غير مدفوعة</option>
                            </select>
                            @error('status')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="paymentDate">تاريخ الدفع <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input name="payment_date" placeholder="MM/DD/YYYY" type="text" id="paymentDate"
                                    value="{{ old('payment_date') == null ? now() : ''}}" autocomplete="off"
                                    class="form-control fc-datepicker @error('payment_date') parsley-error @enderror">
                            </div>
                            @error('payment_date')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
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
<!--Internal Fileuploads js-->
<script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
<!--Internal Fancy uploader js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<!--Internal  Form-elements js-->
<script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<script>
    const oldPaymentDate = "{{ old('payment_date') }}";
    let date = new Date();
    let selectedDate = (date.getMonth()+1) + '/' + date.getDate() +'/' +date.getFullYear();
    if(selectedDate == oldPaymentDate || oldPaymentDate == '')
        $("#paymentDate").datepicker().datepicker("setDate", new Date());   
    else
        $("#paymentDate").datepicker().datepicker("setDate", oldPaymentDate);
</script>
@endsection