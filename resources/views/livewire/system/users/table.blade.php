<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Usuários</h3>
                    @if(auth()->user()->company->type == 'admin')
                        <a href=" {{ route('users.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Usuario </a>
                    @else
                        <a href=" {{ route('users.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Novo Usuario </a>
                    @endif
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('system.users.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold">Nome</th>
                                <th class="fw-semibold">Email</th>
                                <th class="fw-semibold">Documento</th>
                                <th class="fw-semibold">Telefone</th>
                                <th class="fw-semibold" width="40px">Status</th>
                                @if(auth()->user()->company->type == 'admin')
                                    <th class="fw-semibold" width="40px">Notificações</th>
                                @endif
                                <th class="fw-semibold" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if($user['profile_photo_path'])
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('storage/'.$user['profile_photo_path']) }}"></span>
                                            @else
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('images/user-default.png')}}"></span>
                                            @endif
                                                <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$user['name']}}
                                                </h6>
                                                    @if(auth()->user()->company->type == 'admin')
                                                <span class="text-muted fw-semibold fs-12">{{ $user['role']['name'] ?? 'Sem Função' }}</span>
                                                        @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-muted-dark">   {{ $user['email'] }}</td>
                                    <td class="fw-semibold text-muted-dark">   {{ $user['document'] }}</td>
                                    <td class="fw-semibold text-dark"> {{ $user['phone'] }}</td>
                                    <td>
                                        <div class="text-center">
                                            @if($user['status'] == 'Ativo')
                                                 <span class="badge bg-success text-white"> {{$user['status']}}</span>
                                            @else
                                                 <span class="badge bg-danger text-white"> {{$user['status']}}</span>
                                            @endif
                                       </div>
                                    </td>
                                    @if(auth()->user()->company->type == 'admin')
                                        <td>
                                            <div class="text-center">
                                                @if($user['notifications'] == 'Ativo')
                                                    <span class="badge bg-success text-white"> {{$user['status']}}</span>
                                                @else
                                                    <span class="badge bg-danger text-white"> {{$user['status']}}</span>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                    <td class="text-nowrap">

                                        @if(auth()->user()->company->type == 'client')
                                            <a href="{{ route('users.contracts', $user['id']) }}" class="btn btn-sm  btn-icon btn-primary"
                                               data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Contratos">
                                                <i class="fe fe-file-text"></i>
                                            </a>
                                        @endif

                                        @if(auth()->user()->company->type == 'admin')
                                            <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        @endif

                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$user}})' >
                                            <i class="fe fe-trash"></i>
                                        </button>
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
                            <div class="text-nowrap mt-1">itens de {{ $response->users->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->users->links() }}
                        </div>
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
        $('#confirmDelete').text('confirmDeleteUser');
        $('#Vertically').modal('show');
    }
</script>
