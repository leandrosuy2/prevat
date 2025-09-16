<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista Participações em treinamento</h3>
                    {{--                    @can('add_professional')--}}
                    <div class="">
                        <a href=" {{ route('movement.participant-training.create') }}" class="fw-semibold btn btn-sm btn-primary"> <i class="fe fe-plus-circle"></i> Novo Cadastro </a>
                        <a href=" {{ route('movement.participant-training.private.create') }}" class="fw-semibold btn btn-sm btn-warning"> <i class="fe fe-plus-circle"></i> Novo Cadastro Privado </a>
                        {{--                    @endcan--}}
                    </div>

                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('movement.participant-training.filter')
                    <div wire:loading.class="opacity-75 ">
                        <div  wire:loading id="global-loader" >
                            <img src="{{asset('build/assets/images/svgs/loader.svg')}}" alt="loader">
                        </div>
                    </div>

                    <div class="e-table ">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered text-dark">
                                    <thead class="text-dark">
                                    <tr>
                                        <th class="fw-bold fs-11 text-center">ID</th>
                                        <th class="fw-bold fs-11 w-30">Treinamento</th>
                                        <th class="fw-bold fs-11">Profissionais</th>
                                        <th class="fw-bold fs-11 w-15"><div class="text-center">Data</div></th>
                                        <th class="fw-bold fs-11"><div class="text-center">Total</div></th>
                                        <th class="fw-bold fs-11 w-10">Status</th>
                                        <th class="fw-bold fs-11 w-10">Evid.</th>
                                        <th class="fw-bold fs-11 w-10">Criado.</th>
                                        <th class="fw-bold fs-11 w-10 text-center">Açoes</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($response->trainingParticipation as $itemTraining)
                                        <tr>
                                            <td>
                                                <div class="text-center fs-11 fw-bold">
                                                    {{$itemTraining['id']}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-1">
                                                        <h6 class="mb-0 mt-1 text-dark fw-semibold fs-10">
                                                            @if($itemTraining['schedule_prevat'])
                                                                {{$itemTraining['schedule_prevat']['training']['acronym'].' - ' ??  'teste'}}
                                                                {{$itemTraining['schedule_prevat']['training']['name']}}
                                                            @else
                                                                {{$itemTraining['training']['acronym'].' - ' ?? 'teste '}}
                                                                {{$itemTraining['training']['name']}}
                                                            @endif
                                                        </h6>
                                                        <span class="text-muted fw-semibold fs-10">{{ $itemTraining['location']['name'] ?? '' }} {{ $itemTraining['team']['name'] ?? '' }} {{ $itemTraining['contractor']['name'] ?? '' }} </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-semibold text-muted fs-10 text-nowrap">
                                                @foreach($itemTraining['professionals'] as $itemProfessional)
                                                    {{ $itemProfessional['professional']['name'] }} <br>
                                                @endforeach
                                            </td>
                                            <td class="fw-semibold text-dark fs-10 text-nowrap">
                                                @if($itemTraining['schedule_prevat']['time02_id'] != null)
                                                    {{ formatDate($itemTraining['schedule_prevat']['start_event']) }} - {{$itemTraining['schedule_prevat']['first_time']['name']}}<br>
                                                    {{ formatDate($itemTraining['schedule_prevat']['end_event']) }} - {{$itemTraining['schedule_prevat']['second_time']['name']}}
                                                @else
                                                    {{ formatDate($itemTraining['schedule_prevat']['start_event']) }} - {{$itemTraining['schedule_prevat']['first_time']['name']}}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-center fs-10 fw-bold">
                                                    {{$itemTraining['participants']->count()}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center fs-11">
                                                    @if($itemTraining['status'] == 'Em Aberto')
                                                        <span class="badge bg-primary text-white"> {{$itemTraining['status']}}</span>
                                                    @else
                                                        <span class="badge bg-success text-white"> {{$itemTraining['status']}}</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-center fs-12">
                                                    @if($itemTraining['evidences'])
                                                        <i class="fas fa-graduation-cap "></i>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-center fs-12">
                                                    {{ formatDate($itemTraining['created_at'])}}
                                                </div>
                                            </td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('movement.participant-training.participants', $itemTraining['id']) }}" class="btn btn-sm btn-icon btn-primary {{$itemTraining['status'] == 'Concluído' ? 'disabled' : ''}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="Participantes">
                                                    <i class="fa fa-users"></i>
                                                </a>

                                                <a href="{{ route('movement.participant-training.professionals', $itemTraining['id']) }}" class="btn btn-sm btn-icon btn-success {{$itemTraining['status'] == 'Concluído' ? 'disabled' : ''}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="Profissionais">
                                                    <i class="fas fa-user-graduate"></i>
                                                </a>

                                                <a href="{{ route('movement.participant-training.edit', $itemTraining['id']) }}" class="btn btn-sm btn-icon btn-warning {{$itemTraining['status'] == 'Concluído' ? 'disabled' : ''}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="Editar">
                                                    <i class="fe fe-edit"></i>
                                                </a>

                                                <button class="btn btn-sm btn-icon btn-danger {{$itemTraining['status'] == 'Concluído' ? 'disabled' : ''}}" onclick='modalDelete({{$itemTraining}})' data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Apagar">
                                                    <i class="fe fe-trash"></i>
                                                </button>

                                                <div class="dropstart btn-group mt-2 mb-2">
                                                    <button class="btn btn-sm btn-dark dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown"> <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{ route('movement.participant-training.certificates', $itemTraining['id']) }}"><i class="fa fa-certificate"></i> Imprimir Certificados</a></li>
                                                        <li><a href="{{ route('movement.participant-training.programmatic', $itemTraining['id']) }}"> <i class="fa fa-file-lines"></i> Conteúdo Programático</a></li>
                                                        <li><a href="javascript:void(0)" wire:click.prevent="changeStatus({'id': {{$itemTraining['id']}}, 'status' : '{{$itemTraining['status'] == 'Em Aberto' ? 'Concluído' : 'Em Aberto'}}' })"><i class="fa fa-retweet"></i>  Alterar status para {{$itemTraining['status'] == 'Em Aberto' ? 'Fechado' : 'Em Aberto'}}</a></li>
                                                        @if(!$itemTraining['evidences']  && $itemTraining['status'] == 'Concluído')
                                                            <li><a href="javascript:void(0)" wire:click.prevent="createEvidences({'id': {{$itemTraining['id']}} })"><i class="fa-solid fa-graduation-cap"></i>  Gerar Evidências </a></li>
                                                        @else
                                                            <li><a href="javascript:void(0)" wire:click.prevent="updateEvidences({'id': {{$itemTraining['id']}} })"><i class="fa-solid fa-graduation-cap"></i>  Atualizar Evidências </a></li>
                                                        @endif
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
                            <div class="text-nowrap mt-1">itens de {{ $response->trainingParticipation->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->trainingParticipation->links() }}
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
        $('#confirmDelete').text('confirmDeleteScheduleTrainingParticipation');
        $('#Vertically').modal('show');
    }
</script>
