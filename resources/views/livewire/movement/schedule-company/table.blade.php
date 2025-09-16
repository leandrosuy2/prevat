<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Agendas Empresa Cadastradas</h3>
                    {{--                    @can('add_professional')--}}
                    <a href=" {{ route('movement.schedule-company.create') }}" class="fw-semibold btn btn-sm btn-primary"> <i class="fe fe-plus-circle"></i> Nova Agenda </a>
                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('movement.schedule-company.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-bold fs-11 text-center">Id</th>
                                <th class="fw-bold fs-11">Empresa</th>
                                <th class="fw-bold fs-11">Treinamento</th>
                                <th class="fw-bold fs-11 text-center">Data</th>
                                <th class="fw-bold fs-11 text-center">Participantes</th>
                                <th class="fw-bold fs-11" width="40px">Status</th>
                                <th class="fw-bold fs-11 text-center" width="30px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->scheduleCompanies as $itemSchedule)
                                <tr>
                                    <td class="fw-semibold text-dark text-center fs-11"> {{ $itemSchedule['id'] }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                    {{$itemSchedule['company']['name'] ?? $itemSchedule['company']['fantasy_name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-11">CNPJ : {{ $itemSchedule['company']['employer_number'] ?? '' }} - </span>
                                                <span class="text-muted fw-semibold fs-11">CTO : {{ $itemSchedule['contract']['contract'] ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                    {{ $itemSchedule['schedule']['training']['acronym'] ?? '' }}
                                                    {{ $itemSchedule['schedule']['training']['name'] ?? '' }} - {{$itemSchedule['schedule']['contractor']['fantasy_name'] ?? ''}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-11">{{ $itemSchedule['schedule']['first_time']['name'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark text-center fs-11"> {{ formatDate($itemSchedule['schedule']['date_event']) }}</td>
                                    <td class="fw-semibold text-dark text-center fs-11"> {{ $itemSchedule['total_participants'] }}</td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemSchedule['schedule']['status'] == 'Em Aberto')
                                                <span class="badge bg-primary text-white"> {{$itemSchedule['schedule']['status']}}</span>
                                            @else
                                                <span class="badge bg-success text-white"> {{$itemSchedule['schedule']['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('movement.schedule-company.participants', $itemSchedule['id']) }}" class="btn btn-sm btn-icon btn-info {{$itemSchedule['schedule']['status'] == 'Concluído' ? 'disabled' : ''}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Participantes">
                                            <i class="fe fe-users"></i>
                                        </a>

                                        <a href="{{ route('movement.schedule-company.edit', $itemSchedule['id']) }}" class="btn btn-sm btn-icon btn-warning {{$itemSchedule['schedule']['status'] == 'Concluído' ? 'disabled' : ''}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Editar">
                                            <i class="fe fe-edit"></i>
                                        </a>

                                        <button class="btn btn-sm btn-icon btn-danger {{$itemSchedule['schedule']['status'] == 'Concluído' ? 'disabled' : ''}}" onclick='modalDelete({{$itemSchedule}})' data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Apagar ">
                                            <i class="fe fe-trash"></i>
                                        </button>
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
                            <div class="text-nowrap mt-1">itens de {{ $response->scheduleCompanies->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->scheduleCompanies->links() }}
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
        $('#confirmDelete').text('confirmDeleteScheduleCompany');
        $('#Vertically').modal('show');
    }
</script>
