<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Relatório Treinamento do participantes</h3>
                    <div class="">
                        @if($filters)
                            <button wire:click.prevent="exportExcel()" class="btn btn-sm btn-icon btn-orange" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Voltar" wire:loading.class="btn-loading ">
                                <i wire:target="exportExcel()" wire:loading.remove class="fa-solid fa-file-excel"></i> Exportar Excel
                            </button>

                            <button wire:click="exportPDF()" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Voltar" wire:loading.class="btn-loading">
                                <i wire:target="exportPDF()" wire:loading.remove class="fa-solid fa-file-pdf"></i> Exportar PDF
                            </button>
                        @endif
                    </div>
                </div>

                <div class="card-body" style="z-index: 5;">

                    @include('includes.alerts')

                    @livewire('client.report.participants.filter')

                    <div wire:loading wire:target="filterTableReportTrainingParticipantsClient">
                        Removing post...
                    </div>

                    @if($visible)
                        <div class="e-table">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered text-dark">
                                    <thead>
                                    <tr class="fs-12">
                                        <th class="text-dark fw-semibold fs-12">Participante</th>
                                        <th class="text-dark fw-semibold fs-12">Documento</th>
                                        <th class="text-dark fw-semibold fs-12">Treinamento</th>
                                        <th class="text-center fw-semibold fs-12">Data</th>
                                        <th class="text-center fw-semibold fs-12">Empresa</th>
                                        <th class="text-center fw-semibold fs-12">CTO</th>
                                        <th class="text-center fw-semibold fs-12">Presença</th>
                                        <th class="text-center fw-semibold fs-12" width="120px">Nota</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($response->participantsTraining as $key => $itemCertificate)
                                        <tr>
                                            <td class="text-nowrap">
                                                <div class="flex-1 my-auto">
                                                    <h6 class="mb-0 fw-semibold fs-11">
                                                        <i class="fas fa-graduation-cap "></i> {{$itemCertificate['participant']['name']}}
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCertificate['participant']['taxpayer_registration']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCertificate['training_participation']['schedule_prevat']['training']['name']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{formatDate($itemCertificate['training_participation']['schedule_prevat']['date_event'])}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                {{mb_strimwidth($itemCertificate['participant']['company']['name'], 0, 20, "...")}}

                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCertificate['participant']['contract']['contractor_id']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle text-center  fs-11">
                                                <div class="text-center">
                                                    @if($itemCertificate['presence'])
                                                        <span class="badge bg-primary text-white"> Sim</span>
                                                    @else
                                                        <span class="badge bg-danger text-white"> Não</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="text-nowrap align-middle text-center  fs-11">
                                                <span>{{$itemCertificate['note'] ?? 'S/N'}}</span>
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
                                <div class="text-nowrap mt-1">itens de {{ $response->participantsTraining->total() }}</div>
                            </div>

                            <div class="">
                                {{ $response->participantsTraining->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

