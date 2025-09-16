<div>
    <div class="card border-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="form-group">
                        <label for="Busca" class="form-label">Busca</label>
                        <input wire:model.live.debounce.250ms="filter.search" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
