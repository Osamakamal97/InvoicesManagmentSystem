@extends('layouts.master')
@section('css')
<style>
    @media print{
        #printButton{
            display: none;
        }
    }
</style>
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                تفاصيل الفاتورة</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">
    <div class="col-md-12 col-xl-12">
        <div class=" main-content-body-invoice" id="printContent">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        <h1 class="invoice-title">فاتورة التحصيل</h1>
                        <p>201 Something St., Something Town, YT 242, Country 6546<br>
                            Tel No: 324 445-4544<br>
                            Email: youremail@companyname.com</p>
                    </div><!-- invoice-header -->
                    <div class="row mg-t-20">
                        <div class="col-md">
                            <label class="tx-gray-600">بيانات الاضافة</label>
                            <div class="billed-to">
                                <p>أُضيفت بواسطة: {{ $invoice->user->name }} <br>
                                    تم إضافتها في : {{ $invoice->created_at }}<br></p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label class="tx-gray-600">بيانات الفاتورة</label>
                            <p class="invoice-info-row"><span>رقم الفاتورة</span>
                                <span>{{ $invoice->invoice_number }}</span></p>
                            <p class="invoice-info-row"><span>تاريخ الإصدار:</span>
                                <span>{{ $invoice->invoice_date }}</span></p>
                            <p class="invoice-info-row"><span>تاريخ الاستحقاق:</span>
                                <span>{{ $invoice->due_date }}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-20p">القسم</th>
                                    <th class="wd-40p">المنتج</th>
                                    <th class="tx-center">الحالة</th>
                                    <th class="tx-right">مبلغ التحصيل</th>
                                    <th class="tx-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->section->name }}</td>
                                    <td>{{ $invoice->product->name }}</td>
                                    <td>{{ $invoice->getStatus() }}</td>
                                    <td class="tx-right">${{ number_format($invoice->collection_amount) }}</td>
                                    <td class="tx-right"></td>
                                </tr>
                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13">الملاحظات</label>
                                            <p style="color: black">{{ $invoice->note }}.</p>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right">قيمة الضريبة ({{ number_format($invoice->rate_vat) }}%)</td>
                                    <td class="tx-right" colspan="2">${{ number_format($invoice->value_vat,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">مبلغ العمولة</td>
                                    <td class="tx-right" colspan="2">${{ number_format($invoice->commission_amount,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tx-right">الخصم</td>
                                    <td class="tx-right" colspan="2">${{ number_format($invoice->discount,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">الإجمالي شامل الضريبة</td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">${{ number_format($invoice->total,2) }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mg-b-40">
                    {{-- <a class="btn btn-purple float-left mt-3 mr-2" href="">
                        <i class="mdi mdi-currency-usd ml-1"></i>Pay Now
                    </a> --}}
                    <a href="#printPDF" id="printButton" class="btn btn-danger float-left mt-3 mr-2" onclick="printPDF()">
                        <i class="mdi mdi-printer ml-1"></i>Print
                    </a>
                    {{-- <a href="#" class="btn btn-success float-left mt-3">
                        <i class="mdi mdi-telegram ml-1"></i>Send Invoice
                    </a> --}}
                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script>
    function printPDF() {
        const printContent = document.getElementById('printContent').innerHTML;
        const printButton = document.getElementById('printButton');
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection