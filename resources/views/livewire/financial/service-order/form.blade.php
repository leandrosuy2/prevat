<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">{{$serviceOrder ? 'Edição de ' : 'Cadastro de nova '}} Agenda Empresa</h3>
                    <div class="">
                        @if(isset($state['company_id']) && $state['company_id'] != null && isset($state['contract_id']) && $state['contract_id'] != null && auth()->user()->company->type == 'admin')
                            <button class="btn btn-sm btn-secondary" type="button" wire:click.prevent="openModal('financial.service-order.releases.table', { 'id' : {{$state['company_id']}}, 'contract_id' : {{$state['contract_id']}}, 'service_order_id' : {{$serviceOrder['id'] ?? 'null'}} })"><i class="fa-regular fa-folder"></i> Adicionar Lançamento</button>
                        @endif
                    </div>
                </div>

                <div class="card-body">

                    <h6 class="card-sub-title text-primary">
                        Insira abaixo os dados da Ordem de Serviços
                    </h6>

                    @include('includes.alerts')

                    <form wire:submit="save" class="form-horizontal mt-5">
                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Empresas</label>
                                    <x-select2 wire:model.live="state.company_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->companies as $itemCompany)
                                            <option value="{{$itemCompany['value']}}" @if(isset($scheduleComnpany) && $scheduleComnpany['company_id'] == $itemCompany['value']) selected @endif>
                                                {{$itemCompany['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('company_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

@php
    // Agrupar os contratos por empresa/label
    $groupedContracts = collect($response->contracts)->groupBy(function($contract) {
        // Retorna o nome ou identificador do grupo, neste caso vamos pegar o nome da empresa
        return explode(' - ', $contract['label'])[0]; 
    });
@endphp

<div class="col-md-12 col-xl-3">
    <div class="form-group">
        <label class="form-label">Contratante</label>
        <select wire:model.live="state.contract_id" class="form-control form-select">
            @foreach($groupedContracts as $group => $contracts)
                @php
                    $firstContract = $contracts->first(); // Pega o primeiro contrato de cada grupo
                @endphp
                <option value="{{$firstContract['value']}}" @if(isset($serviceOrder) && $serviceOrder['contract_id'] == $firstContract['value']) selected @endif>
                    {{$firstContract['label']}}
                </option>
            @endforeach
        </select>
        @error('contract_id')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>


<!-- Tabela para exibir as propriedades dos contratos -->
{{-- <div class="col-md-12 col-xl-12">
    <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
            <thead class="text-dark">
                <tr>
                    <th class="fw-bold fs-11 text-center">ID</th>
                    <th class="fw-bold fs-11">Contrato</th>
                    <th class="fw-bold fs-11">Descrição</th>
                    <th class="fw-bold fs-11">Valor</th>
                    <th class="fw-bold fs-11">Data Início</th>
                    <th class="fw-bold fs-11">Data Fim</th>
                </tr>
            </thead>
            <tbody>
                @foreach($response->contracts as $contract)
                    <tr>
                        <td class="fw-semibold text-dark text-center fs-11">{{ $contract['value'] }}</td>
                        <td class="fw-semibold text-dark fs-11">{{ $contract['label'] }}</td>
                        <td class="fw-semibold text-dark fs-11">{{ $contract['description'] ?? 'N/A' }}</td>
                        <td class="fw-semibold text-dark fs-11">{{ formatMoney($contract['price'] ?? 0) }}</td>
                        <td class="fw-semibold text-dark fs-11">{{ $contract['start_date'] ?? 'N/A' }}</td>
                        <td class="fw-semibold text-dark fs-11">{{ $contract['end_date'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}


                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Tipo de Pagamento</label>
                                    <select wire:model.live="state.payment_method_id" class="form-control form-select">
                                        @foreach($response->paymentMethods as $itemPayment)
                                            <option value="{{$itemPayment['value']}}" @if(isset($serviceOrder) && $serviceOrder['payment_method_id'] == $itemPayment['value']) selected @endif>
                                                {{$itemPayment['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <x-datepicker label="Vencimento" wire:model.live="state.due_date"> </x-datepicker>
                                        @error('due_date')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-sub-title text-primary">
                            Relação dos Treinamentos a serem cadastrados.
                        </h6>

                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="table-responsive">
                                    <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                                        <thead class="text-dark">
                                        <tr>
                                            <th class="fw-bold fs-11 text-center">Id</th>
                                            <th class="fw-bold fs-11">Empresa</th>
                                            <th class="fw-bold fs-11">Treinamento</th>
                                            <th class="fw-bold fs-11 text-center">Data</th>
                                            <th class="fw-bold fs-11 text-center">Presentes</th>
                                            <th class="fw-bold fs-11 text-center">Ausentes</th>
                                            <th class="fw-bold fs-11" width="40px">Valor</th>
                                            <th class="fw-bold fs-11 text-center" width="30px">Açoes</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($releases as $key => $itemRelease)
                                            <tr>
                                                <td class="fw-semibold text-dark text-center fs-11"> {{ $itemRelease['id'] }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-1">
                                                            <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                                {{ $itemRelease['company'] }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-1">
                                                            <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                                {{ $itemRelease['training'] }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-semibold text-dark text-center fs-11"> {{ $itemRelease['date_event'] }}</td>
                                                <td class="fw-semibold text-dark text-center fs-11"> {{ $itemRelease['present'] }}</td>
                                                <td class="fw-semibold text-dark text-center fs-11"> {{ $itemRelease['ausent'] }}</td>
                                                <td class="fw-semibold text-dark text-center fs-11 text-nowrap"> {{ formatMoney($itemRelease['price_total']) }}</td>


                                                <td class="text-nowrap">
                                                    <a href="{{ route('financial.releases.list', $itemRelease['reference']) }}" class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top"
                                                       title="Participantes">
                                                        <i class="fe fe-users"></i>
                                                    </a>

                                                    <button class="btn btn-sm btn-icon btn-danger" wire:click.prevent="remRelease({{$key}})" >
                                                        <i class="fe fe-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="py-2">
                            <button type="submit" class="btn btn-primary"> {{$serviceOrder ? 'Atualizar' : 'Cadastrar'}}</button>
                        </div>

                </form>

            </div>

        </div>
    </div>
</div>
</div>

@section('scripts')

    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')

    @vite('resources/assets/js/form-elements.js')

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>
    @vite('resources/assets/js/flatpickr.js')


    <!-- DATEPICKER JS -->
    {{--    <script src="{{asset('build/assets/plugins/spectrum-date-picker/spectrum.js')}}"></script>--}}
    <script src="{{asset('build/assets/plugins/spectrum-date-picker/jquery-ui.js')}}"></script>

@endsection
