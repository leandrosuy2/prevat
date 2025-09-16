<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista das Postagens do Blog</h3>
                    {{--                    @can('add_time')--}}
                    <a href=" {{ route('manage.blog.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Post</a>
                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold fs-12">Titulo</th>
                                <th class="fw-semibold fs-12">Autor</th>
                                <th class="fw-semibold fs-12">Categoria</th>
                                <th class="fw-semibold fs-12" width="40px">Data</th>
                                <th class="fw-semibold fs-12" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->posts as $itemCategory)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if($itemCategory['image'])
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('storage/'.$itemCategory['image']) }}"></span>
                                            @else
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('images/sem_foto.png')}}"></span>
                                            @endif
                                            <div class="flex-1">
                                                <h6 class="my-4 text-dark fw-semibold">
                                                    {{$itemCategory['title']}}
                                                </h6>
{{--                                                <span class="text-muted fw-semibold fs-12">{{ $itemCategory['category']['name'] ?? 'S/C' }}</span>--}}

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemCategory['user']['name']}}
                                                </h6>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemCategory['category']['name']}}
                                                </h6>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            {{formatDate($itemCategory['created_at'])}}

                                        </div>
                                    </td>
                                    <td>
                                        {{--                                        @can('edit_time')--}}
                                        <a href="{{ route('manage.blog.edit', $itemCategory['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        {{--                                        @endcan--}}
                                        {{--                                        @can('delete_time')--}}
                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemCategory}})' >
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
        $('#confirmDelete').text('confirmDeleteBlog');
        $('#Vertically').modal('show');
    }
</script>

