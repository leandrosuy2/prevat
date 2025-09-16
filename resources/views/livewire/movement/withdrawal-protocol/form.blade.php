<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">{{$protocol ? 'Edição de ' : 'Cadastro de novo '}} Protocolo de Retirada</h3>
                </div>

                <div class="card-body">
                    <h5 class="card-sub-title text-primary">
                        Insira abaixo os dados solicitado.
                    </h5>

                    <form wire:submit="save" class="form-horizontal mt-5">
                        <div class="row">
                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label class="form-label">Treinamento do participante</label>
                                    <x-select2 wire:model.live="state.training_participation_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->trainings as $itemTraining)
                                            <option value="{{$itemTraining['value']}}" @if(isset($evidence) && $evidence['training_id'] == $itemTraining['value']) selected @endif>
                                                {{$itemTraining['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('training_participation_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label class="form-label">Empresas</label>
                                    <select wire:model.live="state.company_id" class="form-control form-select">
                                        @foreach($response->companies as $itemCompany)
                                            <option value="{{$itemCompany['value']}}" @if(isset($evidence) && $evidence['company_id'] == $itemCompany['value']) selected @endif>
                                                {{$itemCompany['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Contrato</label>
                                    <select wire:model.live="state.contract_id" class="form-control form-select">
                                        @foreach($response->contracts as $itemRoom)
                                            <option value="{{$itemRoom['value']}}" @if(isset($participant) && $participant['contract_id'] == $itemRoom['value']) selected @endif>
                                                {{$itemRoom['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('contract_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Nome</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Documento</label>
                                    <input type="text" wire:model="state.document" class="form-control">
                                    @error('document')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <button type="submit" class="btn btn-primary"> {{$protocol ? 'Atualizar' : 'Cadastrar'}}</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!-- TIMEPICKER JS -->
    <script src="{{asset('build/assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
    <script src="{{asset('build/assets/plugins/time-picker/toggles.min.js')}}"></script>

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>
    @vite('resources/assets/js/flatpickr.js')


    <!-- DATEPICKER JS -->
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>
    <script src="{{asset('build/assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')
@endsection


