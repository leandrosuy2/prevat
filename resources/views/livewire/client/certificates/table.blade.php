<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Certificados Gerados</h3>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-semibold">Data</th>
                                <th class="fw-semibold">Treinamento</th>
                                <th class="fw-semibold" width="30px">Açoes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->evidences as $itemEvidence)
                                <tr>
                                    <td class="fw-semibold text-dark"> {{ formatDate($itemEvidence['date'] )}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                    {{$itemEvidence['training_participation']['schedule_prevat']['training']['acronym']}} -
                                                    {{$itemEvidence['training_participation']['schedule_prevat']['training']['name']}}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('client.certificates.participants', $itemEvidence['id']) }}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                           title="Participantes">
                                            <i class="fa fa-users"></i>
                                        </a>
                                        @if($itemEvidence['file_path'])
                                            <button wire:click="download({{$itemEvidence['id']}})" class="btn btn-sm btn-icon btn-success"  data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="Download">
                                                <i class="fe fe-download"></i>
                                            </button>
                                        @endif
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
</div>
