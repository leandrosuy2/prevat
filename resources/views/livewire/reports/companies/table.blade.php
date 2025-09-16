<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Relatório de empresas cadastradas</h3>
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

                    <div wire:loading.class="opacity-100 ">
                        <div  wire:loading id="global-loader" >
                            <img src="{{asset('build/assets/images/svgs/loader.svg')}}" alt="loader">
                        </div>
                    </div>

                    @livewire('reports.companies.filter')

                    @if($visible)
                        <div class="e-table">
                            <div class="table-responsive table-lg">
                                <table class="table table-bordered text-dark  text-uppercase">
                                    <thead>
                                    <tr class="fs-12">
                                        <th class="text-dark fw-semibold fs-12">Razão Social</th>
                                        <th class="text-dark fw-semibold fs-12">Telefone</th>
                                        <th class="text-dark fw-semibold fs-12">Email</th>
                                        <th class="text-dark fw-semibold fs-12">CNPJ</th>
                                        <th class="text-dark fw-semibold fs-12">CEP</th>
                                        <th class="text-dark fw-semibold fs-12">Endereço</th>
                                        <th class="text-center fw-semibold fs-12">Número</th>
                                        <th class="text-center fw-semibold fs-12">Complemento</th>
                                        <th class="text-center fw-semibold fs-12">Bairro</th>
                                        <th class="text-center fw-semibold fs-12">Cidade</th>
                                        <th class="text-center fw-semibold fs-12">Estado</th>
                                        <th class="text-center fw-semibold fs-12">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($response->companies as $key => $itemCompany)
                                        <tr>
                                            <td class="text-nowrap">
                                                <div class="flex-1 my-auto">
                                                    <h6 class="mb-0 fw-semibold fs-11">
                                                        <i class="fas fa-graduation-cap "></i> {{$itemCompany['name']}}
                                                    </h6>
                                                </div>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['phone']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['email']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['employer_number']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['zip_code']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['address']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['number']}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['complement'] ?? 'S/C'}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle fs-11">
                                                <span>{{$itemCompany['neighborhood'] ?? 'S/C'}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle text-center  fs-11">
                                                <span>{{$itemCompany['city'] ?? 'S/C'}}</span>
                                            </td>

                                            <td class="text-nowrap align-middle text-center  fs-11">
                                                <span>{{$itemCompany['uf'] ?? 'S/C'}}</span>
                                            </td>


                                            <td class="text-nowrap align-middle text-center  fs-11">
                                                <span>{{$itemCompany['status'] ?? 'S/N'}}</span>
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
                                <div class="text-nowrap mt-1">itens de {{ $response->companies->total() }}</div>
                            </div>

                            <div class="">
                                {{ $response->companies->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

