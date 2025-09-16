<div class="col-sm-12 col-xl-7">
    <div class="card">
        <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title fs-14">Relação dos treinamentos</h3>
                <div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle {{(in_array($response->order['status_id'], ['3','4'])  ? 'disabled' : '')}}" data-bs-toggle="dropdown">
                            <i class="fe fe-calendar"> Itens</i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0)" wire:click.prevent="openModal('financial.service-order.view.releases.form', { 'id' : {{$response->order['company_id']}}, 'contract_id' : {{$response->order['contract_id']}}, 'service_order_id' : {{$response->order['id'] ?? 'null'}} })">Adicionar Treinamentos</a>
                            <a class="dropdown-item" href="javascript:void(0)" wire:click="openSmallModal('financial.service-order.view.releases.discount.form', { 'id' : {{$response->order['id']}} })">Descontos</a>
                            <a class="dropdown-item" href="javascript:void(0)">Taxas e Impostos</a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="card-body h-240">
            <div class="e-table table-striped">
                <div class="table-responsive table-lg">
                    <div class="content scroll-1 h-200">
                        <table class="table table-bordered text-dark">
                        <thead class="text-dark">
                        <tr>
                            <th class="fw-bold fs-11 w-5" >item</th>
                            <th class="fw-bold fs-11">Treinamento</th>
                            <th class="fw-bold fs-11 text-center">Qtd.</th>
                            <th class="fw-bold fs-11" width="40px">Valor</th>
                            <th class="fw-bold fs-11" width="40px">subtotal</th>
                            <th class="fw-bold fs-11" width="40px">Ações</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($response->releases as $key => $itemRelease)
                            <tr wire:key="{{ $itemRelease->id }}">
                                <td class="fw-semibold text-dark text-center fs-11"> {{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="flex-1">
                                            <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                {{ $itemRelease['schedule_company']['schedule']['training']['name'] ?? '' }}
                                            </h6>
                                        </div>
                                    </div>
                                </td>

                                <td class="fw-semibold text-dark text-center fs-11"> {{ $itemRelease['schedule_company']['participantsPresent']->sum('quantity') }}</td>
                                <td class="fw-semibold text-dark text-center fs-11 text-nowrap"> {{ formatMoney($itemRelease['schedule_company']['price']) }} </td>
                                <td class="fw-semibold text-dark text-center fs-11 text-nowrap"> {{ formatMoney($itemRelease['schedule_company']['price_total']) }}</td>
                                <td class="text-nowrap">
                                    <button wire:click="openSmallModal('financial.service-order.view.releases.price.form', { 'id' : {{$itemRelease['id']}} })" class="btn btn-sm btn-icon btn-info {{(in_array($response->order['status_id'], ['3','4'])  ? 'disabled' : '')}}">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-danger {{(in_array($response->order['status_id'], ['3','4'])  ? 'disabled' : '')}}" wire:click="confirmDelete({{$itemRelease['id']}})" >
                                        <i class="fe fe-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                            <tfoot>
                            <tr>
                                <th class="fw-bold fs-11 w-5" ></th>
                                <th class="fw-bold fs-11">SUBTOTAL</th>
                                <th class="fw-bold fs-11 text-center"></th>
                                <th class="fw-bold fs-11" width="40px"></th>
                                <th class="fw-bold fs-11 text-nowrap" width="40px">{{formatMoney($response->order['total_releases'])}}</th>
                                <th class="fw-bold fs-11" width="40px"></th>
                            </tr>
                            <tr>
                                <th class="fw-bold fs-11 w-5" ></th>
                                <th class="fw-bold fs-11">DESCONTOS</th>
                                <th class="fw-bold fs-11 text-center"></th>
                                <th class="fw-bold fs-11" width="40px">
                                    @if($response->order['percentage_discount'])
                                    {{formatPercentage($response->order['percentage_discount'])}}
                                    @endif
                                </th>
                                <th class="fw-bold fs-11 text-nowrap" width="40px">{{formatMoney($response->order['total_discounts'] )}}</th>
                                <th class="fw-bold fs-11" width="40px"></th>
                            </tr>
                            <tr>
                                <th class="fw-bold fs-11 w-5" ></th>
                                <th class="fw-bold fs-11">TOTAL</th>
                                <th class="fw-bold fs-11 text-center"></th>
                                <th class="fw-bold fs-11" width="40px"></th>
                                <th class="fw-bold fs-11 text-nowrap" width="40px">{{formatMoney($response->order['total_value'])}}</th>
                                <th class="fw-bold fs-11" width="40px"></th>
                            </tr>
                            </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center  br-br-7 br-bl-7">
            <div >Valor Total :</div>
            <div> {{ formatMoney($response->order['total_value'])}}</div>
        </div>
    </div>
</div>
@section('scripts')

    <!-- PERFECT-SCROLLBAR JS  -->
    <script src="{{asset('build/assets/plugins/pscrollbar/p-scroll-3.js')}}"></script>

@endsection
