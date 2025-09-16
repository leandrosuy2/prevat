<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center m-0">
                    <h3 class="card-title fs-14">Lista de Participantes</h3>
                    @if(auth()->user()->company->type == 'client')
                        <a href=" {{ route('registration.participant.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Participante </a>
                    @else
                        @can('add_participant')
                        <a href=" {{ route('registration.participant.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Participante </a>
                        @endcan
                    @endif
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('registration.participant.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold">Nome</th>
                                <th class="fw-semibold" width="80">Assinatura</th>
                                <th class="fw-semibold">Documentos</th>
                                @if(auth()->user()->company->type == 'admin')
                                <th class="fw-semibold">Empresa</th>
                                @else
                                <th class="fw-semibold">Empresa</th>
                                @endif
                                <th class="fw-semibold" width="40px">Status</th>
                                <th class="fw-semibold w-10" >Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->participants as $itemParticipant)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemParticipant['name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-12"> {{$itemParticipant['role']['name']}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($itemParticipant['signature_image']))
                                            <img alt="signature" style="height:40px;" src="{{ asset('storage/' . $itemParticipant['signature_image']) }}">
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-muted-dark text-nowrap">
                                        <span class="text-muted fw-semibold fs-12">CPF : {{ $itemParticipant['taxpayer_registration'] }}</span><br>
                                        <span class="text-muted fw-semibold fs-12">CTO : {{ $itemParticipant['contract']['contract'] ?? 'S/C' }} </span><br>

                                    </td>
                                    <td class="fw-semibold text-dark">
                                        @if(auth()->user()->company->type == 'admin')
                                        <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                            {{$itemParticipant['company']['name']}}
                                        </h6>
                                        @else
                                            <span class="text-muted fw-semibold fs-12">E-mail : {{ $itemParticipant['email'] }}</span><br>
                                            <span class="text-muted fw-semibold fs-12">Telefone : {{ $itemParticipant['phone'] }}</span><br>
                                        @endif
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
                                    <td class="text-nowrap">
                                        <a href="{{ route('registration.participant.historic', $itemParticipant['id']) }}" class="btn btn-sm btn-icon btn-cyan">
                                            <i class="fe fe-list"></i>
                                        </a>
                                        @if(auth()->user()->company->type == 'admin')
                                        @can('edit_participant')
                                            <a href="{{ route('registration.participant.edit', $itemParticipant['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_participant')
                                            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemParticipant}})' >
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        @endcan
                                        @else
                                            <a href="{{ route('registration.participant.edit', $itemParticipant['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <button class="btn btn-sm  btn-icon btn-danger" onclick='modalDelete({{$itemParticipant}})' >
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex col-md-12 col-xl-2 align-items-center">

                            <label for="firstName" class="col-md-5 form-label text-nowrap mt-2">Mostrando</label>
                            <div class="col-md-9">
                                <x-select2 wire:model.live="pageSize" placeholder="Select Members" class=" select2 form-select">
                                    <option value="10" selected>10</option>
                                    <option value="25">20</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </x-select2>
                            </div>
                            <div class="text-nowrap mt-1">itens de {{ $response->participants->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->participants->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(client) {
        $('#nomeUsuario').text(client.name);
        $('#idUsuario').text(client.id);
        $('#confirmDelete').text('confirmDeleteParticipant');
        $('#Vertically').modal('show');
    }
</script>


