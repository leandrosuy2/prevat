<div class="d-flex align-items-center">
    <label for="contractor_id" class="form-label text-nowrap me-2 mb-0">Contratante:</label>
    <div style="min-width: 200px;">
        <select wire:model.live="contractor_id" class="form-control form-select form-select-sm"
                data-placeholder="Escolha um contratante">
            @foreach($response->contractors as $itemContract)
                <option value="{{ $itemContract['value'] }}" @if(isset($contract_id) && $contract_id == $itemContract['value']) selected @endif>{{ $itemContract['label'] }}</option>
            @endforeach
        </select>
    </div>
</div>
