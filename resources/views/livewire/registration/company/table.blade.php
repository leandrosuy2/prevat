<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Empresas</h3>
                    @can('add_company')
                    <a href=" {{ route('registration.company.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Nova Empresa </a>
                    @endcan
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('registration.company.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-bold fs-11 text-center">Id#</th>
                                <th class="fw-bold fs-11">Nome</th>
                                <th class="fw-bold fs-11">Email</th>
                                <th class="fw-bold fs-11">Dados</th>
                                <th class="fw-bold fs-11">Telefone</th>
                                <th class="fw-bold fs-11">Cadastro</th>
{{--                                <th class="fw-bold fs-11">PART.</th>--}}
                                <th class="fw-bold fs-11" width="40px">Status</th>
                                <th class="fw-bold fs-11 w-9 text-nowrap">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($response->companies as $itemCompany)
                                <tr>
                                    <td class="fw-bold  fs-10 text-center">   {{ $itemCompany['id'] ?? 'S/C'}}</td>
                                    <td>
                                        <div class="d-flex">
                                               <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-10">
                                                    Nome Fantasia : {{$itemCompany['fantasy_name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-10"> {{ $itemCompany['name'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-muted-dark fs-10">   {{ $itemCompany['email'] ?? 'S/C'}}</td>
                                    <td class="no fw-semibold text-muted-dark fs-10">
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-10 text-nowrap">
                                                    CNPJ : {{ $itemCompany['employer_number'] ?? 'S/C' }}
                                                </h6>

                                                CTO : <span class="text-muted fw-semibold fs-10"> {{ $itemCompany['contract_default']['contract'] ?? 'S/C' }}</span>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark text-nowrap fs-10"> {{ $itemCompany['phone']  ?? 'S/C' }}</td>
                                    <td class="fw-semibold text-dark fs-10 text-center"> {{ formatDate($itemCompany['created_at']) }}</td>
                                    <td class="text-nowrap">
                                        <div class="text-center fs-11">
                                            @if($itemCompany['status'] == 'Ativo')
                                                 <span class="badge bg-success text-white"> {{$itemCompany['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemCompany['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        @if($itemCompany['status'] == 'Inativo' && $itemCompany['contracts']->count() == 0)
                                            <button class="btn btn-sm btn-icon btn-primary" wire:click.prevent="openModal('registration.company.activate.form', {'id' : {{$itemCompany['id']}} } )"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Ativar">
                                                <i class="fa fa-bolt"></i>
                                            </button>
                                        @endif
                                        @if($itemCompany['status'] == 'Ativo')
{{--                                            @can('edit_company')--}}
                                        <a href="{{ route('registration.company.contract', $itemCompany['id']) }}" class="btn btn-sm  btn-icon btn-primary"
                                           data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Contratos">
                                            <i class="fe fe-file-text"></i>
                                        </a>
{{--                                            @endcan--}}
                                            @endif

                                        @can('edit_company')
                                            <a href="{{ route('registration.company.edit', $itemCompany['id']) }}" class="btn btn-sm  btn-icon btn-warning"
                                               data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Editar">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_company')
                                            <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemCompany}})'
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Deletar">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        @endcan
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
                            <div class="text-nowrap mt-1">itens de {{ $response->companies->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->companies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(client) {
        console.log(client);
        $('#nomeUsuario').text(client.name);
        $('#idUsuario').text(client.id);
        $('#confirmDelete').text('confirmDeleteCompany');
        $('#Vertically').modal('show');
    }
</script>


