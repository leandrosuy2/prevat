<div>
    <div class="row">
        <div class="col-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title fs-14">Lista de Participantes</h3>
                    </div>

                    <div class="card-body" style="z-index: 5">

                        @include('includes.alerts')

                        @livewire('contractor.schedule-company.participants.filter')

                        <div class="e-table">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered text-dark">
                                    <thead class="text-dark">
                                    <tr>
                                        <th class="fw-bold fs-12">Nome</th>
                                        <th class="fw-bold fs-12">Documentos</th>
                                        <th class="fw-bold fs-12">Empresa</th>
                                        <th class="fw-bold fs-12" width="50px">Presença</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($response->participants as $itemParticipant)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="flex-1">
                                                        <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                            {{$itemParticipant['participant']['name']}}
                                                        </h6>
                                                        <span class="text-muted fw-semibold fs-11"> {{$itemParticipant['participant']['role']['name']}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-semibold text-muted-dark">
                                                <span class="text-muted fw-semibold fs-12">CPF : {{ $itemParticipant['participant']['taxpayer_registration'] }}</span><br>
                                                <span class="text-muted fw-semibold fs-12">CTO : {{ $itemParticipant['participant']['contract']['contract'] ?? 'S/C' }}</span><br>
                                            </td>
                                            <td class="fw-semibold text-dark">
                                                <span class="text-muted fw-semibold fs-11">{{ $itemParticipant['participant']['company']['name'] ?? $itemParticipant['participant']['company']['fantasy_name']}}</span>

                                            </td>

                                            <td class="text-nowrap align-middle text-center">
                                                <div class="text-center">
                                                    @if($itemParticipant['presence'])
                                                        <span class="badge bg-green-dark text-white"> Presente</span>
                                                    @else
                                                        <span class="badge bg-danger text-white"> Ausente</span>
                                                    @endif
                                                </div>
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
                                <div class="text-nowrap mt-1">itens de {{ $response->participants->total() }}</div>
                            </div>

                            <div class="">
                                {{ $response->participants->links() }}
                            </div>
                        </div>
                    </div>
    </div>

        </div>
    </div>
</div>





