<div class="col-sm-12 col-xl-12">
    <div class="card">
        <div class="card-status card-status-left bg-warning br-bl-7 br-tl-7"></div>
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Relaçao dos participantes</h3>

                <button class="btn btn-sm btn-warning {{(in_array($response->order['status_id'], ['3','4'])  ? 'disabled' : '')}}" wire:loading.class.remove="dropdown-toggle" wire:loading.class="btn-loading" wire:target="downloadExcel"
                        wire:click="downloadExcel({{$service_order_id}})" data-bs-toggle="dropdown" aria-expanded="false" >
                    <i   class="fa-solid fa-file-excel"> </i> Exportar Excel <span class="caret"></span>
                </button>
            </div>
            <div class="card-body">
                <div class="e-table">
                    @livewire('financial.service-order.view.participants.filter')
                    <div class="table-responsive table-lg">
                        <table class="table table-bordered text-dark">
                            <thead class="text-dark">
                            <tr>
                                <th class="fw-bold fs-12">Nome</th>
                                <th class="fw-bold fs-12">Documentos</th>
                                <th class="fw-bold fs-12">Treinamento</th>
                                <th class="fw-bold fs-12">Data</th>
                                <th class="fw-bold fs-12 w-9 text-center">Qtde.</th>
                                <th class="fw-bold fs-12 w-10 text-center">Valor</th>
                                <th class="fw-bold fs-12 w-10 text-center">Valor Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($response->participants as $key => $itemParticipant)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                    {{$itemParticipant['participant']['name']}}
                                                </h6>
    {{--                                            <span class="text-muted fw-semibold fs-11"> {{$itemParticipant['participant']['role']['name']}}</span>--}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-muted-dark">
                                        <span class="text-dark fw-semibold fs-11">CPF : {{ $itemParticipant['participant']['taxpayer_registration'] }}</span><br>
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        <span class="text-dark fw-semibold fs-11">{{ $itemParticipant['schedule_company']['schedule']['training']['name']}}</span>
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        <span class="text-dark fw-semibold fs-11">{{ formatDate($itemParticipant['schedule_company']['schedule']['date_event'])}}</span>
                                    </td>
                                    <td class="text-center">
                                        @if((in_array($response->order['status_id'], ['3','4']) ))
                                            <span class="text-dark fw-semibold fs-11">{{formatNumber($itemParticipant['quantity'])}}</span>

                                        @else
                                            <input type="number" min="0" max="10" wire:model.live="quantity.{{$key}}" class="form-control form-control-sm " >
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="text-dark fw-semibold fs-11">{{formatMoney($itemParticipant['value'])}}</span>
                                    </td>

                                    <td class="text-center">
                                        <span class="text-dark fw-semibold fs-11">{{formatMoney($itemParticipant['total_value'])}}</span>
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
