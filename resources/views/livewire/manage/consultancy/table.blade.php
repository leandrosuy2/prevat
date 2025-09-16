<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista das Consultorias Cadastradas</h3>
                    {{--                    @can('add_time')--}}
                    <a href=" {{ route('manage.consultancy.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Cadastrar</a>
                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-bold fs-12">Nome</th>
                                <th class="fw-bold fs-12 w-50">Descrição</th>
                                <th class="fw-bold fs-12" width="40px">Data</th>
                                <th class="fw-bold fs-12" width="40px">Status</th>
                                <th class="fw-bold fs-12" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->consultancies as $itemConsultancy)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if($itemConsultancy['image'])
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('storage/'.$itemConsultancy['image']) }}"></span>
                                            @else
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('images/sem_foto.png')}}"></span>
                                            @endif
                                            <div class="flex-1">
                                                <h6 class="my-4 text-dark fw-bold">
                                                    {{$itemConsultancy['name']}}
                                                </h6>
                                                {{--                                                <span class="text-muted fw-semibold fs-12">{{ $itemConsultancy['category']['name'] ?? 'S/C' }}</span>--}}

                                            </div>
                                        </div>
                                    </td>
                                    <td>

                                                <p class="mb-0 mt-1 text-dark fw-semibold">
                                                    {!! $itemConsultancy['description'] !!}
                                                </p>

                                    </td>
                                    <td>
                                        <div class="text-center">
                                            {{formatDate($itemConsultancy['created_at'])}}

                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemConsultancy['status'] == 'Ativo')
                                                <span class="badge bg-success text-white"> {{$itemConsultancy['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemConsultancy['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{--                                        @can('edit_time')--}}
                                        <a href="{{ route('manage.consultancy.edit', $itemConsultancy['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        {{--                                        @endcan--}}
                                        {{--                                        @can('delete_time')--}}
                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemConsultancy}})' >
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
        $('#confirmDelete').text('confirmDeleteConsultancy');
        $('#Vertically').modal('show');
    }
</script>


