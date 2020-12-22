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
                إنشاء فاتورة</span>
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
                <h4 class="card-title mb-1">إنشاء فاتورة</h4>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('invoices.store') }}" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="row row-sm">
                        <div class="form-group col-lg-4">
                            <label for="invoiceNumber">رقم الفاتورة <span class="tx-danger">*</span></label>
                            <input type="text" name="invoice_number"
                                class="form-control @error('invoice_number') parsley-error @enderror" id="invoiceNumber"
                                placeholder="رقم الفاتورة" value="{{ old('invoice_number') }}">
                            @error('invoice_number')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceDate">تاريخ الفاتورة <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input name="invoice_date" placeholder="MM/DD/YYYY" type="text" id="invoiceDate"
                                    value="{{ old('invoice_date') }}"
                                    class="form-control fc-datepicker @error('invoice_date') parsley-error @enderror">
                            </div>
                            @error('invoice_date')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="dueDate">تاريخ الإستحقاق <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input name="due_date" placeholder="MM/DD/YYYY" type="text" id="dueDate"
                                    value="{{ old('due_date') }}"
                                    class="form-control fc-datepicker @error('due_date') parsley-error @enderror">
                            </div>
                            @error('due_date')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-4">
                            <label for="sectionId">القسم <span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox" name="section_id" id="sectionId"
                                placeholder="إختر قسم"
                                style="width: 100%;color: #4d5875; @error('section_id') border-color: red @enderror">
                                <option label="0" value="0">
                                    إختر قسم
                                </option>
                                @foreach ($sections as $key => $section)
                                <option value="{{ $section->id }}" class="selected_section"
                                    {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('section_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="productId">المنتج <span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox products" name="product_id" id="productId"
                                placeholder="إختر منتج"
                                style="width: 100%;color: #222631; @error('product_id') border-color: red @enderror">
                            </select>
                            @error('product_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceCollectionAmount">مبلغ التحصيل </label>
                            <input type="text" name="collection_amount"
                                class="form-control @error('collection_amount') parsley-error @enderror"
                                id="invoiceCollectionAmount" placeholder="مبلغ التحصيل"
                                value="{{ old('collection_amount') }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @error('collection_amount')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-4">
                            <label for="invoiceCommissionAmount">مبلغ العمولة <span class="tx-danger">*</span></label>
                            <input type="text" name="commission_amount"
                                class="form-control @error('commission_amount') parsley-error @enderror"
                                id="commission_amount" placeholder="مبلغ العمولة" value="{{ old('commission_amount') }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @error('commission_amount')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceDiscount">الخصم <span class="tx-danger">*</span></label>
                            <input type="text" name="discount"
                                class="form-control @error('discount') parsley-error @enderror" id="discount"
                                placeholder="الخصم" value="{{ old('discount') }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @error('discount')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="rateVat">نسبة ضريبة الفيمة المضافة <span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox" name="rate_vat" id="rate_VAT" onchange="myFunction()"
                                style="width: 100%;color: #4d5875; @error('rate_vat') border-color: red @enderror">
                                <option label="حدد نسبة الخصم" value="0">
                                    حدد نسبة الخصم
                                </option>
                                <option value="5" {{ old('rate_vat') == '5' ? 'selected' : '' }}>5%</option>
                                <option value="10" {{ old('rate_vat') == '10' ? 'selected' : '' }}>10%
                                </option>
                            </select>
                            @error('rate_vat')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-6">
                            <label for="invoiceValueVat">قيمة ضريبة القيمة المضافة</label>
                            <input type="text" name="value_vat" class="form-control" id="value_VAT"
                                value="{{ old('value_vat') }}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="invoiceTotal">الإجمالي شامل الضريبة</label>
                            <input type="text" name="total" class="form-control " id="total" value="{{ old('total') }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-12">
                            <label for="invoiceValueVat">الملاحظات</label>
                            <textarea class="form-control @error('note') parsley-error @enderror" name="note"
                                placeholder="ملاحظات" rows="3"></textarea>
                            @error('note')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-12">
                            <label for="invoiceValueVat">المرفقات <span class="tx-danger">* الصيغ المدعومة هي: pdf,
                                    jpeg, jpg, png</span></label>
                            <input type="file" class="dropify" data-height="200" name="attachment"/>
                            @error('attachment')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-0">إنشاء</button>
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
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
<script>
    // window.onload = function () {
        const oldInvoiceDate = "{{ old('invoiceDate') }}";
        const toDayDate = $("#invoiceDate").datepicker().datepicker("setDate", new Date());
        // const toDayDate = new Date();  
        let date = new Date();
        console.log(date.getFullYear);
        console.log('old: ' + oldInvoiceDate);
        console.log('today: ' + toDayDate);
        if(date == oldInvoiceDate)
            alert('today is today');
    // };
</script>
<script>
    window.onload = function () {   
        const sectionId = document.getElementById('sectionId').value;
        const oldProductId = "{{ old('product_id') }}";
        if(sectionId != null){
            $.ajax({
                url: "{{ URL::to('section') }}/" + sectionId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    const length = $('select[name="product_id"] option').length;
                    const productSelect = $('select[name="product_id"]')[0];
                    let selectedId = 0;
                    let index = 1;
                    // clear old options
                    for(var i=length; i>=1; i--)
                        $('select[name="product_id"]')[0].sumo.remove(i-1);
                    $('select[name="product_id"]')[0].sumo.add('0', 'إختر المنتج');
                    // $('select[name="product_id"]')[0].sumo.selectItem(0).hidden;

                    $.each(data, function(key, value) {
                        console.log(value);
                        console.log(key == oldProductId);
                        console.log('in: '+value + ' ' + key + ' old ' + oldProductId);
                        if(key == oldProductId){
                            $('select[name="product_id"]')[0].sumo.add(key, value);
                            $('select[name="product_id"]')[0].sumo.selectItem(index);
                            selectedId = key;
                        }else
                            $('select[name="product_id"]')[0].sumo.add(key, value);
                        index++;
                    });
                    // $('select[name="product_id"]')[0].sumo.selectItem(selectedId);
                        // $('select[name="product_id"]')[0].sumo.selectItem(index);
                },
            });

        }
    };
    $(document).ready(function() {
            $('select[id="sectionId"]').on('change', function() {
                var sectionId = $(this).val();
                if (sectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + sectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            const length = $('select[name="product_id"] option').length;
                            // clear old options
                            for(var i=length; i>=1; i--)
                                $('select[name="product_id"]')[0].sumo.remove(i-1);
                            $.each(data, function(key, value) {
                                $('select[name="product_id"]')[0].sumo.add(key, value);
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
    });
</script>

<script>
    function myFunction() {
            var Amount_Commission = parseFloat(document.getElementById("commission_amount").value);
            var Discount = parseFloat(document.getElementById("discount").value);
            var Rate_VAT = parseFloat(document.getElementById("rate_VAT").value);
            var Value_VAT = parseFloat(document.getElementById("value_VAT").value);
            var Amount_Commission2 = Amount_Commission - Discount;
            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {
                alert('يرجي ادخال مبلغ العمولة ');
            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;
                var intResults2 = parseFloat(intResults + Amount_Commission2);
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("value_VAT").value = sumq;
                document.getElementById("total").value = sumt;
            }
        }
</script>
@endsection