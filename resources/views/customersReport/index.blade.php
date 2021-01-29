@extends('layouts.master')
@section('title',__('frontend.customers_reports'))
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
@if (config('app.locale') == 'ar')
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@else
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
            <h4 class="content-title mb-0 my-auto">{{ __('frontend.reports') }}</h4><span
                class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.customers_reports') }}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <!--div-->
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">{{ __('frontend.search_information_to_get_invoices') }}</h4>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('customersReport.search') }}" method="POST">
                    @csrf
                    <div class="row row-sm">
                        <div class="form-group col-lg-3">
                            <label for="sectionId">{{ __('frontend.section') }} <span class="tx-danger">*</span></label>
                            <select class="form-control SlectBox" name="section_id" id="sectionId"
                                placeholder="{{ __('frontend.choose_section') }}"
                                style="width: 100%;color: #4d5875; @error('section_id') border-color: red @enderror">
                                <option label="0" value="0">
                                    {{ __('frontend.choose_section') }}
                                </option>
                                @foreach ($sections as $key => $section)
                                <option value="{{ $section->id }}" class="selected_section"
                                    {{ isset($oldInputs['section_id']) && $oldInputs['section_id'] == $section->id ? 'selected' : '' }}>
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
                        <div class="form-group col-lg-3">
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
                        <div class="form-group col-lg-6">
                            <label for="name">{{ __('frontend.date_range') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                                <input name="date_range" type="text" id="fromDate"
                                    {{-- value="{{ isset($oldInputs['date_range']) && $oldInputs['date_range'] == null ? '' : $oldInputs['date_range'] }}"
                                    --}} autocomplete="off" class="form-control fc-daterangepicker">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 mb-0">{{ __('frontend.search') }}</button>
                </form>
            </div>
        </div>
    </div>
    <!--/div-->
    <!--div-->
    @isset($invoices)
    @if($invoices->count() > 0)
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table key-buttons text-md-nowrap" id="example">
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
                                <td>{{ $invoice->section->name }}</td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    @else
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <h3>{{ __('frontend.no_search_results') }} }}</h3>
            </div>
        </div>
    </div>
    @endif
    @endisset
    <!--/div-->
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
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
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
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $(document).ready(function () {
        const oldDateRange = "{{ $oldInputs['date_range'] }}";
        console.log('oldDateRange '+oldDateRange);
        if(oldDateRange == ''){
            $('input[name="date_range"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                autoApply:true
            });

            $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        }else{
            oldDates = oldDateRange.split('-');
            $('input[name="date_range"]').daterangepicker({ startDate: oldDates[0], endDate: oldDates[1] });
        }

    });
</script>

<script>
    $(document).ready(function() {
                $('select[name="product_id"]')[0].sumo.add(0, ' إختر المنتج');
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
                                $('select[name="product_id"]')[0].sumo.add(0, 'إختر');
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
        const oldSectionId = "{{ $oldInputs['section_id'] }}";
        const oldProductId = "{{  $oldInputs['product_id'] }}";
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
                    $('select[name="product_id"]')[0].sumo.add('0', 'إختر المنتج');
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
@endsection
