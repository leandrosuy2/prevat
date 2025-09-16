<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Locais de Treinamentos Cadastrados</h3>
                    @can('add_training_location')
                    <a href=" {{ route('registration.training-location.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Local </a>
                    @endcan
                </div>
                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold" width="50px">Sigla</th>
                                <th class="fw-semibold">Endereço</th>
                                <th class="fw-semibold" width="40px">Status</th>
                                <th class="fw-semibold" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->trainingLocations as $itemTraining)
                                <tr>
                                    <td class="fw-semibold text-dark"> {{ $itemTraining['acronym'] }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemTraining['name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-12">{{ $itemTraining['address'] }} - {{ $itemTraining['number'] ?? 'S/N' }} {{ $itemTraining['complement'] ? ' - '.$itemTraining['complement'] : '' }}  {{ ' - '.$itemTraining['neighborhood'] }} - {{ $itemTraining['zip-code'] }}
                                                - {{$itemTraining['city']}} - {{ $itemTraining['uf'] }}</span>
                                            </div>
                                        </div>
                                    </td>
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
                                        @can('edit_training_location')
                                        <a href="{{ route('registration.training-location.edit', $itemTraining['id']) }}" class="btn btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete_training_location')
                                        <button class="btn btn-icon btn-danger" onclick='modalDelete({{$itemTraining}})' >
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
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteTrainingLocation');
        $('#Vertically').modal('show');
    }
</script>


