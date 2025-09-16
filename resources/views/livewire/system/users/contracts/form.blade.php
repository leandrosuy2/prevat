<div>
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title fs-14">Gerenciamento de Contratos do usuário : {{$user['name']}}</h3>
            </div>
            <div class="card-body">
                <p class="card-sub-title text-muted">
                    Escolha o Contrato Abaixo
                </p>

                <form wire:submit="save" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <label class="form-label">Contrato</label>
                                <x-select2 wire:model="state.contract_id" class="form-control form-select select2 select2-show-search">
                                    @foreach($response->contracts as $itemContract)
                                        <option value="{{$itemContract['value']}}" @if(isset($contract) && $contract['contractor_id'] == $itemContract['value']) selected @endif>
                                            {{$itemContract['label']}}</option>
                                    @endforeach
                                </x-select2>
                                @error('contract_id')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"> Cadastrar </button>
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

