<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Contratantes</h3>
                    @can('add_company')
                        <a href=" {{ route('registration.contractors.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Contratante </a>
                    @endcan
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('registration.contractors.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-bold fs-11 text-center">Id#</th>
                                    <th class="fw-bold fs-11">Nome</th>
                                    <th class="fw-bold fs-11">Cnpj</th>
                                    <th class="fw-bold fs-11">Email</th>
                                    <th class="fw-bold fs-11">Telefone</th>
                                    <th class="fw-bold fs-11 text-center">Contrato</th>
                                    <th class="fw-bold fs-11 text-center">Cadastro</th>
                                    <th class="fw-bold fs-11 text-center">Cor</th>
                                    <th class="fw-bold fs-11" width="40px">Status</th>
                                    <th class="fw-bold fs-11 w-9 text-nowrap">Açoes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->contractors as $itemContract)
                                    <tr>
                                        <td class="fw-bold  fs-10 text-center">   {{ $itemContract['id'] ?? 'S/C'}}</td>
                                        <td>  <span class="text-black text-muted-dark fw-bold fs-11"> {{ $itemContract['name'] }}</span>  </td>
                                        <td class="no fw-semibold text-muted-dark fs-10">
                                            <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-10">
                                                CNPJ : {{ $itemContract['employer_number'] ?? 'S/C' }}
                                            </h6>
                                        </td>
                                        <td class="fw-semibold text-muted-dark fs-10">   {{ $itemContract['email'] ?? 'S/C'}}</td>
                                        <td class="fw-semibold text-dark fs-10"> {{ $itemContract['phone']  ?? 'S/C' }}</td>
                                        <td class="fw-semibold text-dark fs-10 text-center"> {{ $itemContract['contract'] ?? 'S/C' }}</td>
                                        <td class="fw-semibold text-dark fs-10 text-center"> {{ formatDate($itemContract['created_at']) }}</td>
                                        <td class="fw-semibold text-dark fs-10 text-center">
                                            @if($itemContract['id'] == 1052)
                                                <div style="background-color: green; width: 20px; height: 20px;"></div>
                                            @elseif($itemContract['id'] == 1053)
                                                <div style="background-color: yellow; width: 20px; height: 20px;"></div>
                                            @elseif($itemContract['id'] == 1054)
                                                <div style="background-color: darkblue; width: 20px; height: 20px;"></div>
                                            @elseif($itemContract['id'] == 1055)
                                                <div style="background-color: red; width: 20px; height: 20px;"></div>
                                            @else
                                                <div style="background-color: black; width: 20px; height: 20px;"></div>
                                            @endif
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
{{--                                            @can('edit_company')--}}
                                                <a href="{{ route('registration.contractors.edit', $itemContract['id']) }}" class="btn btn-sm  btn-icon btn-warning">
                                                    <i class="fe fe-edit"></i>
                                                </a>
{{--                                            @endcan--}}
{{--                                            @can('delete_company')--}}
                                                <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemContract}})' >
                                                    <i class="fe fe-trash"></i>
                                                </button>
{{--                                            @endcan--}}
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
                            <div class="text-nowrap mt-1">itens de {{ $response->contractors->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->contractors->links() }}
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
        $('#confirmDelete').text('confirmDeleteContractor');
        $('#Vertically').modal('show');
    }
</script>


