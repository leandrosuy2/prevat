<div class="d-flex col-md-12 col-xl-3 align-items-center">
    <label for="firstName" class="col-md-6 form-label text-nowrap mt-2">Contratos</label>
    <div class="col-md-12">

        <select wire:model.live="contract_id" class="form-control form-select form-select-sm"
                data-placeholder="Choose one">
            @foreach($response->contracts as $itemContract)
                <option value="{{ $itemContract['value'] }}" @if(isset($contract_id) && $contract_id == $itemContract['value']) selected @endif>{{ $itemContract['label'] }}</option>

            @endforeach
        </select>

    </div>
</div>
