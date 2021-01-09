@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
<div>
    <div class="row mg-t-10">
        {{ $search_by_invoice_number }}
        <label for="name" style="padding-right: 12px;padding-bottom: 15px;">نوع البحث</label>
        <div class="col-lg-3">
            <label class="rdiobox"><input wire:model="search_type" value="invoice_type" type="radio">
                <span>بحث بنوع الفاتورة</span></label>
        </div>
        <div class="col-lg-3 mg-t-20 mg-lg-t-0">
            <label class="rdiobox"><input wire:model="search_type" value="invoice_number" type="radio">
                <span>بحث برقم الفاتورة</span></label>
        </div>
    </div>
    <div class="row row-sm">
        {{ $search_by_invoice_number }}

        @if ($search_by_invoice_number)
        <div class="form-group col-lg-4">
            <label for="invoice_status">اسم المستخدم<span class="tx-danger">*</span></label>
            <input type="text" name="invoice_status" autofocus
                class="form-control @error('invoice_status') parsley-error @enderror" id="invoice_status"
                placeholder="اسم المستخدم" value="{{ old('invoice_status') }}">
            @error('invoice_status')
            <ul class="parsley-errors-list filled" id="parsley-id-5">
                <li class="parsley-required">{{ $message }}</li>
            </ul>
            @enderror
        </div>
        @else
        @include('components.invoicesReport.reportByInvoicesType')
        @endif
    </div>
    <button type="submit" class="btn btn-primary mt-3 mb-0">بحث</button>
</div>