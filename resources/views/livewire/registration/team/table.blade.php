<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista das Turmas</h3>
                    @can('add_time')
                        <a href=" {{ route('registration.team.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Nova Turma</a>
                    @endcan
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold">Nome</th>
                                <th class="fw-semibold" width="40px">Status</th>
                                <th class="fw-semibold" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->teams as $itemTeam)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemTeam['name']}}
                                                </h6>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemTeam['status'] == 'Ativo')
                                                <span class="badge bg-success text-white"> {{$itemTeam['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemTeam['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
{{--                                        @can('edit_time')--}}
                                            <a href="{{ route('registration.team.edit', $itemTeam['id']) }}" class="btn btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </a>
{{--                                        @endcan--}}
{{--                                        @can('delete_time')--}}
                                            <button class="btn btn-icon btn-danger" onclick='modalDelete({{$itemTeam}})' >
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

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteTeam');
        $('#Vertically').modal('show');
    }
</script>
