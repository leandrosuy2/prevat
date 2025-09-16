<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-13" >Lista dos Participantes do Treinamento : {{$trainingParticipation['schedule_prevat']['training']['name']}}</h3>
                    <button class="btn btn-warning" type="button" wire:click="openSlide('movement.participant-training.professional.form', {'id' : '{{$trainingParticipation['id'] ?? null}}' })">Adicionar Profissional</button>
                </div>

                <div class="card-body" style="z-index: 5">

                @include('includes.alerts')

                <div class="e-table">
                    <div class="table-responsive table-lg">
                        <table class="table table-bordered text-dark">
                            <thead>
                            <tr>
                                <th class="text-dark fw-bold fs-11 w-25">Profissional</th>
                                <th class="text-dark fw-bold fs-11">Qualificação</th>
                                <th class="text-dark fw-bold fs-11">Documento</th>
                                <th class="text-dark fw-bold fs-11">Registro</th>
                                <th class="text-dark fw-bold fs-11 text-center">Frente</th>
                                <th class="text-dark fw-bold fs-11 text-center">Verso</th>
                                <th class="text-center fw-bold fs-11">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($response->professionals)
                                @foreach($response->professionals as $key => $itemProfessional)
                                    <tr>
                                        <td>
                                            <div class="flex-1 my-auto">
                                                <h6 class="mb-0 fw-semibold  fs-11">{{$itemProfessional['id']}} - {{$itemProfessional['professional']['name']}}</h6>
{{--                                                <span class="text-muted fw-semibold fs-11">{{ $itemProfessional['professional']['email'] ?? '' }} - {{ $itemProfessional['professional']['phone'] ?? '' }} </span>--}}
                                            </div>
                                        </td>
                                        <td class="text-nowrap align-middle fs-11">
                                            <span>{{$itemProfessional['formation']['name']}}</span>
                                        </td>

                                        <td class="text-nowrap align-middle fs-11">
                                            <span>{{$itemProfessional['professional']['document']}}</span>
                                        </td>

                                        <td class="text-nowrap align-middle fs-11">
                                            <span>{{$itemProfessional['professional']['registry']}}</span>
                                        </td>

                                        <td class="text-nowrap align-middle fs-11">
                                            <div class="text-center">
                                                @if($itemProfessional['front'])
                                                    <span class="badge bg-success text-white"> Sim </span>
                                                @else
                                                    <span class="badge bg-danger text-white"> Não </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-nowrap align-middle fs-11">
                                            <div class="text-center">
                                                @if($itemProfessional['verse'])
                                                    <span class="badge bg-success text-white"> Sim </span>
                                                @else
                                                    <span class="badge bg-danger text-white"> Não </span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-center align-middle">
{{--                                            <div class="btn-group align-top br-7">--}}
                                                <button wire:click="openSlide('movement.participant-training.professional.form', {'id' : '{{$trainingParticipation['id'] }}', 'professional_id': {{$itemProfessional['id']}} })" class="btn btn-sm btn-warning badge"
                                                        type="button"><i
                                                        class="fa fa-edit"></i></button>

                                                <button wire:click.prevent="deleteProfessional({{$itemProfessional['id']}})" class="btn btn-sm btn-danger badge"
                                                        type="button"><i
                                                        class="fa fa-trash"></i></button>
{{--                                            </div>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
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
        $('#confirmDelete').text('confirmDeleteScheduleParticipant');
        $('#Vertically').modal('show');
    }
</script>
