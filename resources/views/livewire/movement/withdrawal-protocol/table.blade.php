<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista dos Protocolos de Retirada Cadastrados</h3>
                    {{--                    @can('add_professional')--}}
                    <a href=" {{ route('movement.withdrawal-protocol.create') }}" class="fw-semibold btn btn-sm btn-primary"> <i class="fe fe-plus-circle"></i> Cadastrar </a>
                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('movement.withdrawal-protocol.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-bold fs-12" width="40px">Protocolo</th>
                                    <th class="fw-bold fs-12">Empresa</th>
                                    <th class="fw-bold fs-12">Treinamento</th>
                                    <th class="fw-bold fs-12">Data Retirada</th>
                                    <th class="fw-bold fs-12" width="30px">Açoes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->protocols as $itemProtocol)
                                    <tr>
                                        <td class="fw-semibold text-dark fs-12"> {{ $itemProtocol['reference']}}</td>
                                        <td ">
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-12">
                                                        {{ $itemProtocol['company']['name'] ?? $itemProtocol['company']['fantasy_name'] }}
                                                    </h6>
                                                    <span class="text-muted fw-semibold fs-12">CTO : {{ $itemProtocol['contract']['contract'] ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-12">
                                                        {{$itemProtocol['training_participation']['schedule_prevat']['training']['acronym']}} -
                                                        {{$itemProtocol['training_participation']['schedule_prevat']['training']['name']}}
                                                    </h6>
                                                    <span class="text-muted fw-semibold fs-12">DATA EVENTO : {{ formatDate($itemProtocol['training_participation']['schedule_prevat']['date_event']) }}</span>
                                                </div>
                                            </div>
                                        </td>


                                        <td class="fw-semibold text-dark fs-12">
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                        {{ formatDateAndTime($itemProtocol['created_at'] )}}
                                                    </h6>
                                                    Retirado por: <span class="text-muted fw-semibold fs-11">{{ $itemProtocol['name'] ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-nowrap">
                                            {{--                                        @can('edit_professional')--}}
                                            <a href="{{ route('movement.withdrawal-protocol.edit', $itemProtocol['id']) }}" class="btn btn-sm btn-icon btn-warning"  data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Editar">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            {{--                                        @endcan--}}
                                            {{--                                        @can('delete_professional')--}}
                                            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemProtocol}})'  data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Apagar">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                            {{--                                        @endcan--}}
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
                            <div class="text-nowrap mt-1">itens de {{ $response->protocols->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->protocols->links() }}
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
        $('#confirmDelete').text('confirmDeleteProtocol');
        $('#Vertically').modal('show');
    }
</script>



