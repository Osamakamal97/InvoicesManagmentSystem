@extends('layouts.master')
@section('css')
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
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
    <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-1">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li class="nav-item"><a href="#tab1" class="nav-link active"
                                                data-toggle="tab">معلومات الفاتورة</a></li>
                                        <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">حالات
                                                الدفع</a></li>
                                        <li class="nav-item"><a href="#tab3" class="nav-link"
                                                data-toggle="tab">المرفقات</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
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
                                                        <td class="tx-right">${{ $invoice->collection_amount }}</td>
                                                        <td class="tx-right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="valign-middle" colspan="2" rowspan="4">
                                                            <div class="invoice-notes">
                                                                <label
                                                                    class="main-content-label tx-13">الملاحظات</label>
                                                                <p style="color: black">{{ $invoice->note }}.</p>
                                                            </div><!-- invoice-notes -->
                                                        </td>
                                                        <td class="tx-right">قيمة الضريبة ({{ $invoice->rate_vat }}%)
                                                        </td>
                                                        <td class="tx-right" colspan="2">${{ $invoice->value_vat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tx-right">مبلغ العمولة</td>
                                                        <td class="tx-right" colspan="2">
                                                            ${{ $invoice->commission_amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tx-right">الخصم</td>
                                                        <td class="tx-right" colspan="2">${{ $invoice->discount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">الإجمالي
                                                            شامل الضريبة</td>
                                                        <td class="tx-right" colspan="2">
                                                            <h4 class="tx-primary tx-bold">${{ $invoice->total }}</h4>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0 text-md-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>رقم الفاتورة</th>
                                                        <th>نوع المنتج</th>
                                                        <th>القسم</th>
                                                        <th>حالة الدفع</th>
                                                        <th>تاريخ الدفع</th>
                                                        <th>ملاحظات</th>
                                                        <th>تاريخ الإضافة</th>
                                                        <th>المستخدم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoice_details as $invoice_detail)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $invoice_detail->invoice_number }}</td>
                                                        <td class="wd-8p">{{ $invoice->product->name }}
                                                        </td>
                                                        <td class="wd-8p">{{ $invoice->section->name }}
                                                        </td>
                                                        <td class="text-center wd-15p">
                                                            @if ($invoice_detail->status == 0)
                                                            <span class="label text-danger d-flex">
                                                                <div class="dot-label bg-danger ml-1"></div>
                                                                {{ $invoice_detail->getStatus() }}
                                                            </span>
                                                            @elseif($invoice_detail->status == 1)
                                                            <span class="label text-success d-flex">
                                                                <div class="dot-label bg-success ml-1"></div>
                                                                {{ $invoice_detail->getStatus() }}
                                                            </span>
                                                            @elseif($invoice_detail->status == 2)
                                                            <span class="label text-warning d-flex">
                                                                <div class="dot-label bg-warning ml-1"></div>
                                                                {{ $invoice_detail->getStatus() }}
                                                            </span>
                                                            @else
                                                            <span class="label text-muted d-flex">
                                                                <div class="dot-label bg-gray-300 ml-1"></div>
                                                                {{ $invoice_detail->getStatus() }}
                                                            </span>
                                                            @endif
                                                        </td>
                                                        <td class="wd-15p">{{ $invoice_detail->payment_date }}</td>
                                                        <td class="wd-30p">{{ Str::words($invoice_detail->note, 15) }}
                                                        </td>
                                                        <td class="wd-15p">{{ $invoice->invoice_date }}</td>
                                                        <td class="wd-15p">{{ $invoice_detail->user->name }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab3">
                                        <div class="card box-shadow-0 ">
                                            <div class="card-header">
                                                <h4 class="card-title mb-1">إضافة مرفقات</h4>
                                            </div>
                                            <div class="card-body pt-0">
                                                <form action="{{ route('invoiceAttachment.store') }}" method="POST"
                                                    data-parsley-validate="" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                                    <input type="hidden" name="invoice_number"
                                                        value="{{ $invoice->invoice_number }}">
                                                    <div class="row row-sm">
                                                        <div class="form-group col-lg-12">
                                                            <label for="invoiceValueVat">المرفقات <span
                                                                    class="tx-danger">* الصيغ المدعومة هي: pdf,
                                                                    jpeg, jpg, png (يمكن إرفاق أكثر من
                                                                    مُرفق)</span></label>
                                                            <input type="file" name="attachments[]" multiple />
                                                            @error('invoice_number')
                                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                                <li class="parsley-required">{{ $message }}</li>
                                                            </ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary mt-3 mb-0">إرسال</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0 text-md-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>رقم الفاتورة</th>
                                                        <th>أضيف بواسطة</th>
                                                        <th>تاريخ الإضافة</th>
                                                        <th>العمليات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoice_attachments as $attachment)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>

                                                        <td>{{ $invoice->invoice_number }}</td>
                                                        <td>{{ $attachment->created_by }}</td>
                                                        <td class="wd-25p">{{ $attachment->created_at }}</td>
                                                        <td class="btn-icon-list">
                                                            <span style="display: none">
                                                                {{ $attachemnt_name = str_replace('storage/app/invoices/'.$invoice->invoice_number.'/', '', $attachment->file_path) }}</span>
                                                            <a href="{{ route('invoiceAttachment.getAttachment' ,[
                                                                'invoice_number'=>$invoice->invoice_number,
                                                                'attachment'=>$attachemnt_name ]) }}"
                                                                class="btn btn-primary btn-sm btn-icon" target="_blank">
                                                                <i class="typcn typcn-eye-outline"></i></a>
                                                            <a href="{{ route('invoiceAttachment.downloadAttachment' ,[
                                                                'invoice_number'=>$invoice->invoice_number,
                                                                'attachment'=>$attachemnt_name,
                                                                ]) }}" class="btn btn-info btn-sm btn-icon"
                                                                target="_blank">
                                                                <i class="typcn typcn-download"></i></a>
                                                            <a href="#deleteModal"
                                                                class="btn btn-danger btn-sm btn-icon"
                                                                data-effect="effect-flip-horizontal" data-toggle="modal"
                                                                data-id="{{ $attachment->id }}">
                                                                <i class="typcn typcn-delete-outline"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">
                    حذف المرفق
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="mg-b-20 mg-x-20"> هل أنت متأكد من حذف المرفق <span id="invoice_name"
                        style="font-weight: bold"></span> ؟</p>
                <form class="form-horizontal" action="{{ route('invoiceAttachment.destroy', 0) }}"
                    id="submit-delete-data" method="POST">
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
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<script>
    $('#deleteModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        document.getElementById('submit-delete-data').action = "{{ route('invoiceAttachment.destroy','') }}/"+id;
    });
</script>
@endsection