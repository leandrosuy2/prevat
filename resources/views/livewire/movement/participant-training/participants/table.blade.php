<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista dos Participantes do Treinamento : {{$trainingParticipation['schedule_prevat']['training']['name']}}</h3>
                    <div class="">

                        @if($response->participants->count() == 0)
                        <button class="btn btn-secondary" type="button" wire:click="addParticipants({{$trainingParticipation['schedule_prevat_id']}})" >
                            <i class="fa fa-users"></i> Participantes do Agendamento
                        </button>
                        @endif

                        <button class="btn btn-primary" type="button" wire:click="openSlide('movement.participant-training.participants.form', {'id' : {{$trainingParticipation['id']}} })">
                            <i class="fa fa-user"></i> Participante Avulso
                        </button>
                        @if($response->participants->count() > 0)
                        <button class="btn btn-danger" type="button" wire:click="clearParticipants()">
                            <i class="fa fa-circle-check"></i>
                            Limpar Participantes
                        </button>
                        @endif
                    </div>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <form wire:submit="save" class="form-horizontal">
                            <table class="table table-bordered text-dark">
                                <thead>
                                <tr>
                                    <th class="text-dark fw-bold fs-11 w-20">Participante</th>
                                    <th class="text-dark fw-bold fs-11">Documento</th>
{{--                                    <th class="text-dark fw-semibold">Função</th>--}}
                                    <th class="text-center fw-bold fs-11">Empresa</th>
{{--                                    <th class="text-center fw-bold fs-11 w-10">Qtde.</th>--}}
{{--                                    <th class="text-center fw-bold fs-11">Valor</th>--}}
{{--                                    <th class="text-center fw-bold fs-11">Total</th>--}}
                                    <th class="text-center fw-bold fs-11 w-10" >Nota</th>
                                    <th class="text-center fw-bold fs-11">Status</th>
                                    <th class="text-center fw-bold fs-11 w-2">Pres.</th>
                                    <th class="text-center fw-bold fs-11 w-10">Registro</th>
                                    <th class="text-center fw-bold fs-11">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($response->participants)
                                    @foreach($response->participants as $key => $itemParticipant)
                                        <tr class="{{$itemParticipant['table_color']}} text-uppercase">
                                            <td>
                                                <div class="flex-1">
                                                    <h6 class="mb-0 fw-semibold fs-11">{{$itemParticipant['participant']['name']}}</h6>
                                                    <span class="text-muted fw-semibold fs-11">{{$itemParticipant['participant']['role']['name']}}</span>
                                                </div>
                                            </td>
                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemParticipant['participant']['taxpayer_registration']}}</span>
                                            </td>

{{--                                            <td class="text-nowrap align-middle">--}}
{{--                                                <span>{{$itemParticipant['participant']['role']['name']}}</span>--}}
{{--                                            </td>--}}
                                            <td class="text-left fs-11">
                                                @if($itemParticipant['participant']['company']['name'])
                                                    <span>{{mb_strimwidth($itemParticipant['participant']['company']['name'], 0, 40, "...")}} </span>
                                                @else
                                                    <span> {{$itemParticipant['participant']['company']['fantasy_name']}}</span>
                                                @endif
                                            </td>
{{--                                            <td class="text-nowrap align-middle fs-11">--}}
{{--                                                <input type="number" min="0" max="10" wire:model.live="quantity.{{$key}}" class="form-control @error('quantity.*') is-invalid state-invalid @enderror" >--}}
{{--                                            </td>--}}

{{--                                            <td class="text-nowrap align-middle fs-11">--}}
{{--                                                <span>{{formatMoney($itemParticipant['value'])}}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-nowrap align-middle fs-11">--}}
{{--                                                <span>{{formatMoney($itemParticipant['total_value'])}}</span>--}}
{{--                                            </td>--}}
                                            <td class="text-nowrap align-middle fs-11">
                                                <input wire:model.live="note.{{$key}}" class="form-control @if($errors->has('note.'.$key)) is-invalid state-invalid @endif">
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
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
                                                    <input type="checkbox" wire:model.live="presence.{{$key}}" name="custom-switch-checkbox"  value="{{$itemParticipant['presence']}}"
                                                           class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>

                                                </label>
                                            </td>
                                            <td class="text-nowrap text-center  fs-11">
                                                @if($itemParticipant['certificate'])
                                                    <span>{{formatNumber($itemParticipant['certificate']['registry']) ?? ' '}}</span>
                                                @else
                                                    <span>S/R</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group align-top br-7">
                                                    <button wire:click="deleteParticipant({{$itemParticipant['id']}})" class="btn btn-sm btn-danger badge"
                                                            type="button"><i
                                                            class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary"> Atualizar </button>
                            </form>
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


