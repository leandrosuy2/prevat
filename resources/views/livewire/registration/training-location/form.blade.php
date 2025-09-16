<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$trainingLocation ? 'Edição de ' : 'Cadastro de novo '}} Local de Treinamento</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo as informações do Treinamento
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="Sigla" class="form-label">Sigla</label>
                                    <input type="text" wire:model="state.acronym" class="form-control">
                                    @error('acronym')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-8">
                                <div class="form-group">
                                    <label for="Nome do Treinamento" class="form-label">Nome do Local Treinamento</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <x-select2 wire:model="state.status"  class=" select2 form-select">
                                        <option value="">Escolha</option>
                                        <option value="Ativo">Ativo</option>
                                        <option value="Inativo">Inativo</option>
                                    </x-select2>

                                    @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <p class="card-sub-title text-muted">
                            Endereço do Local.
                        </p>

                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Cep</label>
                                    <div class="input-group">
                                        <input x-mask="99999-999"  wire:model="state.zip-code" class="form-control">
                                            <button type="button" class="btn btn-primary btn-icon" wire:click="getAddress()"  wire:loading.class="btn-loading p-4">
                                                <i wire:loading.remove class="fe fe-search text-white" ></i>
                                            </button>
                                        @error('zip-code')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <label for="Endereço" class="form-label">Endereço</label>
                                    <input wire:model.live="state.address" class="form-control">
                                    @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="Número" class="form-label">Número</label>
                                    <input wire:model="state.number" class="form-control">
                                    @error('number')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Bairro" class="form-label">Bairro</label>
                                    <input wire:model.live="state.neighborhood" class="form-control">
                                    @error('neighborhood')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Complemento" class="form-label">Complemento</label>
                                    <input wire:model.live="state.complement" class="form-control">
                                    @error('complement')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Cidade" class="form-label">Cidade</label>
                                    <input wire:model.live="state.city" class="form-control">
                                    @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-1">
                                <div class="form-group">
                                    <label for="Estado" class="form-label">Estado</label>
                                    <input wire:model.live="state.uf" class="form-control">
                                    @error('uf')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-primary"> {{$trainingLocation ? 'Atualizar' : 'Cadastrar'}}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')


    {{--    <script>--}}
    {{--        $(document).ready(function () {--}}
    {{--            $('#select2').select2();--}}
    {{--            $('#select2').on('change', function (e) {--}}
    {{--                var data = $('#select2').select2("val");--}}

    {{--            @this.set('selected', data);--}}

    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection



