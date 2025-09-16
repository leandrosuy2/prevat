<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista da Agendas Cadastradas</h3>
{{--                    @can('add_professional')--}}
                        <a href=" {{ route('movement.schedule-prevat.create') }}" class="fw-semibold btn btn-sm btn-primary"> <i class="fe fe-plus-circle"></i> Nova Agenda </a>
{{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('movement.schedule-prevat.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-bold fs-11">ID</th>
                                <th class="fw-bold fs-11">Treinamento</th>
                                <th class="fw-bold fs-11">Horários</th>
                                <th class="fw-bold fs-11">Data</th>
                                <th class="fw-bold fs-11 text-center">Vagas</th>
                                <th class="fw-bold fs-11 text-center">Diponível</th>
                                <th class="fw-bold fs-11 text-center">Ocupado</th>
                                <th class="fw-bold fs-11 text-center">Ausencias</th>
                                <th class="fw-bold fs-11 text-center" width="40px">Status</th>
                                <th class="fw-bold fs-11 text-center" width="40px">Evento</th>
                                <th class="fw-bold fs-11 w-10 text-center">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->schedulePrevats as $itemSchedule)
                                <tr>
                                    <td class="fw-semibold text-dark fs-10 text-nowrap">
                                        {{ $itemSchedule['id'] }}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <p class="mb-0 mt-1 text-dark fw-semibold fs-10">

                                                    {{$itemSchedule['training']['name']}} {{$itemSchedule['contractor'] ? '- '.$itemSchedule['contractor']['fantasy_name']  : ''}}
                                                </p>
                                                <span class="text-muted fw-semibold fs-10">{{ $itemSchedule['workload']['name'] ?? '' }} {{ $itemSchedule['team'] ? ' - '. $itemSchedule['team']['name']  : ' ' }} - {{ $itemSchedule['room']['name'] ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark fs-10 text-nowrap">
                                        @if($itemSchedule['second_time'])
                                        {{ $itemSchedule['first_time']['name'] ?? 'Sem Cadastro' }}<br>
                                        {{ $itemSchedule['second_time']['name'] ?? ' ' }}<br>
                                        @else
                                            {{ $itemSchedule['first_time']['name'] ?? 'Sem Cadastro' }}
                                        @endif

                                    </td>
                                    <td class="fw-semibold text-dark fs-10"> {{ formatDate($itemSchedule['date_event'] )}}</td>
                                    <td class="fw-semibold text-dark text-center fs-12"> {{ $itemSchedule['vacancies'] }}</td>
                                    <td class="fw-semibold text-success text-center fs-12"> {{ $itemSchedule['vacancies_available'] }}</td>
                                    <td class="fw-bolder text-danger text-center fs-12"> {{ $itemSchedule['vacancies_occupied'] }}</td>
                                    <td class="fw-bolder text-warning text-center fs-12"> {{ $itemSchedule['absences'] }}</td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemSchedule['status'] == 'Em Aberto')
                                                <span class="badge bg-primary text-white"> {{$itemSchedule['status']}}</span>
                                            @else
                                                <span class="badge bg-success text-white"> {{$itemSchedule['status']}}</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="text-center">
                                            @if($itemSchedule['type'] == 'Aberto')
                                                <span class="badge bg-success text-white"> {{$itemSchedule['type']}}</span>
                                            @else
                                                <span class="badge bg-warning text-white"> {{$itemSchedule['type']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
{{--                                        @can('edit_professional')--}}
                                            <a href="{{ route('movement.schedule-prevat.edit', $itemSchedule['id']) }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Editar">
                                                <i class="fe fe-edit"></i>
                                            </a>
{{--                                        @endcan--}}
{{--                                        @can('delete_professional')--}}
                                            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemSchedule}})' data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Apagar" >
                                                <i class="fe fe-trash"></i>
                                            </button>
{{--                                        @endcan--}}

                                        <div class="dropstart btn-group mt-2 mb-2">
                                            <button class="btn btn-sm btn-dark dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown"> <i class="fa-solid fa-ellipsis-vertical"></i>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('movement.schedule-company.create', $itemSchedule['id']) }}"><i class="fe fe-calendar"></i> Cadastrar Agenda Empresa</a></li>
                                                <li><a href="{{ route('movement.schedule-prevat.participants', $itemSchedule['id']) }}"><i class="fe fe-users"></i> Participantes</a></li>
                                                <li><a href="javascript:void(0)" wire:click.prevent="changeStatus({'id': {{$itemSchedule['id']}}, 'status' : '{{$itemSchedule['status'] == 'Em Aberto' ? 'Concluído' : 'Em Aberto'}}' })"> <i class="fa fa-retweet"></i> Alterar para {{$itemSchedule['status'] == 'Em Aberto' ? 'Concluído' : 'Em Aberto'}} </a></li>
                                                <li><a href="javascript:void(0)" wire:click.prevent="changeType({'id': {{$itemSchedule['id']}}, 'type' : '{{$itemSchedule['type'] == 'Aberto' ? 'Fechado' : 'Aberto'}}' })"> <i class="fa fa-calendar"></i> Alterar para evento {{$itemSchedule['type'] == 'Aberto' ? 'Fechado' : 'Aberto'}} </a></li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex col-md-12 col-xl-2 align-items-center">

                            <label for="firstName" class="col-md-6 form-label text-nowrap mt-2">Mostrando</label>
                            <div class="col-md-9">
                                <x-select2 wire:model.live="pageSize" placeholder="Select Members" class=" select2 form-select">
                                    <option value="10" selected>10</option>
                                    <option value="25">20</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </x-select2>
                            </div>
                            <div class="text-nowrap mt-1">itens de {{ $response->schedulePrevats->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->schedulePrevats->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteSchedulePrevat');
        $('#Vertically').modal('show');
    }
</script>


