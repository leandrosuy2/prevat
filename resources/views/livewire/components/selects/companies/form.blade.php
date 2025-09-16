<div class="d-flex align-items-center">
    <label for="company_id" class="form-label text-nowrap me-2 mb-0">Empresa:</label>
    <div style="min-width: 200px;">
        <select wire:model.live="company_id" class="form-control form-select form-select-sm"
                data-placeholder="Escolha uma empresa">
            @foreach($response->companies as $itemCompany)
                <option value="{{ $itemCompany['value'] }}" @if(isset($company_id) && $company_id == $itemCompany['value']) selected @endif>{{ $itemCompany['label'] }}</option>
            @endforeach
        </select>
    </div>
</div>
