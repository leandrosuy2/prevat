<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Participantes : {{$schedulePrevat['training']['name']}}</h3>
                    <div class="">
                        @if($schedulePrevat['file_presence'])
                            <button wire:click="refreshPDF({{$schedulePrevat['id']}})" class="fw-semibold btn btn-sm btn-orange"> <i class="fa fa-arrows-rotate"></i> Atualizar PDF </button>

                            <button wire:click="downloadPDF({{$schedulePrevat['id']}})" class="fw-semibold btn btn-sm btn-primary"> <i class="fa fa-file-pdf"></i> Baixar PDF </button>

                            <a href="{{ route('movement.schedule-prevat.printer', $schedulePrevat['id']) }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                               title="Imprimir PDF">
                                <i class="fa fa-print"></i> Imprimir
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('movement.schedule-prevat.participants.filter', ['id' => $schedulePrevat['id']])

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-bold fs-11 w-5 text-center">id#</th>
                                <th class="fw-bold fs-11">Nome</th>
                                <th class="fw-bold fs-11">Documento</th>
                                <th class="fw-bold fs-11">Contrato</th>
                                <th class="fw-bold fs-11">Empresa</th>
                                <th class="fw-bold fs-11 text-center">Presença</th>
                                <th class="fw-bold fs-11" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->participants as $key => $itemParticipant)
                                <tr>
                                    <td class="fw-semibold text-dark">
                                        <span class="text-muted fw-semibold fs-12 "> {{$itemParticipant['id']}} </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                    {{$itemParticipant['participant']['name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-11"> {{$itemParticipant['participant']['role']['name']}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-muted-dark">
                                        <span class="text-muted fw-semibold fs-11">CPF : {{ $itemParticipant['participant']['taxpayer_registration'] }}</span><br>

                                    </td>
                                    <td class="fw-semibold text-dark">
                                        <span class="text-muted fw-semibold fs-12 "> {{ $itemParticipant['participant']['contract']['contract'] ?? 'S/C' }}</span>
                                    </td>

                                    <td class="fs-11">
                                        @if($itemParticipant['participant']['company']['name'])
                                            <span>{{mb_strimwidth($itemParticipant['participant']['company']['name'], 0, 20, "...")}} </span>
                                        @else
                                            <span> {{$itemParticipant['participant']['company']['fantasy_name']}}</span>
                                        @endif
                                     </td>

                                    <td class="text-nowrap align-middle text-center">
                                        @if($itemParticipant['schedule_company']['schedule']['status'] == 'Em Aberto')
                                            <label class="custom-switch">
                                                <input type="checkbox" wire:model.live="presence.{{$key}}" name="custom-switch-checkbox"  value="{{$itemParticipant['presence']}}"
                                                       class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        @else
                                            <div class="text-center">
                                                @if($itemParticipant['presence'])
                                                    <span class="badge bg-green-dark text-white"> Presente</span>
                                                @else
                                                    <span class="badge bg-danger text-white"> Ausente</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-nowrap">
{{--                                        <button class="btn btn-sm btn-icon btn-primary" wire:click.prevent="openModal('movement.schedule-prevat.participants.signature.form', {'id' : {{$itemParticipant['participant_id']}} })"--}}
{{--                                                data-bs-toggle="tooltip" data-bs-placement="top"--}}
{{--                                                title="Assinar" >--}}
{{--                                            <i class="fa-solid fa-signature"></i>--}}
{{--                                        </button>--}}

                                        <button class="btn btn-sm btn-icon btn-warning" wire:click.prevent="openModal('movement.schedule-prevat.participants.form', {'id' : {{$itemParticipant['participant_id']}} })"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Editar" >
                                            <i class="fe fe-edit"></i>
                                        </button>

                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemParticipant}})' >
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
        $('#confirmDelete').text('confirmDeleteParticipantInSchedule');
        $('#Vertically').modal('show');
    }
</script>


