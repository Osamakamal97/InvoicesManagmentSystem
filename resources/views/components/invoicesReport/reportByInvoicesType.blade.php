<div class="form-group col-lg-4">
    <label for="invoice_status">اسم المستخدم<span class="tx-danger">*</span></label>
    <select class="form-control SlectBox" name="section_id" id="sectionId"
        style="width: 100%;color: #4d5875; @error('section_id') border-color: red @enderror">
        <option value="1">الفواتير المدفوعة</option>
        <option value="2">الفواتير المدفوعة جزئياً</option>
        <option value="0">الفواتير الغير مدفوع</option>
    </select>
    @error('invoice_status')
    <ul class="parsley-errors-list filled" id="parsley-id-5">
        <li class="parsley-required">{{ $message }}</li>
    </ul>
    @enderror
</div>
<div class="form-group col-lg-4">
    <label for="name">من تاريخ</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
            </div>
        </div>
        <input name="from_date" placeholder="MM/DD/YYYY" type="text" id="fromDate" value="{{ old('from_date') }}"
            autocomplete="off" class="form-control fc-datepicker">
    </div>
</div>
<div class="form-group col-lg-4">
    <label for="name">إلى تاريخ</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
            </div>
        </div>
        <input name="to_date" placeholder="MM/DD/YYYY" type="text" id="toDate" value="{{ old('to_date') }}"
            autocomplete="off" class="form-control fc-datepicker ">
    </div>
</div>