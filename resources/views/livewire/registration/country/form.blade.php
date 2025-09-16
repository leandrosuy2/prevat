<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$country ? 'Edição de ' : 'Cadastro de novo '}} Município</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo as informações do Treinamento
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-2">
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
{{--                                    <span class="col-auto align-self-center">--}}
{{--                                                                <span class="form-help" data-bs-toggle="popover"--}}
{{--                                                                      data-bs-placement="top" data-bs-content="<p>ZIP Code must be US or CDN format. You can use an extended ZIP+4 code to determine address more accurately.</p>--}}
{{--                                                                <p class='mb-0'><a href=''>USP ZIP codes lookup tools</a></p>--}}
{{--                                                                " data-bs-original-title="" title="">?</span>--}}
{{--                                                            </span>--}}
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-5">
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


                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <x-select2 wire:model="state.status" placeholder="Select Members" class=" select2 form-select">
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



                        <button type="submit" class="btn btn-primary"> {{$country ? 'Atualizar' : 'Cadastrar'}}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>

    <!-- MODAL JS -->
    @vite('resources/assets/js/modal.js')

@endsection



