<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de profissionais cadastrados</h3>
                    @can('add_professional')
                        <a href=" {{ route('registration.technical-manager.create') }}" class="fw-semibold btn btn-sm btn-primary"> <i class="fe fe-plus-circle"></i> Novo Responsável Técnico </a>
                    @endcan
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="table-responsive">
                        <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold">Nome</th>
                                <th class="fw-semibold">Registro</th>
                                <th class="fw-semibold">Telefone</th>
                                <th class="fw-semibold">Formação</th>
                                <th class="fw-semibold" width="40px">Status</th>
                                <th class="fw-semibold" width="50px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->technicals as $itemTechnical)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if($itemTechnical['signature_image'])
                                                <ul id="lightgallery" class="m-0">
                                                <span class="avatar avatar-lg me-3"
                                                      data-responsive="{{asset('storage/'.$itemTechnical['signature_image']) }}"
                                                      data-src="{{asset('storage/'.$itemTechnical['signature_image']) }}"
                                                      data-sub-html="<h4>{{$itemTechnical['name']}}</h4><p> Assinatura atualizada em {{formatDate($itemTechnical['updated_at'])}}</p>">
                                                    <a href="javascript:void(0)">
                                                    <img alt="signature" class=" cover-image " src="{{asset('storage/'.$itemTechnical['signature_image']) }}">
                                                    </a>
                                                </span>
                                                </ul>
                                            @else
                                                <span class="avatar avatar-md me-3"><img alt="user-image" class=" cover-image br-7" src="{{asset('images/sem-imagem.png')}}"></span>
                                            @endif
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-3 text-dark fw-semibold">
                                                    {{$itemTechnical['name']}}
                                                </h6>
                                                <span class="text-muted fw-semibold fs-12">{{ $itemTechnical['email'] ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark"> {{ $itemTechnical['registry'] ?? 'Sem Cadastro' }}</td>
                                    <td class="fw-semibold text-dark"> {{ $itemTechnical['phone'] ?? 'Sem Cadastro' }}</td>
                                    <td>
                                        <div class="flex-column">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemTechnical['formation']}}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemTechnical['status'] == 'Ativo')
                                                <span class="badge bg-success text-white"> {{$itemTechnical['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemTechnical['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @can('edit_professional')
                                            <a href="{{ route('registration.technical-manager.edit', $itemTechnical['id']) }}" class="btn btn-icon btn-warning">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete_professional')
                                            <button class="btn btn-icon btn-danger" onclick='modalDelete({{$itemTechnical}})' >
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
        $('#confirmDelete').text('confirmDeleteTechnicalManager');
        $('#Vertically').modal('show');
    }
</script>


