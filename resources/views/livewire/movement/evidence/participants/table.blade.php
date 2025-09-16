<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista dos Participantes do Treinamento : {{$evidence['training_participation']['schedule_prevat']['training']['name']}}</h3>
                    <a href="{{ route('movement.evidence')}}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                       title="Voltar">
                        <i class="fa fa-backward"></i> Voltar
                    </a>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead>
                                <tr class="fs-12">
                                    <th class="text-dark fw-semibold fs-12">Participante</th>
                                    <th class="text-dark fw-semibold fs-12">Documento</th>
                                    <th class="text-dark fw-semibold fs-12">Função</th>
                                    <th class="text-center fw-semibold fs-12">Empresa</th>
                                    <th class="text-center fw-semibold fs-12">CTO</th>
                                    <th class="text-center fw-semibold fs-12">Presença</th>
                                    <th class="text-center fw-semibold fs-12" width="120px">Nota</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->participants as $key => $itemCertificate)
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
                                            <span>{{$itemCertificate['participant']['role']['name']}}</span>
                                        </td>

                                        <td class="text-nowrap align-middle fs-11">
                                            <span>{{$itemCertificate['participant']['company']['name']}}</span>
                                        </td>

                                        <td class="text-nowrap align-middle fs-11">
                                            <span>{{$itemCertificate['participant']['contract']['contract']}}</span>
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

{{--                                        <td class="text-center align-middle">--}}
{{--                                            <button class="btn btn-icon btn-primary" wire:click="download({{$itemCertificate['id']}})" data-bs-toggle="tooltip" data-bs-placement="top"--}}
{{--                                                    title="Download">--}}
{{--                                                <i class="fa fa-download"></i>--}}
{{--                                            </button>--}}
{{--                                        </td>--}}
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
</div>
