@extends('layouts.master')
@section('title', __('frontend.create_invoice'))
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
@if (config('app.locale') == 'ar')
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@else
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
@endif
<style>
    .ff_fileupload_wrap table.ff_fileupload_uploads td.ff_fileupload_actions button.ff_fileupload_start_upload {
        display: none;
    }
</style>
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">
                <a href="{{ route('invoices.index') }}">{{ __('frontend.invoices') }}</a></h4><span
                class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.create_invoice') }}</span>
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
                <h4 class="card-title mb-1">{{ __('frontend.create_invoice') }}</h4>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('invoices.store') }}" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="row row-sm">
                        <div class="form-group col-lg-4">
                            <label for="invoiceNumber">{{ __('frontend.invoice_number') }} <span
                                    class="tx-danger">*</span></label>
                            <input type="text" name="invoice_number" autofocus
                                class="form-control @error('invoice_number') parsley-error @enderror" id="invoiceNumber"
                                placeholder="{{ __('frontend.invoice_number') }}" value="{{ old('invoice_number') }}">
                            @error('invoice_number')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceDate">{{ __('frontend.invoice_create_date') }} <span
                                    class="tx-danger">*</span></label>
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
                            <label for="dueDate">{{ __('frontend.due_date') }} <span class="tx-danger">*</span></label>
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
                            <label for="sectionId">{{ __('frontend.section') }} <span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox" name="section_id" id="sectionId"
                                placeholder="{{ __('frontend.choose_section') }}"
                                style="width: 100%;color: #4d5875; @error('section_id') border-color: red @enderror">
                                <option label="0" value="0">
                                    {{ __('frontend.choose_section') }}
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
                            <label for="productId">{{ __('frontend.product') }} <span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox products" name="product_id" id="productId"
                                placeholder="{{ __('frontend.choose_product') }}"
                                style="width: 100%;color: #222631; @error('product_id') border-color: red @enderror">
                            </select>
                            @error('product_id')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceCollectionAmount">{{ __('frontend.collection_amount') }} </label>
                            <input type="text" name="collection_amount"
                                class="form-control @error('collection_amount') parsley-error @enderror"
                                id="invoiceCollectionAmount" placeholder="{{ __('frontend.enter_collection_amount') }}"
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
                            <label for="invoiceCommissionAmount">{{ __('frontend.commission_amount') }} <span
                                    class="tx-danger">*</span></label>
                            <input type="text" name="commission_amount"
                                class="form-control @error('commission_amount') parsley-error @enderror"
                                id="commission_amount" placeholder="{{ __('frontend.enter_commission_amount') }}"
                                value="{{ old('commission_amount') }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            @error('commission_amount')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="invoiceDiscount">{{ __('frontend.discount') }} <span
                                    class="tx-danger">*</span></label>
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
                            <label for="rateVat">{{ __('frontend.rate_VAT') }} <span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox" name="rate_vat" id="rate_VAT" onchange="myFunction()"
                                style="width: 100%;color: #4d5875; @error('rate_vat') border-color: red @enderror"
                                placeholder="{{ __('frontend.choose_rate_VAT') }}">
                                <option label="" value="0">
                                    {{ __('frontend.choose_rate_VAT') }}
                                </option>
                                <option value="5" {{ old('rate_vat') == '5' ? 'selected' : '' }}>5%</option>
                                <option value="10" {{ old('rate_vat') == '10' ? 'selected' : '' }}>10%</option>
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
                            <label for="invoiceValueVat">{{ __('frontend.value_VAT') }}</label>
                            <input type="text" name="value_vat" class="form-control" id="value_VAT"
                                value="{{ old('value_vat') }}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="invoiceTotal">{{ __('frontend.total_with_discount') }}</label>
                            <input type="text" name="total" class="form-control " id="total" value="{{ old('total') }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-12">
                            <label for="invoiceValueVat">{{ __('frontend.note') }}</label>
                            <textarea class="form-control @error('note') parsley-error @enderror" name="note"
                                placeholder="{{ __('frontend.note') }}" rows="3"></textarea>
                            @error('note')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group col-lg-12">
                            <label for="invoiceValueVat">{{ __('frontend.attachments') }} <span class="tx-danger">*
                                    {{ __('frontend.supported_formats') }}: pdf,
                                    jpeg, jpg, png</span></label>
                            <input type="file" class="dropify" data-height="200" name="attachments[]" multiple />
                            @error('attachment')
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $message }}</li>
                            </ul>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-0">{{ __('frontend.create') }}</button>
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
    const oldInvoiceDate = "{{ old('invoice_date') }}";
    let date = new Date();
    let selectedDate = (date.getMonth()+1) + '/' + date.getDate() +'/' +date.getFullYear();
    if(selectedDate == oldInvoiceDate || oldInvoiceDate == '')
        $("#invoiceDate").datepicker().datepicker("setDate", new Date());
    else
        $("#invoiceDate").datepicker().datepicker("setDate", oldInvoiceDate);
</script>
<script>
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
    window.onload = function () {
        const oldSectionId = "{{ old('section_id') }}";
        console.log('old section id:' + oldSectionId);
        const oldProductId = "{{ old('product_id') }}";
        console.log('old prodcut id:' + oldProductId);
        if(oldSectionId != null){
            $.ajax({
                url: "{{ URL::to('section') }}/" + oldSectionId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    const length = $('select[name="product_id"] option').length;
                    let index = 1;
                    // clear old options
                    for(var i=length; i>=1; i--)
                        $('select[name="product_id"]')[0].sumo.remove(i-1);
                    // $('select[name="product_id"]')[0].sumo.add('0', 'إختر المنتج');
                    $('select[name="product_id"]')[0].sumo.add('0', '{{ __('frontend.chooser_product') }}');
                    $.each(data, function(key, value) {
                        $('select[name="product_id"]')[0].sumo.add(key, value);
                        if(key == oldProductId)
                            $('select[name="product_id"]')[0].sumo.selectItem(index);
                        index++;
                    });
                },
            });
        }
    };
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
