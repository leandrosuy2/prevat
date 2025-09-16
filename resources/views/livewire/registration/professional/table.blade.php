<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de profissionais cadastrados</h3>
                    @can('add_professional')
                    <a href=" {{ route('registration.professional.create') }}" class="fw-semibold btn btn-sm btn-primary"> <i class="fe fe-plus-circle"></i> Novo Profissional </a>
                    @endcan
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('registration.professional.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold fs-11">Nome</th>
                                <th class="fw-semibold fs-11">Registro</th>
                                <th class="fw-semibold fs-11">Telefone</th>
                                <th class="fw-semibold fs-11">Formações</th>
                                <th class="fw-semibold fs-11" width="40px">Status</th>
                                <th class="fw-semibold fs-11" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->professionals as $itemProfessional)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if($itemProfessional['signature_image'])
                                                <ul id="lightgallery" class="">
                                                <span class="avatar avatar-md me-3"
                                                      data-responsive="{{asset('storage/'.$itemProfessional['signature_image']) }}"
                                                      data-src="{{asset('storage/'.$itemProfessional['signature_image']) }}"
                                                      data-sub-html="<h4>{{$itemProfessional['name']}}</h4><p> Assinatura atualizada em {{formatDate($itemProfessional['updated_at'])}}</p>">
                                                    <a href="javascript:void(0)">
                                                    <img alt="signature" class=" cover-image br-7" src="{{asset('storage/'.$itemProfessional['signature_image']) }}">
                                                    </a>
                                                </span>
                                                </ul>
                                            @else
                                                <span class="avatar avatar-md me-3 fs-11"><img alt="user-image" class=" cover-image br-7" src="{{asset('images/sem-imagem.png')}}"></span>
                                            @endif
                                            <div class="flex-1 fs-11">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-11">
                                                    {{$itemProfessional['name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-11">{{ $itemProfessional['email'] ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark fs-11"> {{ $itemProfessional['registry'] ?? 'Sem Cadastro' }}</td>
                                    <td class="fw-semibold text-dark fs-11"> {{ $itemProfessional['phone'] ?? 'Sem Cadastro' }}</td>
                                    <td>
                                        <div class="flex-column">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-11">
                                                    @if($itemProfessional['formations'])
                                                        @foreach($itemProfessional['formations'] as $itemFormation)
                                                            {{$itemFormation['qualification']['name']}}</br>
                                                        @endforeach
                                                    @endif
                                                </h6>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemProfessional['status'] == 'Ativo')
                                                <span class="badge bg-success text-white fs-11"> {{$itemProfessional['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white fs-11"> {{$itemProfessional['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        @can('edit_professional')
                                        <a href="{{ route('registration.professional.edit', $itemProfessional['id']) }}" class="btn btn-sm btn-icon btn-warning">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete_professional')
                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemProfessional}})' >
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
                            <div class="text-nowrap mt-1">itens de {{ $response->professionals->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->professionals->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@section('scripts')

    <!-- GALLERY JS -->
    <script src="{{asset('build/assets/plugins/gallery/picturefill.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lightgallery.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lightgallery-1.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lg-pager.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lg-autoplay.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lg-fullscreen.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lg-zoom.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lg-hash.js')}}"></script>
    <script src="{{asset('build/assets/plugins/gallery/lg-share.js')}}"></script>

@endsection

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteProfessional');
        $('#Vertically').modal('show');
    }
</script>

