<div class="form-group col-lg-4">
    <label for="invoice_number">{{ __('frontend.invoice_number') }}<span class="tx-danger">*</span></label>
    <input type="text" name="invoice_number" autofocus wire:
        class="form-control @error('invoice_number') parsley-error @enderror" id="invoice_number"
        placeholder="{{ __('frontend.invoice_number') }}" value="{{ old('invoice_number') }}">
    @error('invoice_number')
    <ul class="parsley-errors-list filled" id="parsley-id-5">
        <li class="parsley-required">{{ $message }}</li>
    </ul>
    @enderror
</div>
