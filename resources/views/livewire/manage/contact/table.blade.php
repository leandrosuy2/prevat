<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista dos Contatos do Site</h3>
                    {{--                    @can('add_time')--}}
                    <a href=" {{ route('manage.contact.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Contato</a>
                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold fs-12">Contato</th>
                                <th class="fw-semibold fs-12" width="40px">Whatsapp</th>
                                <th class="fw-semibold fs-12" width="40px">Email</th>
                                <th class="fw-semibold fs-12" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->contacts as $itemContact)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-bold">
                                                    {{$itemContact['name']}}
                                                </h6>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemContact['whatsapp01'])
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    Whatsapp 01 : {{$itemContact['whatsapp01']}}
                                                </h6>
                                            @endif
                                            @if($itemContact['whatsapp01'])
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    Whatsapp 02 : {{$itemContact['whatsapp01']}}
                                                </h6>
                                            @endif

                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-left">
                                            @if($itemContact['email01'])
                                                <h6 class="mb-0 mt-1v  text-dark fw-semibold">
                                                    Email 01 : {{$itemContact['email01']}}
                                                </h6>
                                            @endif
                                            @if($itemContact['email02'])
                                                <h6 class="mb-0 mt-1v  text-dark fw-semibold">
                                                    Email 02 : {{$itemContact['email02']}}
                                                </h6>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        {{--                                        @can('edit_time')--}}
                                        <a href="{{ route('manage.contact.edit', $itemContact['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        {{--                                        @endcan--}}
                                        {{--                                        @can('delete_time')--}}
                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemContact}})' >
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
        $('#confirmDelete').text('confirmDeleteContact');
        $('#Vertically').modal('show');
    }
</script>


