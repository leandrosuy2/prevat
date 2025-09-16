<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center m-0">
                    <h3 class="card-title fs-14">Lista das ordens de serviço</h3>

                    {{--                        @can('add_participant')--}}
                    <a href=" {{ route('financial.service-order.create') }}" class="fw-semibold btn btn-sm btn-primary"><i class="fe fe-plus-circle"></i> Nova ordem de serviço </a>
                    {{--                        @endcan--}}

                </div>

                <div class="card-body" style="z-index: 5">

                    <div wire:loading.class="opacity-100 ">
                        <div  wire:loading id="global-loader" >
                            <img src="{{asset('build/assets/images/svgs/loader.svg')}}" alt="loader">
                        </div>
                    </div>

                    @include('includes.alerts')

                    @livewire('financial.service-order.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-semibold w-5">ID</th>
                                    <th class="fw-semibold">EMPRESA</th>
                                    <th class="fw-semibold text-center">CTO</th>
                                    <th class="fw-semibold text-center">Valor</th>
                                    <th class="fw-semibold" width="40px">VENCIMENTO</th>
                                    <th class="fw-semibold text-center" width="40px">STATUS</th>
                                    <th class="fw-semibold text-center" width="40px">AUTOR</th>
                                    <th class="fw-semibold text-center" width="40px">CADASTRO</th>
                                    <th class="fw-semibold text-center w-10" >Açoes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->serviceOrders as $itemServiceOrder)
                                    <tr>
                                        <td class="fw-semibold text-dark text-center fs-11"> {{ $itemServiceOrder['id'] }}</td>

                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <h6 class="mb-0 mt-1 text-dark fw-semibold fs-12">
                                                        {{$itemServiceOrder['company']['name']}}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-dark text-center fs-11"> {{ $itemServiceOrder['contract']['contract'] }}</td>
                                        <td class="fw-semibold text-dark text-center fs-11"> {{ formatMoney($itemServiceOrder['total_value']) }}</td>
                                        <td class="fw-semibold text-dark text-center fs-11"> {{ formatDate($itemServiceOrder['due_date']) }}</td>

                                        <td>
                                            <div class="text-center">
                                                <span class="badge {{{$itemServiceOrder['status']['color']}}} text-white"> {{$itemServiceOrder['status']['name']}}</span>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-dark text-center fs-11 text-nowrap"> {{ $itemServiceOrder['user']['name'] }}</td>
                                        <td class="fw-semibold text-dark text-center fs-11 text-nowrap"> {{ formatDateAndTime($itemServiceOrder['created_at']) }}</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('financial.service-order.view', $itemServiceOrder['id']) }}" class="btn btn-sm btn-icon btn-info">
                                                <i class="fe fe-eye"></i>
                                            </a>

                                            <button class="btn btn-sm btn-icon btn-danger {{(in_array($itemServiceOrder['status_id'], ['3','2'])  ? 'disabled' : '')}}" wire:click="confirmDelete({{$itemServiceOrder['id']}})" >
                                                <i class="fe fe-trash"></i>
                                            </button>

                                            <div class="dropstart btn-group mt-2 mb-2">
                                                <button class="btn btn-sm btn-dark dropdown-toggle {{(in_array($itemServiceOrder['status_id'], ['3','4'])  ? 'disabled' : '')}}" type="button"
                                                        data-bs-toggle="dropdown"> <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0)" wire:click.prevent="sendEmail({{$itemServiceOrder['id']}})"> <i class="fa-regular fa-envelope"></i> Enviar E-mail</a></li>
                                                    <li><a href="#"> <i class="fa-brands fa-whatsapp"></i> Enviar Whatsapp</a></li>
                                                    <li><a href="{{route('financial.service-order.pdf', $itemServiceOrder['id'])}}" > <i class="fa-regular fa-file-pdf"></i> Vizualizar PDF</a></li>
                                                    <li><a href="javascript:void(0)" wire:click.prevent="downloadExcel({{$itemServiceOrder['id']}})"> <i class="fa-regular fa-file-excel"></i> Baixar Participantes</a></li>
                                                    <li><a href="javascript:void(0)" wire:click.prevent="updateStatus({'id': {{$itemServiceOrder['id']}}, 'status_id': '3' })"> <i class="fa-solid fa-check"></i> Concluir OS</a></li>
                                                    <li><a href="javascript:void(0)" wire:click.prevent="updateStatus({'id': {{$itemServiceOrder['id']}}, 'status_id': '4' })"> <i class="fa-solid fa-ban"></i> Cancelar OS</a></li>
                                                </ul>
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
                            <div class="text-nowrap mt-1">itens de {{ $response->serviceOrders->total() }}</div>
                        </div>

                        <div class="">
                            {{ $response->serviceOrders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
