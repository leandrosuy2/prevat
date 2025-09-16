<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$company ? 'Edição de ' : 'Cadastro de nova '}} Empresa</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo os dados da nova empresa.
                    </p>

                    <form wire:submit="update" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Nome da Empresa</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Cnpj" class="form-label">Cnpj</label>
                                    <input x-mask="99.999.999/9999-99" wire:model="state.employer_number" class="form-control @error('employer_number') is-invalid state-invalid @enderror">
                                    @error('employer_number')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">E-mail</label>
                                    <input type="email" wire:model="state.email" class="form-control @error('email') is-invalid state-invalid @enderror">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">Telefone</label>
                                    <input x-mask="(99) 9 9999-9999" wire:model="state.phone" class="form-control @error('email') is-invalid state-invalid @enderror">
                                    @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <p class="card-sub-title text-muted">
                            Dados do Usuário Principal
                        </p>

                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Nome do Usuário</label>
                                    <input type="text" wire:model="state.user.name" class="form-control @error('user.name') is-invalid state-invalid @enderror">
                                    @error('user.name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">E-mail do Usuário</label>
                                    <input type="email" wire:model="state.user.email" class="form-control @error('user.email') is-invalid state-invalid @enderror">
                                    @error('user.email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Senha do Usuário</label>
                                    <div class="input-group"  x-data="{ show: true }">
                                        <input :type="show ? 'password' : 'text'"  wire:model="state.user.password" class="form-control @error('user.password') is-invalid state-invalid @enderror">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fe text-white" :class="{'fe-eye': !show, 'fe-eye-off':show }" id="eyeOpen" @click="show = !show" ></i>
                                        </button>
                                        @error('user.password')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="place-top-left" class="form-label">Telefone do Usuário</label>
                                    <input wire:model="state.user.phone" x-mask="(99) 9 9999-9999" class="form-control @error('user.phone') is-invalid state-invalid @enderror">
                                    @error('user.phone')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="place-top-right" class="form-label">Documento do Usuario</label>
                                    <input wire:model="state.user.document" x-mask="999.999.999-99" class="form-control @error('user.document') is-invalid state-invalid @enderror">
                                    @error('user.document')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <p class="card-sub-title text-muted">
                                Endereço da Empresa.
                            </p>

                            <div class="row">
                                <div class="col-md-12 col-xl-4">
                                    <div class="form-group">
                                        <label class="form-label">Cep</label>
                                        <div class="input-group">
                                            <input x-mask="99999-999"  wire:model="state.zip_code" class="form-control @error('zip_code') is-invalid state-invalid @enderror">
                                            <button type="button" class="btn btn-primary btn-icon" wire:click.prevent="getAddress()"  wire:loading.class="btn-loading p-4 ">
                                                <i wire:target="getAddress()" wire:loading.remove class="fe fe-search text-white" ></i>
                                            </button>
                                            @error('zip_code')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group">
                                        <label for="Endereço" class="form-label">Endereço</label>
                                        <input wire:model.live="state.address" class="form-control @error('address') is-invalid state-invalid @enderror">
                                        @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-2">
                                    <div class="form-group">
                                        <label for="Número" class="form-label">Número</label>
                                        <input wire:model="state.number" class="form-control @error('number') is-invalid state-invalid @enderror">
                                        @error('number')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <label for="Complemento" class="form-label">Complemento</label>
                                        <input wire:model.live="state.complement" class="form-control @error('complement') is-invalid state-invalid @enderror">
                                        @error('complement')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-4">
                                    <div class="form-group">
                                        <label for="Bairro" class="form-label">Bairro</label>
                                        <input wire:model.live="state.neighborhood" class="form-control @error('neighborhood') is-invalid state-invalid @enderror">
                                        @error('neighborhood')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <label for="Cidade" class="form-label">Cidade</label>
                                        <input wire:model.live="state.city" class="form-control @error('city') is-invalid state-invalid @enderror">
                                        @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-1">
                                    <div class="form-group">
                                        <label for="Estado" class="form-label">Estado</label>
                                        <input wire:model.live="state.uf" class="form-control @error('uf') is-invalid state-invalid @enderror">
                                        @error('uf')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"> {{$company ? 'Atualizar' : 'Cadastrar'}}</button>
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


    <script>
@endsection
