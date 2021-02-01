<div>
    <label for="invoice_number">{{ __('frontend.invoice_number') }}<span class="tx-danger">*</span></label>
    <input type="text" name="invoice_number" autofocus wire:model="invoice_number"
        class="form-control @error('invoice_number') parsley-error @enderror" id="invoice_number"
        placeholder="{{ __('frontend.invoice_number') }}" value="{{ old('invoice_number') }}">
    @error('invoice_number')
    <ul class="parsley-errors-list filled" id="parsley-id-5">
        <li class="parsley-required">{{ $message }}</li>
    </ul>
    @enderror
    <ul class="select2-results__options" role="tree" style="background-color: gray" aria-expanded="true"
        aria-hidden="false">
        @foreach ($results as $result)
        <li style="padding: 6px 10px;font-size: 0.875rem" role="treeitem" aria-selected="false"
            wire:click="fillInput({{ $result }})"> {{ $result }} </li>
        @endforeach
    </ul>
</div>
