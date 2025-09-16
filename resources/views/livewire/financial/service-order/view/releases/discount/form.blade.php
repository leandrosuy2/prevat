<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">Adicionar Desconto</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo o valor do desconto :
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label class="form-label">Tipo</label>
                                    <select wire:model.live="state.type"  class="form-select">
                                        <option value="">Escolha</option>
                                        <option value="value">Valor</option>
                                        <option value="percentage">Porcentagem</option>
                                    </select>
                                    @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-7">
                                <div class="form-group">
                                    <label for="Valor" class="form-label">Valor</label>
                                    <div class="input-group has-validation">
                                        @if($state['type'] == 'value')
                                        <span class="input-group-text" id="inputGroupPrepend">R$</span>
                                        @else
                                        <span class="input-group-text" id="inputGroupPrepend">%</span>
                                        @endif
                                        <input wire:model="state.value" x-mask:dynamic="$money($input, ',')" class="form-control">
                                        @error('value')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{--                    <div class="modal-footer">--}}
                        <button type="submit" class="btn btn-primary"> Atualizar </button>
                        {{--                    </div>--}}
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
