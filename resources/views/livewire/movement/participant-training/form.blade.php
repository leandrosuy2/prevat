<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">{{$participantTraining ? 'Editar' : 'Cadastrar '}} </h3>
                    <div class="">
                        @if(!$participantTraining)
                        @if(isset($state['schedule_prevat_id']) && $state['schedule_prevat_id'] != null && $response->participants == null)
                            <button class="btn  btn-sm btn-secondary" type="button" wire:click="addParticipants({{$state['schedule_prevat_id']}})" >
                                <i class="fa fa-users"></i> Participantes do Agendamento
                            </button>
                        @endif

                        @if(isset($state['schedule_prevat_id']) && $state['schedule_prevat_id'] != null )
                            <button class="btn btn-sm btn-primary" type="button" wire:click="openSlide('movement.participant-training.participants.form', {'id' : '{{$participantTraining['id'] ?? null}}' })">
                                <i class="fa fa-user"></i> Participante Avulso
                            </button>
                        @endif

                        @if($response->participants != null)
                            <button class="btn btn-sm  btn-danger" type="button" wire:click="clearParticipants()">Limpar Participantes</button>
                        @endif

                            <button class="btn btn-sm  btn-warning" type="button" wire:click="openSlide('movement.participant-training.professional.form', {'id' : '{{$participantTraining['id'] ?? null}}' })">
                                <i class="fas fa-user-graduate"></i> Adicionar Profissional
                            </button>
                        @endif

                    </div>
                </div>

                <div class="card-body">
                    <h6 class="card-sub-title text-primary">
                        Insira abaixo os dados as informações necessárias.
                    </h6>

                    <div class=row"">
                        @include('includes.alerts')
                    </div>

                    <form wire:submit="save" class="form-horizontal mt-5">
                        <div class="row">
                            <div class="col-md-12 col-xl-5">
                                <div class="form-group" >
                                    <label class="form-label">Treinamento</label>
                                    <x-select2 wire:model.live="state.schedule_prevat_id" class="form-select select2 select2-show-search">
                                        @foreach($response->schedulePrevats as $itemSchedule)--}}
                                            <option value="{{$itemSchedule['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['training_id'] == $itemSchedule['value']) selected @endif>
                                                {{$itemSchedule['label']}} {{$itemSchedule['team'] ? ' - '.$itemSchedule['team'] : '' }} {{ $itemSchedule['contractor'] ? ' - '.$itemSchedule['contractor'] : '' }}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('state.schedule_prevat_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                <x-datepicker label="Data do Evento" wire:model.live="state.date_event" class="form-control"> </x-datepicker>
                                @error('state.date_event')
                                <p class="text-danger">{{ $errors->first('state.date_event') }}</p>
                                @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <x-datepicker label="Início" wire:model.live="state.start_event" class="form-control"> </x-datepicker>
                                    @error('state.start_event')
                                    <p class="text-danger">{{ $errors->first('state.start_event') }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <x-datepicker label="Fim" wire:model.live="state.end_event" class="form-control"> </x-datepicker>
                                @error('state.end_event')
                                <p class="text-danger">{{ $errors->first('state.start_event') }}</p>
                                @enderror
                            </div>

                            <div class="col-md-12 col-xl-5">
                                <div class="form-group">
                                    <label class="form-label">Local</label>
                                    <select wire:model="state.training_location_id" class="form-control form-select">
                                        @foreach($response->trainingLocations as $itemLocation)
                                            <option value="{{$itemLocation['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['training_location_id'] == $itemLocation['value']) selected @endif>
                                                {{$itemLocation['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('state.training_location_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Sala</label>
                                    <select wire:model.live="state.training_room_id" class="form-control form-select">
                                        @foreach($response->rooms as $itemRoom)
                                            <option value="{{$itemRoom['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['room_id'] == $itemRoom['value']) selected @endif>
                                                {{$itemRoom['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('state.training_room_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Carga Horária</label>
                                    <select wire:model.live="state.workload_id" class="form-control form-select">
                                        @foreach($response->workloads as $itemWorkLoad)
                                            <option value="{{$itemWorkLoad['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['room_id'] == $itemWorkLoad['value']) selected @endif>
                                                {{$itemWorkLoad['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('state.workload_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label class="form-label"> 1º Horario </label>
                                    <select wire:model.live="state.time01_id" class="form-control form-select" >
                                        @foreach($response->times as $itemTime)
                                            <option value="{{$itemTime['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['time01_id'] == $itemTime['value']) selected @endif>
                                                {{$itemTime['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('state.time01_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">2º Horário</label>
                                    <select wire:model.live="state.time02_id" class="form-control form-select">
                                        @foreach($response->times as $itemTime)
                                            <option value="{{$itemTime['value']}}" @if(isset($schedulePrevat) && $schedulePrevat['time02_id'] == $itemTime['value']) selected @endif>
                                                {{$itemTime['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('state.time02_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Template de Certificado</label>
                                    <select wire:model.live="state.template_id" class="form-control form-select">
                                        @foreach($response->templates as $itemTemplate)
                                            <option value="{{$itemTemplate['value']}}" @if(isset($participantTraining) && $participantTraining['template_id'] == $itemTemplate['value']) selected @endif>
                                                {{$itemTemplate['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('state.template_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if(!$participantTraining)
                        <h6 class="card-sub-title text-primary mt-4">
                            Adicione os profissionais que lecionaram o curso.
                        </h6>

                        <div class="e-table">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered text-dark">
                                    <thead>
                                    <tr>
                                        <th class="text-dark fw-bold fs-11 w-25">Profissional</th>
                                        <th class="text-dark fw-bold fs-11">Qualificação</th>
                                        <th class="text-dark fw-bold fs-11">Documento</th>
                                        <th class="text-dark fw-bold fs-11 text-center">Frente</th>
                                        <th class="text-dark fw-bold fs-11 text-center">Verso</th>
                                        <th class="text-center fw-bold fs-11">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($response->professionals)
                                        @foreach($response->professionals as $key => $itemProfessional)
                                            <tr class="text-uppercase">
                                                <td>
                                                    <div class="flex-1 my-auto">
                                                        <h6 class="mb-0 fw-semibold fs-11">{{$itemProfessional['name']}}</h6>
{{--                                                        <span class="text-muted fw-semibold fs-11">{{ $itemProfessional['email'] ?? '' }} - {{ $itemProfessional['phone'] ?? '' }} </span>--}}
                                                    </div>
                                                </td>
                                                <td class="text-nowrap align-middle fs-11">
                                                    <span>{{$itemProfessional['qualification']}}</span>
                                                </td>

                                                <td class="text-nowrap align-middle fs-11">
                                                    <span>{{$itemProfessional['document']}}</span>
                                                </td>
                                                <td class="text-nowrap align-middle">
                                                    <div class="text-center">
                                                        @if($itemProfessional['front'])
                                                            <span class="badge bg-success text-white"> Sim </span>
                                                        @else
                                                            <span class="badge bg-danger text-white"> Não </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-nowrap align-middle">
                                                    <div class="text-center">
                                                        @if($itemProfessional['verse'])
                                                            <span class="badge bg-success text-white"> Sim </span>
                                                        @else
                                                            <span class="badge bg-danger text-white"> Não </span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="text-center align-middle fs-11">
                                                    <div class="btn-group align-top br-7">
                                                        <button wire:click.prevent="remProfessional({{$key}})" class="btn btn-sm btn-danger badge"
                                                                type="button"><i
                                                                class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
            </div>


                        <h6 class="card-sub-title text-primary mt-4">
                            Usuários que participaram do Evento.
                        </h6>

                        <div class="e-table">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered text-dark">
                                    <thead>
                                    <tr>
                                        <th class="text-dark fw-bold fs-11 w-20">Participante</th>
                                        <th class="text-dark fw-bold fs-11">Documento</th>
                                        <th class="text-center fw-bold fs-11">Empresa</th>
{{--                                        <th class="text-center fw-bold fs-11" width="100px">Qtde.</th>--}}
{{--                                        <th class="text-center fw-bold fs-11">Valor</th>--}}
{{--                                        <th class="text-center fw-bold fs-11">Total</th>--}}
                                        <th class="text-center fw-bold fs-11" width="120px">Nota</th>
                                        <th class="text-center fw-bold fs-11" width="120px">Status</th>
                                        <th class="text-center fw-bold fs-11 w-5" >Pres.</th>
                                        <th class="text-center fw-bold fs-11">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($response->participants)
                                        @foreach($response->participants as $key => $itemParticipant)
                                        <tr class="{{$itemParticipant['table']}}">
                                            <td>
                                                <div class="flex-1 my-auto">
                                                    <h6 class="mb-0 fw-semibold fs-11">{{$itemParticipant['name']}}</h6>
                                                    <span class="text-muted fw-semibold fs-11">{{$itemParticipant['role']}}</span>
                                                </div>
                                            </td>
                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemParticipant['taxpayer_registration']}}</span>
                                            </td>
                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{ mb_strimwidth($itemParticipant['company'], 0,33,"...")}}</span>
                                            </td>
{{--                                            <td class="text-nowrap align-middle fs-11">--}}
{{--                                                <input type="number" min="0" max="10" wire:model.live="quantity.{{$key}}" class="form-control @error('quantity.*') is-invalid state-invalid @enderror" >--}}
{{--                                            </td>--}}

{{--                                            <td class="text-nowrap align-middle text-center fs-11">--}}
{{--                                                <span>{{formatMoney($itemParticipant['value'])}}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-nowrap align-middle text-center fs-11">--}}
{{--                                                <span>{{formatMoney($itemParticipant['total_value'])}}</span>--}}
{{--                                            </td>--}}
                                            <td class="text-nowrap align-middle">
                                                <input  wire:model.live="note.{{$key}}" class="form-control @if($errors->has('note.'.$key)) is-invalid state-invalid @endif">
                                            </td>
                                            <td class="text-nowrap align-middle">
                                                <div class="text-center">
                                                    @if($itemParticipant['status'] == 'Aprovado')
                                                        <span class="badge bg-primary text-white"> {{$itemParticipant['status']}}</span>
                                                    @else
                                                        <span class="badge bg-danger text-white font-bold"> {{$itemParticipant['status']}}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-nowrap align-middle text-center">
                                                <label class="custom-switch">
                                                    <input type="checkbox" value="{{$itemParticipant['id']}}" wire:model.live="presence.{{$key}}" name="custom-switch-checkbox"
                                                           class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>

                                                </label>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group align-top br-7">
                                                       <button wire:click.prevent="remParticipant({{$key}})" class="btn btn-sm btn-danger badge"
                                                            type="button"><i
                                                            class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary"> {{$participantTraining ? 'Atualizar' : 'Cadastrar'}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>
    @vite('resources/assets/js/flatpickr.js')


    <!-- DATEPICKER JS -->
    {{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>
    {{--    <script src="{{asset('build/assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

    @vite('resources/assets/js/form-elements.js')
@endsection
