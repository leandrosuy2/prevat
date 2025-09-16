<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$schedulePrevat ? 'Edição de ' : 'Cadastro de nova '}} Agenda</h3>
                </div>
                <div class="card-body">
                    <h5 class="card-sub-title  text-primary">
                        Insira abaixo os dados do Agendamento
                    </h5>

                    @include('includes.alerts')

                    <form wire:submit="save" class="form-horizontal mt-5">
                        <div class="row">
                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label class="form-label">Treinamento</label>
                                    <x-select2 wire:model="state.training_id" class="form-control form-select select2 select2-show-search">
                                    @foreach($response->trainings as $itemTraining)
                                        <option value="{{$itemTraining['value']}}"> {{$itemTraining['label']}} </option>
                                        @endforeach
                                    </x-select2>
                                        @error('training_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <x-datepicker label="Data do Evento" wire:model.live="state.date_event"> </x-datepicker>
                                        @error('date_event')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <x-datepicker label="Início" wire:model.live="state.start_event"> </x-datepicker>
                                @error('start_event')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <x-datepicker label="Fim" wire:model.live="state.end_event" > </x-datepicker>
                                        @error('end_event')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Local</label>
                                    <x-select2 wire:model="state.training_local_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->trainingLocations as $itemLocation)
                                            <option value="{{$itemLocation['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['training_local_id'] == $itemLocation['value']) selected @endif>
                                                {{$itemLocation['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('training_local_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Sala</label>
                                    <x-select2 wire:model="state.training_room_id" class="form-control form-select select2 select2-show-search">
                                    @foreach($response->rooms as $itemRoom)
                                        <option value="{{$itemRoom['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['room_id'] == $itemRoom['value']) selected @endif>
                                            {{$itemRoom['label']}}</option>
                                        @endforeach
                                        </x-select2>
                                        @error('training_room_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Carga Horária</label>
                                    <x-select2 wire:model="state.workload_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->workloads as $itemWorkLoad)
                                            <option value="{{$itemWorkLoad['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['room_id'] == $itemWorkLoad['value']) selected @endif>
                                                {{$itemWorkLoad['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('workload_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label class="form-label"> 1º Horario </label>
                                    <x-select2 wire:model="state.time01_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->times as $itemTime)
                                            <option value="{{$itemTime['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['time01_id'] == $itemTime['value']) selected @endif>
                                                {{$itemTime['label']}}</option>
                                        @endforeach
                                        </x-select2>
                                        @error('time01_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">2º Horário</label>
                                    <x-select2 wire:model="state.time02_id" class="form-control form-select select2 select2-show-search">
                                    @foreach($response->times as $itemTime)
                                        <option value="{{$itemTime['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['time02_id'] == $itemTime['value']) selected @endif>
                                        {{$itemTime['label']}}</option>
                                    @endforeach
                                        </x-select2>
                                        @error('time02_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-1">
                                <div class="form-group">
                                    <label for="Vagas" class="form-label">Dias</label>
                                    <input type="number" wire:model="state.days" class="form-control">
                                    @error('days')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-1">
                                <div class="form-group">
                                    <label for="Vagas" class="form-label">Vagas</label>
                                    <input type="number" wire:model="state.vacancies" class="form-control">
                                    @error('vacancies')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Contratante</label>
                                    <x-select2 wire:model="state.contractor_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->contractors as $itemContractor)
                                            <option value="{{$itemContractor['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['contractor_id'] == $itemContractor['value']) selected @endif>
                                                {{$itemContractor['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('contractor_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Empresa</label>
                                    <x-select2 wire:model="state.company_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->companies as $itemCompany)
                                            <option value="{{$itemCompany['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['company_id'] == $itemCompany['value']) selected @endif>
                                                {{$itemCompany['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Turma</label>
                                    <x-select2 wire:model="state.team_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->teams as $itemTeam)
                                            <option value="{{$itemTeam['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['team_id'] == $itemTeam['value']) selected @endif>
                                                {{$itemTeam['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('team_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Status</label>

                                    <x-select2 wire:model="state.status" class="form-control form-select select2 select2-show-search">
                                        <option value="">Escolha</option>
                                        <option value="Em Aberto" @if(isset($company) && $schedulePrevat['status'] == 'Ativo') selected @endif>Em Aberto</option>
                                        <option value="Concluído" @if(isset($schedulePrevat) && $schedulePrevat['status'] == 'Inativo') selected @endif>Concluído</option>
                                    </x-select2>

                                    @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Tipo</label>

                                    <x-select2 wire:model="state.type" class="form-control form-select select2 select2-show-search">
                                        <option value="">Escolha</option>
                                        <option value="Aberto"> Aberto </option>
                                        <option value="Fechado"> Fechado </option>
                                    </x-select2>

                                    @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> {{$schedulePrevat ? 'Atualizar' : 'Cadastrar'}}</button>
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

    <!-- TIMEPICKER JS -->
{{--    <script src="{{asset('build/assets/plugins/time-picker/jquery.timepicker.js')}}"></script>--}}
{{--    <script src="{{asset('build/assets/plugins/time-picker/toggles.min.js')}}"></script>--}}

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>
    @vite('resources/assets/js/flatpickr.js')


    <!-- DATEPICKER JS -->
{{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>
{{--    <script src="{{asset('build/assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>--}}


    <script>

        // document.addEventListener('livewire:init', () => {
        //     // Runs after Livewire is loaded but before it's initialized
        //     // on the page...
        // })


        $(document).ready(function () {
            $('#select2').select2();
            $('#select2').on('change', function (e) {
                var data = $('#select2').select2("val");

                console.log(data);
            @this.set('selected', data);
            });
        });
    </script>
@endsection
