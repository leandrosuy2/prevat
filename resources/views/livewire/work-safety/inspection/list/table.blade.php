<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista dos items inspecionados</h3>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="card visually-hidden">
                    <x-datepicker label="Vencimento" wire:model.live="state.due_date" type="hidden"> </x-datepicker>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            @foreach ($response->categories as $index => $itemCategory)

                                    <div class="table-responsive mb-3">
                                        <table
                                            class="table table-bordered text-nowrap text-md-nowrap  table-primary mb-0">
                                            <thead>
                                            <tr>
                                                <th class="text-center w-5">ID</th>
                                                <th>{{$itemCategory['name']}}</th>
                                                <th class="text-center w-5">Sim</th>
                                                <th class="text-center w-5">Não</th>
                                                <th class="text-center w-5">Ações</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($response->items as $key => $itemItem)

                                                @if($itemCategory['id'] == $itemItem['safety_category_id'])
                                                    <tr>
                                                        <td>{{$itemItem['id']}}</td>
                                                        <td>{{$itemItem['item']['name']}}</td>
                                                        <td class="text-center">
                                                            <label class="custom-switch">
                                                                <input type="checkbox" name="custom-switch-checkbox"
                                                                       wire:model.live="yes.{{$key}}"
                                                                       class="custom-switch-input">
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="custom-switch">
                                                                <input type="checkbox" name="custom-switch-checkbox"
                                                                       wire:model.live="not.{{$key}}"
                                                                       class="custom-switch-input">
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <button wire:click.prevent="openModal('work_safety.inspection.list.form', {'id' : {{$itemItem['id']}}, 'key' : {{$key}} })" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Itens">
                                                                <i class="fa-solid fa-file-lines"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
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



