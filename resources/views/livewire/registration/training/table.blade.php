<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Treinamentos Cadastrados</h3>
                    @can('add_training')
                    <a href=" {{ route('registration.training.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Treinamento </a>
                    @endcan
                </div>
                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('registration.training.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold fs-11" width="50px">Categoria</th>
                                <th class="fw-semibold fs-11">Nome</th>
                                <th class="fw-semibold fs-11" width="90px">Valor</th>
                                <th class="fw-semibold fs-11" width="40px">Status</th>
                                <th class="fw-semibold fs-11 w-9">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->trainings as $itemTraining)
                                <tr>
                                    <td class="fw-bold text-dark fs-11 text-nowrap"> {{ $itemTraining['acronym'] }}</td>
                                    <td class="fw-bold text-dark fs-11"> {{$itemTraining['name']}} </td>
                                    <td class="fw-semibold text-dark fs-11"> {{ formatMoney($itemTraining['value'])  }}</td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemTraining['status'] == 'Ativo')
                                                <span class="badge bg-success text-white"> {{$itemTraining['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemTraining['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @can('edit_training')
                                        <a href="{{ route('registration.training.edit', $itemTraining['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete_training')
                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemTraining}})' >
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
                            <div class="text-nowrap mt-1">itens de {{ $response->trainings->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->trainings->links() }}
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
        $('#confirmDelete').text('confirmDeleteTraining');
        $('#Vertically').modal('show');
    }
</script>


