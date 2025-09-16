<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$contact ? 'Edição de ' : 'Cadastro de nova '}} Contato</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo as informações
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label for="Nome do Categoria" class="form-label">Nome</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="Nome do Categoria" class="form-label">Whatsapp 01</label>
                                    <input x-mask="(99) 9 9999-9999" wire:model="state.whatsapp01" class="form-control">
                                    @error('whatsapp01')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="Nome do Categoria" class="form-label">Whatsapp 02</label>
                                    <input -mask="(99) 9 9999-9999" wire:model="state.whatsapp02" class="form-control">
                                    @error('whatsapp02')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Nome do Categoria" class="form-label">Email 01</label>
                                    <input type="email" wire:model="state.email01" class="form-control">
                                    @error('email01')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Nome do Categoria" class="form-label">Email 02</label>
                                    <input type="email" wire:model="state.email02" class="form-control">
                                    @error('email02')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <button type="submit" class="btn btn-primary"> {{$contact ? 'Atualizar' : 'Cadastrar'}}</button>
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
@endsection
