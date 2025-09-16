<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Contratos Referente a empresa : {{$company['name']}}</h3>
{{--                    @can('add_company_contract')--}}
                        <button wire:click.prevent="openModal('registration.company.contracts.form', {'id' : null, 'company_id': {{$company['id']}} })" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Contrato </button>
{{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold">Nome</th>
                                <th class="fw-semibold">Contratante</th>
                                <th class="fw-semibold text-center" width="200px" >Contrato</th>
                                <th class="fw-bold fs-12" width="40px">Status</th>
                                <th class="fw-semibold" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->contracts as $itemContract)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemContract['name']}}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemContract['contractor']['name'] ?? 'S/C'}}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                {{$itemContract['contract']}}
                                            </h6>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="text-center fs-11">
                                            @if($itemContract['status'] == 'Ativo')
                                                <span class="badge bg-success text-white"> {{$itemContract['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemContract['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
{{--                                        @can('edit_company_contract')--}}
                                            <button wire:click.prevent="openModal('registration.company.contracts.form', {'id' : {{$itemContract['id']}} })" class="btn btn-sm btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </button>
{{--                                        @endcan--}}
{{--                                        @can('delete_company_contract')--}}
                                            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemContract}})' >
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
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteContractCompany');
        $('#Vertically').modal('show');
    }
</script>

