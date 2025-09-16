<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center m-0">
                    <h3 class="card-title fs-14">Historico do Participante : {{$participant['name']}}</h3>
                    {{--                    <a href=" {{ route('registration.participant') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Voltar </a>--}}
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('registration.participant.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-bold  fs-12">Treinamento</th>
                                    <th class="fw-bold fs-12 text-center">Qtde.</th>
                                    <th class="fw-bold fs-12 text-center">Valor</th>
                                    <th class="fw-bold fs-12 text-center">Total</th>
                                    <th class="fw-bold fs-12" width="40px text-center">Nota</th>
                                    <th class="fw-bold fs-12 w-10 text-center" >status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->historics as $itemHistoric)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <h6 class="mb-0 mt-1 text-black fw-semibold fs-12">
                                                        {{$itemHistoric['training_participation']['schedule_prevat']['training']['name']}}
                                                    </h6>
                                                    {{--                                                    <span class="text-muted fw-semibold fs-12"> {{$itemHistoric['role']['name']}}</span>--}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-muted-dark text-nowrap text-center">
                                            <span class=" fw-semibold fs-12">{{ $itemHistoric['quantity'] }}</span>
                                        </td>
                                        <td class="fw-semibold text-dark  text-center">
                                            <span class=" fw-semibold fs-12">{{ formatMoney($itemHistoric['value'] )}}</span>
                                        </td>

                                        <td class="fw-semibold text-dark text-center">
                                            <span class=" fw-semibold fs-12">{{ formatMoney($itemHistoric['total_value'] )}}</span>
                                        </td>

                                        <td class="fw-semibold text-dark text-center">
                                            <span class=" fw-semibold fs-12">{{ $itemHistoric['note'] }}</span>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                @if($itemHistoric['status'] == 'Ativo')
                                                    <span class="badge bg-success text-white"> {{$itemHistoric['status']}}</span>
                                                @else
                                                    <span class="badge bg-danger text-white"> {{$itemHistoric['status']}}</span>
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
                            <div class="text-nowrap mt-1">itens de {{ $response->historics->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->historics->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
