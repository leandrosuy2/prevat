<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">{{$scheduleCompany ? 'Edição de ' : 'Cadastro de nova '}} Agenda Empresa Cliente</h3>
                    <div class="">
                    @if(auth()->user()->company->type == 'client')
                        <button class="btn btn-sm btn-secondary" type="button" wire:click.prevent="openSlide('client.schedule-company.participants.card', {'schedule_company_id' : {{$scheduleCompany['id'] ?? 'null'}}, 'id' : {{$scheduleCompany['company']['id'] ?? auth()->user()->company->id}} })"><i class="fa fa-users"></i> Adicionar Participantes</button>
                        <button class="btn btn-sm btn-warning" type="button" wire:click.prevent="openModal('client.schedule-company.participant.form', {'id' : {{auth()->user()->company->id}} })"><i class="fa fa-user-plus"></i> Cadastrar Participante</button>
                    @endif
                    </div>
                </div>

                <div class="card-body">

                    <h6 class="card-sub-title text-primary">
                        Insira abaixo os dados do Agendamento da Empresa
                    </h6>

                    @include('includes.alerts')

                    <form wire:submit="save" class="form-horizontal mt-5">

                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <label class="form-label">Eventos</label>
                                    <x-select2 wire:model.live="state.schedule_prevat_id" class="form-select select2 select2-show-search">
                                        @foreach($response->schedulePrevats as $itemSchedule)
                                            <option value="{{$itemSchedule['value']}}" @if(isset($scheduleCompany) && $scheduleCompany['schedule_prevat_id'] == $itemSchedule['value']) selected @endif>
                                                {{$itemSchedule['label']}}  {{ $itemSchedule['vacancies_available'] ? '- Vagas Dispońiveis : ' .$itemSchedule['vacancies_available'] : ' '}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('schedule_prevat_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <label class="form-label">Empresa</label>
                                    <x-select2 wire:model="state.company_id" class="form-select select2 select2-show-search">
                                        @foreach($response->companies as $itemCompany)
                                            <option value="{{$itemCompany['value']}}" @if(isset($scheduleCompany) && $scheduleCompany['company_id'] == $itemCompany['value']) selected @endif>
                                                {{$itemCompany['label']}}
                                            </option>
                                        @endforeach
                                    </x-select2>
                                    @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if(isset($state['schedule_prevat_id']) && $state['schedule_prevat_id'] != null)
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="card text-white bg-gradient-primary">
                                        <div class="card-body">
                                            <h4 class="card-title"> {{$response->event['training']['name']}}</h4>
                                            <h4 class="card-title"> {{$response->event['contractor']['name']}}</h4>
                                            <p class="card-text mb-0">{{$response->event['location']['address']}} -
                                                {{ $response->event['location']['number'] ?? 'S/N' }}
                                                {{ $response->event['location']['complement'] ? ' - '.$response->event['location']['complement'] : ' ' }}
                                                {{ $response->event['location']['neighborhood'] ? ' - '.$response->event['location']['neighborhood'] : ' ' }}
                                                {{ $response->event['location']['zip-code'] ? ' - '.$response->event['location']['zip-code'] : ' ' }}
                                                {{ $response->event['location']['city'] ? ' - '.$response->event['location']['city'] : ' ' }}
                                                {{ $response->event['location']['uf'] ? ' - '.$response->event['location']['uf'] : ' ' }}
                                            </p>

                                            <p class="card-text  mb-0">Carga Horaria : {{ $response->event['workload']['name'] }} </p>
                                            @if(strtotime($response->event['start_event']) != strtotime($response->event['end_event']))
                                                @if($response->event['days'] <= 2)
                                                    <p class="card-text  mb-0">Data : {{ formatDate($response->event['start_event']) }} e {{ formatDate($response->event['end_event']) }}</p>
                                                @elseif($response->event['days'] > 2)
                                                    <p class="card-text  mb-0">Data : {{ formatDate($response->event['start_event']) }} à {{ formatDate($response->event['end_event']) }}</p>
                                                @endif
                                            @else
                                                <p class="card-text  mb-0">Data : {{ formatDate($response->event['start_event']) }} </p>
                                            @endif

                                            <p class="card-text"> 1º Horário : {{$response->event['first_time']['name']}}
                                                @if($response->event['second_time'])
                                                    - 2º Horário : {{$response->event['first_time']['name']}}
                                                @endif

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="table-responsive">
                                    <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                                        <thead class="text-dark">
                                        <tr>
                                            <th class="fw-bold fs-12">Nome</th>
                                            <th class="fw-bold fs-12">Documentos</th>
                                            @if(auth()->user()->company->type == 'admin')
                                                <th class="fw-bold fs-12">Empresa</th>
                                            @else
                                                <th class="fw-bold fs-12">Empresa</th>
                                            @endif
                                            <th class="fw-bold fs-12" width="40px">Status</th>
                                            <th class="fw-bold fs-12" width="50px">Açoes</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($participants as $key => $itemParticipant)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-1">
                                                            <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                                {{$itemParticipant['name']}}
                                                            </h6>
                                                            <span class="text-muted fw-semibold fs-12"> {{$itemParticipant['role']}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-semibold text-muted-dark">
                                                    <span class="text-muted fw-semibold fs-12">CTO. : {{ $itemParticipant['contract'] ?? 'S/C' }}</span><br>
                                                    <span class="text-muted fw-semibold fs-12">CPF : {{ $itemParticipant['taxpayer_registration'] ?? 'S/C'}}</span><br>

                                                </td>
                                                <td class="fw-semibold text-dark">
                                                    <span class="text-muted fw-semibold fs-12">E-mail : {{ $itemParticipant['email'] ?? 'S/C'}} </span><br>
                                                    <span class="text-muted fw-semibold fs-12">Telefone : {{ $itemParticipant['phone'] ?? 'S/C'}}</span>
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        @if($itemParticipant['status'] == 'Ativo')
                                                            <span class="badge bg-success text-white"> {{$itemParticipant['status']}}</span>
                                                        @else
                                                            <span class="badge bg-danger text-white"> {{$itemParticipant['status']}}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-icon btn-danger" wire:click.prevent="remParticipant({{$key}}, {{$itemParticipant['id']}})" >
                                                        <i class="fe fe-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="py-2">
                            <button type="submit" class="btn btn-primary"> {{$scheduleCompany ? 'Atualizar' : 'Cadastrar'}}</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@section('scripts')
    {{--    <!-- TIMEPICKER JS -->--}}
    {{--        <script src="{{asset('build/assets/plugins/time-picker/jquery.timepicker.js')}}"></script>--}}
    {{--        <script src="{{asset('build/assets/plugins/time-picker/toggles.min.js')}}"></script>--}}

    {{--    <!-- FLATPICKER JS -->--}}
    {{--    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>--}}
    {{--    @vite('resources/assets/js/flatpickr.js')--}}


    {{--    <!-- DATEPICKER JS -->--}}
    {{--    --}}{{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>--}}
    {{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>--}}
    {{--    --}}{{--    <script src="{{asset('build/assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

    @vite('resources/assets/js/form-elements.js')
@endsection
