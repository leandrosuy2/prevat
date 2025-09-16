<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Contratos Referente ao usuário : {{$user['name']}}</h3>
                    <button wire:click.prevent="openModal('system.users.contracts.form', {'id' : null, 'user_id': {{$user['id']}} })" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Contrato </button>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-semibold w-10">Contrato</th>
                                    <th class="fw-semibold">Contratante</th>
                                    <th class="fw-semibold text-center w-10">Padrão</th>
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
                        {{ data_get($itemContract, 'contract.contract', '—') }}
                    </h6>
                </div>
            </div>
        </td>
        <td>
            <div class="text-left">
                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                    {{ data_get($itemContract, 'contract.contractor.name', '—') }}
                </h6>
            </div>
        </td>
        <td>
            <div class="text-center">
                @if(
                    isset($itemContract['user']['contract_default']) &&
                    isset($itemContract['contract_id']) &&
                    $itemContract['user']['contract_default']['id'] == $itemContract['contract_id']
                )
                    <span class="badge bg-success text-white">Sim</span>
                @else
                    <span class="badge bg-danger text-white">Não</span>
                @endif
            </div>
        </td>
        <td class="text-nowrap text-center">
            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete(@json($itemContract))'>
                <i class="fe fe-trash"></i>
            </button>
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
            $('#confirmDelete').text('confirmDeleteContractUser');
            $('#Vertically').modal('show');
        }
    </script>

