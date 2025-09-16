<div>
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title fs-14">Gerenciamento de Contratos</h3>
            </div>
            <div class="card-body">
                <p class="card-sub-title text-muted">
                    Insira abaixo as informações do contrato
                </p>

                <form wire:submit="save" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <label class="form-label">Contratante</label>
                                <x-select2 wire:model.live="state.contractor_id" class="form-control form-select select2 select2-show-search">
                                    @foreach($response->contractors as $itemContractor)
                                        <option value="{{$itemContractor['value']}}" @if(isset($contract) && $contract['contractor_id'] == $itemContractor['value']) selected @endif>
                                            {{$itemContractor['label']}}</option>
                                    @endforeach
                                </x-select2>
                                @error('contractor_id')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <label for="E-mail" class="form-label">Nome</label>
                                <input wire:model="state.name" class="form-control @error('email') is-invalid state-invalid @enderror">
                                @error('name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-12 col-xl-9">
                            <div class="form-group">
                                <label for="E-mail" class="form-label">Contrato</label>
                                <input wire:model="state.contract" class="form-control @error('email') is-invalid state-invalid @enderror">
                                @error('contract')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 col-xl-3">
                            <div class="form-group">
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

                    <button type="submit" class="btn btn-primary"> {{$contract ? 'Atualizar' : 'Cadastrar'}} </button>
                </form>
            </div>
        </div>
    </div>

</div>

@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

@endsection
