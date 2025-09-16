<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">Edição de Valores</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo o novo valor do treinamento
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">

                                    <label for="Valor" class="form-label">Valor</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">R$</span>
                                        <input wire:model="state.price" x-mask:dynamic="$money($input, ',')" class="form-control">
                                        @error('price')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


{{--                    <div class="modal-footer">--}}
                        <button type="submit" class="btn btn-primary"> Atualizar</button>
{{--                    </div>--}}
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
