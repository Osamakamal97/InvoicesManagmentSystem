@extends('layouts.master')
@section('title',__('frontend.invoice_details'))
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
            <h4 class="content-title mb-0 my-auto">
                <a href="{{ route('invoices.index') }}">{{ __('frontend.invoices') }}</a></h4><span
                class="text-muted mt-1 tx-13 mr-2 mb-0">/
                {{ __('frontend.invoice_details') }}</span>
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
                                                data-toggle="tab">{{ __('frontend.invoice_details') }}</a></li>
                                        <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">
                                                {{ __('frontend.payment_statuses') }}
                                            </a></li>
                                        <li class="nav-item"><a href="#tab3" class="nav-link"
                                                data-toggle="tab">{{ __('frontend.attachments') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="row mg-t-20">
                                            <div class="col-md">
                                                <label
                                                    class="tx-gray-600">{{ __('frontend.create_information') }}</label>
                                                <div class="billed-to">
                                                    <p>{{ __('frontend.create_by') }}: {{ $invoice->user->name }} <br>
                                                        {{ __('frontend.created_at') }} : {{ $invoice->created_at }}<br>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <label class="tx-gray-600">{{ __('frontend.invoice_details') }}</label>
                                                <p class="invoice-info-row">
                                                    <span>{{ __('frontend.invoice_number') }}</span>
                                                    <span>{{ $invoice->invoice_number }}</span></p>
                                                <p class="invoice-info-row">
                                                    <span>{{ __('frontend.invoice_create_date') }}:</span>
                                                    <span>{{ $invoice->invoice_date }}</span></p>
                                                <p class="invoice-info-row"><span>{{ __('frontend.due_date') }}:</span>
                                                    <span>{{ $invoice->due_date }}</span></p>
                                            </div>
                                        </div>
                                        <div class="table-responsive mg-t-40">
                                            <table class="table table-invoice border text-md-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="wd-20p">{{ __('frontend.section') }}</th>
                                                        <th class="wd-40p">{{ __('frontend.product') }}</th>
                                                        <th class="tx-center">{{ __('frontend.status') }}</th>
                                                        <th class="tx-right">{{ __('frontend.collection_amount') }}</th>
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
                                                                    class="main-content-label tx-13">{{ __('frontend.note') }}</label>
                                                                <p style="color: black">{{ $invoice->note }}.</p>
                                                            </div><!-- invoice-notes -->
                                                        </td>
                                                        <td class="tx-right">{{ __('frontend.rate_VAT') }}
                                                            ({{ $invoice->rate_vat }}%)
                                                        </td>
                                                        <td class="tx-right" colspan="2">${{ $invoice->value_vat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tx-right">{{ __('frontend.commission_amount') }}</td>
                                                        <td class="tx-right" colspan="2">
                                                            ${{ $invoice->commission_amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tx-right">{{ __('frontend.discount') }}</td>
                                                        <td class="tx-right" colspan="2">${{ $invoice->discount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">
                                                            {{__('frontend.total_with_discount')}}</td>
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
                                                        <th>{{ __('frontend.invoice_number') }}</th>
                                                        <th>{{ __('frontend.product') }}</th>
                                                        <th>{{ __("frontend.section") }}</th>
                                                        <th>{{ __('frontend.payment_status') }}</th>
                                                        <th>{{ __('frontend.payment_date') }}</th>
                                                        <th>{{ __('frontend.note') }}</th>
                                                        <th>{{ __('frontend.invoice_create_date') }}</th>
                                                        <th>{{ __('frontend.user') }}</th>
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
                                        @can('add_invoice_attachment')
                                        <div class="card box-shadow-0 ">
                                            <div class="card-header">
                                                <h4 class="card-title mb-1">{{ __('frontend.add_attachments') }}</h4>
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
                                                            <label
                                                                for="invoiceValueVat">{{ __('frontend.attachments') }}
                                                                <span class="tx-danger">*
                                                                    {{ __('frontend.supported_formats') }}: pdf,
                                                                    jpeg, jpg, png
                                                                    ({{ __('frontend.can_add_more_than_one') }})</span></label>
                                                            <input type="file" name="attachments[]" multiple />
                                                            @error('invoice_number')
                                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                                <li class="parsley-required">{{ $message }}</li>
                                                            </ul>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary mt-3 mb-0">{{ __('frontend.add') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                        @endcan
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0 text-md-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ __('frontend.invoice_number') }}</th>
                                                        <th>{{ __('frontend.create_by') }}</th>
                                                        <th>{{ __('frontend.invoice_create_date') }}</th>
                                                        <th>{{ __('frontend.operations') }}</th>
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
                                                            @can('show_invoice_attachment')
                                                            <a href="{{ route('invoiceAttachment.get_attachment' ,[
                                                                'invoice_number'=>$invoice->invoice_number,
                                                                'attachment'=>$attachemnt_name ]) }}"
                                                                class="btn btn-primary btn-sm btn-icon" target="_blank">
                                                                <i class="typcn typcn-eye-outline"></i></a>
                                                            @endcan
                                                            @can('download_invoice_attachment')
                                                            <a href="{{ route('invoiceAttachment.download_attachment' ,[
                                                                'invoice_number'=>$invoice->invoice_number,
                                                                'attachment'=>$attachemnt_name,
                                                                ]) }}" class="btn btn-info btn-sm btn-icon"
                                                                target="_blank">
                                                                <i class="typcn typcn-download"></i></a>
                                                            @endcan
                                                            @can('delete_invoice_attachment')
                                                            <a href="#deleteModal"
                                                                class="btn btn-danger btn-sm btn-icon"
                                                                data-effect="effect-flip-horizontal" data-toggle="modal"
                                                                data-id="{{ $attachment->id }}">
                                                                <i class="typcn typcn-delete-outline"></i></a>
                                                            @endcan
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
                    {{ __('frontend.delete_attachemnt') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="mg-b-20 mg-x-20"> {{ __('frontend.sure_delete_attachment') }} <span id="invoice_name"
                        style="font-weight: bold"></span> ؟</p>
                <form class="form-horizontal" action="{{ route('invoiceAttachment.destroy', 0) }}"
                    id="submit-delete-data" method="POST">
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
