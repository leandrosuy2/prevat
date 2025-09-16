<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Histórico dos Treinamentos dos participantes. </h3>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('movement.historic.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                                <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                    <tr>
                                        <th class="text-dark fw-bold fs-11 w-40">Participante</th>
                                        <th class="text-dark fw-bold fs-11">Documento</th>
                                        <th class="text-dark fw-bold fs-11 ">Empresa</th>
                                        <th class="text-center fw-bold fs-11 text-left w-50">Treinamento</th>
                                        <th class="text-center fw-bold fs-11  w-10">Qtde.</th>
                                        <th class="text-center fw-bold fs-11">Valor</th>
                                        <th class="text-center fw-bold fs-11">Total</th>
                                        <th class="text-center fw-bold fs-11 " >Nota</th>
                                        <th class="text-center fw-bold fs-11 text-left w-10">Registro</th>
                                        <th class="text-center fw-bold fs-11 text-left w-10">Data</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                    @foreach($response->historics as $key => $itemHistoric)
                                        <tr class="{{$itemHistoric['table_color']}}">
                                            <td>
                                                <div class="flex-1 my-auto">
                                                    <h6 class="mb-0 fw-semibold fs-10">{{$itemHistoric['name']}}</h6>
                                                    <span class="text-muted fw-semibold fs-10">{{$itemHistoric['role']}}</span>
                                                </div>
                                            </td>
                                            <td class="text-nowrap align-middle fs-10">
                                                <span>{{$itemHistoric['taxpayer_registration']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-10">
                                                <span>{{$itemHistoric['company_name']}}</span>
                                            </td>

                                            <td class="text-left fs-10">
                                                <span>{{$itemHistoric['training_name']}}</span>
                                            </td>
                                            <td class="text-nowrap text-center fs-10">
                                                <span>{{$itemHistoric['quantity']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-10">
                                                <span>{{formatMoney($itemHistoric['value'])}}</span>
                                            </td>
                                            <td class="text-nowrap align-middle fs-10">
                                                <span>{{formatMoney($itemHistoric['total_value'])}}</span>
                                            </td>
                                            <td class="text-nowrap align-middle fs-10">
                                                <span>{{formatNumber($itemHistoric['note']) }}</span>
                                            </td>
                                            <td class="text-nowrap text-center fs-10">
                                                <span>{{formatNumber($itemHistoric['registry']) }}</span>
                                            </td>
                                            <td class="text-nowrap text-center fs-10">
                                                <span>{{formatDate($itemHistoric['date']) }}</span>
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
