<div>
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Profissionais</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo as informações do novo profissional
                    </p>

                    <form wire:submit="submit" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label class="form-label">Profissional</label>
                                    <select wire:model.live="state.professional_id" class="form-control form-select">
                                        @foreach($response->professionals as $itemProfessiona)
                                            <option value="{{$itemProfessiona['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['professional_id'] == $itemProfessiona['value']) selected @endif>
                                                {{$itemProfessiona['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('*.professional_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label class="form-label">Qualificação Profissional</label>
                                    <select wire:model.live="state.professional_formation_id" class="form-control form-select">
                                        @foreach($response->professionalFormations as $itemProfessionalFormation)
                                            <option value="{{$itemProfessionalFormation['value']}}"> {{$itemProfessionalFormation['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('*.professional_formation_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   wire:model.live="state.front">
                            <span class="custom-control-label">Imprimir Frente</span>
                        </label>

                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   wire:model.live="state.verse">
                            <span class="custom-control-label">Imprimir Verso</span>
                        </label>


                        <button type="submit" class="btn btn-primary"> {{$professional ? 'Atualizar' : 'Cadastrar'}} </button>
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
