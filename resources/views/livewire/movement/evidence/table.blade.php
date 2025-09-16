<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista da Evidências Cadastradas</h3>
                    {{--                    @can('add_professional')--}}
                    <a href=" {{ route('movement.evidence.create') }}" class="fw-semibold btn btn-sm btn-primary"> <i class="fe fe-plus-circle"></i> Cadastrar </a>
                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('movement.evidence.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-bold fs-12">Referencia</th>
                                <th class="fw-bold fs-12">Data
                                    <span style="cursor:pointer; margin-left:4px;" wire:click="toggleOrderByDate">
                                        @if(isset($order) && $order['column'] === 'date')
                                            @if($order['order'] === 'ASC')
                                                <i class="fa fa-sort-up text-primary"></i>
                                            @else
                                                <i class="fa fa-sort-down text-primary"></i>
                                            @endif
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </span>
                                </th>
                                <th class="fw-bold fs-12">Empresa</th>
                                <th class="fw-bold fs-12">Treinamento</th>
                                <th class="fw-bold fs-12" width="40px">Status</th>
                                <th class="fw-bold fs-12" width="30px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                if (!function_exists('removerAcentos')) {
                                    function removerAcentos($string) {
                                        return strtr($string, [
                                            'á'=>'a','à'=>'a','ã'=>'a','â'=>'a','ä'=>'a',
                                            'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
                                            'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
                                            'ó'=>'o','ò'=>'o','õ'=>'o','ô'=>'o','ö'=>'o',
                                            'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
                                            'ç'=>'c','Á'=>'a','À'=>'a','Ã'=>'a','Â'=>'a','Ä'=>'a',
                                            'É'=>'e','È'=>'e','Ê'=>'e','Ë'=>'e',
                                            'Í'=>'i','Ì'=>'i','Î'=>'i','Ï'=>'i',
                                            'Ó'=>'o','Ò'=>'o','Õ'=>'o','Ô'=>'o','Ö'=>'o',
                                            'Ú'=>'u','Ù'=>'u','Û'=>'u','Ü'=>'u',
                                            'Ç'=>'c'
                                        ]);
                                    }
                                }
                            @endphp
                            @foreach($response->evidences as $itemEvidence)
                                <tr>
                                    <td class="fw-semibold text-dark fs-12"> {{ $itemEvidence['reference'] }}</td>
                                    <td class="fw-semibold text-dark fs-12"> {{ formatDate($itemEvidence['date'] )}}</td>
                                    <td class="fw-semibold text-dark fs-12"> {{ $itemEvidence['company']['name'] ?? $itemEvidence['company']['fantasy_name'] }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold  fs-12">
                                                    {{$itemEvidence['training_participation']['schedule_prevat']['training']['acronym']}} -
                                                    {{$itemEvidence['training_participation']['schedule_prevat']['training']['name']}}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if($itemEvidence['status'] == 'Ativo')
                                                <span class="badge bg-success text-white"> {{$itemEvidence['status']}}</span>
                                            @else
                                                <span class="badge bg-danger text-white"> {{$itemEvidence['status']}}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        @if($itemEvidence['file_path'])
                                            @php
                                                $nomeCurso = removerAcentos(strtolower(trim($itemEvidence['training_participation']['schedule_prevat']['training']['name'] ?? '')));
                                            @endphp
                                            @if(
                                                str_contains($nomeCurso, 'brigada') &&
                                                str_contains($nomeCurso, 'incendio') &&
                                                str_contains($nomeCurso, 'cfbi') &&
                                                str_contains($nomeCurso, 'nivel basico')
                                            )
                                                <button wire:click="openDownloadModal({{$itemEvidence['id']}})" class="btn btn-sm btn-icon btn-success"  data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="Download">
                                                    <i class="fe fe-download"></i>
                                                </button>
                                            @else
                                                <button wire:click="downloadPDF({{$itemEvidence['id']}})" class="btn btn-sm btn-icon btn-success"  data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="Download">
                                                    <i class="fe fe-download"></i>
                                                </button>
                                            @endif
                                        @endif

                                        <a href="{{ route('movement.evidence.historic', $itemEvidence['id']) }}" class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Historico de Downloads">
                                            <i class="fa fa-file-lines"></i>
                                        </a>

                                        <a href="{{ route('movement.evidence.participants', $itemEvidence['id']) }}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Participantes">
                                            <i class="fa fa-users"></i>
                                        </a>

                                        {{--                                        @can('edit_professional')--}}
                                        <a href="{{ route('movement.evidence.edit', $itemEvidence['id']) }}" class="btn btn-sm btn-icon btn-warning"  data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Editar">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        {{--                                        @endcan--}}
                                        {{--                                        @can('delete_professional')--}}
                                        <button class="btn btn-sm btn-icon btn-danger" onclick='modalDelete({{$itemEvidence}})'  data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Apagar">
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex col-md-12 col-xl-2 align-items-center">

                            <label for="firstName" class="col-md-6 form-label text-nowrap mt-2">Mostrando</label>
                            <div class="col-md-9">
                                <x-select2 wire:model.live="pageSize" placeholder="Select Members" class=" select2 form-select">
                                    <option value="10" selected>10</option>
                                    <option value="25">20</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </x-select2>
                            </div>
                            <div class="text-nowrap mt-1">itens de {{ $response->evidences->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->evidences->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Remover o modal de Dados do Certificado e o push de scripts relacionados -->

<script type="text/javascript">
    function modalDelete(data) {
        $('#nomeUsuario').text(data.name);
        $('#idUsuario').text(data.id);
        $('#confirmDelete').text('confirmDeleteEvidence');
        $('#Vertically').modal('show');
    }
</script>

<!-- Modal para dados do certificado -->
<div wire:ignore.self class="modal fade" id="modalDownloadCertificado" tabindex="-1" aria-labelledby="modalDownloadCertificadoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDownloadCertificadoLabel">Dados do Certificado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="licenca_numero" class="form-label">Certificado de Licenciamento Nº</label>
                    <input type="text" wire:model.defer="licenca_numero" class="form-control" id="licenca_numero">
                </div>
                <div class="mb-3">
                    <label for="licenca_validade" class="form-label">Validade</label>
                    <input type="date" wire:model.defer="licenca_validade" class="form-control" id="licenca_validade">
                </div>
                <div class="mb-3">
                    <label for="licenca_protocolo" class="form-label">Nº do Protocolo</label>
                    <input type="text" wire:model.defer="licenca_protocolo" class="form-control" id="licenca_protocolo">
                </div>
                {{-- Removido campo de upload de QR Code do atestado, pois agora é gerado automaticamente --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" wire:click="downloadPDFWithData" wire:loading.attr="disabled" wire:target="downloadPDFWithData, qrcode_atestado" class="btn btn-primary">
                    Gerar PDF
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.addEventListener('openDownloadModal', event => {
        $('#modalDownloadCertificado').modal('show');
    });
    window.addEventListener('closeDownloadModal', event => {
        $('#modalDownloadCertificado').modal('hide');
    });
</script>
@endpush



