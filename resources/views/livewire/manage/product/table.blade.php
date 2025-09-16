<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista dos Produtos Cadastrados</h3>
                    {{--                    @can('add_time')--}}
                    <a href=" {{ route('manage.product.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Produto</a>
                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold fs-12">Nome</th>
                                <th class="fw-semibold fs-12" width="40px">Status</th>
                                <th class="fw-semibold fs-12" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->products as $itemProduct)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if($itemProduct['image'])
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('storage/'.$itemProduct['image']) }}"></span>
                                            @else
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('images/sem_foto.png')}}"></span>
                                            @endif
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemProduct['name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-12">{{ $itemProduct['category']['name'] ?? 'S/C' }}</span>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemProduct['status'] == 'Ativo')
                                                <span class="badge bg-success text-white"> {{$itemProduct['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemProduct['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('manage.product.images', $itemProduct['id']) }}" class="btn btn-icon btn-cyan">
                                            <i class="fe fe-image"></i>
                                        </a>
                                        {{--                                        @can('edit_time')--}}
                                        <a href="{{ route('manage.product.edit', $itemProduct['id']) }}" class="btn btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        {{--                                        @endcan--}}

                                        {{--                                        @can('delete_time')--}}
                                        <button class="btn btn-icon btn-danger" onclick='modalDelete({{$itemProduct}})' >
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
        $('#confirmDelete').text('confirmDeleteProduct');
        $('#Vertically').modal('show');
    }
</script>


