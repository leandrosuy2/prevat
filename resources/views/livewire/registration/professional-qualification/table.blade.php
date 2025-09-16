<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Permissões</h3>
                    @can('add_professional_qualification')
                    <a href=" {{ route('registration.professional-qualification.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Nova formação</a>
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
                            @foreach($response->professionalQualifications as $itemProfessional)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemProfessional['name']}}
                                                </h6>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemProfessional['status'] == 'Ativo')
                                                 <span class="badge bg-success text-white"> {{$itemProfessional['status']}}</span>
                                            @else
                                                 <span class="badge bg-danger text-white"> {{$itemProfessional['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @can('edit_professional_qualification')
                                        <a href="{{ route('registration.professional-qualification.edit', $itemProfessional['id']) }}" class="btn btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete_professional_qualification')
                                        <button class="btn btn-icon btn-danger" onclick='modalDelete({{$itemProfessional}})' >
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
        $('#confirmDelete').text('confirmDeleteProfessionalQ');
        $('#Vertically').modal('show');
    }
</script>

