<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Usuários</h3>
                    @if($response->informations->count() == 0)
                    <a href=" {{ route('manage.information.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Cadastrar </a>
                    @endif
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold">Logo</th>
                                <th class="fw-semibold">Emails</th>
                                <th class="fw-semibold">Telefones</th>
                                <th class="fw-semibold">Links</th>
                                <th class="fw-semibold" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->informations as $itemInformation)

                                <tr>
                                    <td>
                                        @if($itemInformation['logo'])
                                            <img class="img-responsive br-7" src="{{asset('storage/'.$itemInformation['logo']) }}"
                                             alt="Thumb-1">
                                        @else
                                            <img class="img-responsive br-7" src="{{asset('images/sem_foto.png')}}"
                                                 alt="Thumb-1">
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                   Principal : {{$itemInformation['email_01']}}
                                                </h6>
                                                Secundário : <span class="text-muted fw-semibold fs-12">{{ $itemInformation['email_02'] ?? 'Sem Cadastro' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    Principal : {{$itemInformation['phone_01']}}
                                                </h6>
                                                Secundário : <span class="text-muted fw-semibold fs-12">{{ $itemInformation['phone_02'] ?? 'Sem Cadastro' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                @if($itemInformation['link_instagram'])
                                                    <p class="mb-0"> Instagram : <span class="text-muted fw-semibold fs-12">{{ $itemInformation['link_instagram'] ?? 'Sem Cadastro' }}</span></p>
                                                @endif
                                                @if($itemInformation['link_facebook'])
                                                    <p class="mb-0"> Facebook : <span class="text-muted fw-semibold fs-12">{{ $itemInformation['link_facebook'] ?? 'Sem Cadastro' }}</span></p>
                                                @endif
                                                @if($itemInformation['link_twitter'])
                                                    <p class="mb-0"> Twitter : <span class="text-muted fw-semibold fs-12">{{ $itemInformation['link_twitter'] ?? 'Sem Cadastro' }}</span></p>
                                                @endif
                                                @if($itemInformation['link_youtube'])
                                                    <p class="mb-0"> Youtube : <span class="text-muted fw-semibold fs-12">{{ $itemInformation['link_youtube'] ?? 'Sem Cadastro' }}</span></p>
                                                @endif
                                                @if($itemInformation['link_linkedin'])
                                                    <p class="mb-0"> Linkedin : <span class="text-muted fw-semibold fs-12">{{ $itemInformation['link_linkedin'] ?? 'Sem Cadastro' }}</span></p>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('manage.information.edit', $itemInformation['id']) }}" class="btn btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>

                                        <button class="btn btn-icon btn-danger" onclick='modalDelete({{$itemInformation}})' >
                                            <i class="fe fe-trash"></i>
                                        </button>

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
    function modalDelete(client) {
        $('#nomeUsuario').text(client.name);
        $('#idUsuario').text(client.id);
        $('#confirmDelete').text('confirmDeleteInformation');
        $('#Vertically').modal('show');
    }
</script>
