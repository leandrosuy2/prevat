<div>
    <div class="offcanvas-header">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lançamentos a faturar</h3>

                </div>
                <div class="card-body">
                    @livewire('financial.service-order.view.releases.filter')
                    <p class="card-sub-title text-primary py-1 ">
                        Selecione os agendamentos que deseja adicionar a ordem de serviço.
                    </p>
                    @include('includes.alerts')
                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-bold fs-11">Treinamento</th>
                                    <th class="fw-bold fs-11 text-center">Data</th>
                                    <th class="fw-bold fs-11 text-center">Part.</th>
                                    <th class="fw-bold fs-11 text-center">Ausent.</th>
                                    <th class="fw-bold fs-11" width="40px">Valor</th>
                                    <th class="fw-bold fs-11" width="40px">Faturado</th>
                                    <th class="fw-bold fs-11" width="40px">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($response->releases as $itemRelease)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <h6 class="mb-0 mt-1 text-dark fw-semibold fs-11">
                                                        {{ $itemRelease['schedule']['training']['name'] ?? '' }}
                                                    </h6>
                                                    <span class="text-muted fw-semibold fs-11">{{ $itemRelease['schedule']['first_time']['name'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-dark text-center fs-11"> {{ formatDate($itemRelease['schedule']['date_event']) }}</td>
                                        <td class="fw-semibold text-dark text-center fs-11"> {{ $itemRelease['participantsPresent']->count() }}</td>
                                        <td class="fw-semibold text-dark text-center fs-11"> {{ $itemRelease['participantsAusent']->count() }}</td>
                                        <td class="fw-semibold text-dark text-center fs-11 text-nowrap"> {{ formatMoney($itemRelease['price_total']) }}</td>
                                        <td>
                                            <div class="text-center">
                                                @if($itemRelease['invoiced'] == 'Sim')
                                                    <span class="badge bg-success text-white"> {{$itemRelease['invoiced']}}</span>
                                                @else
                                                    <span class="badge bg-danger text-white"> {{$itemRelease['invoiced']}}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-nowrap">
                                            <button wire:click="addRelease({{$itemRelease['id']}})" class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Adicionar">
                                                <i class="fa-regular fa-square-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="py-2">
                        <button wire:click.prevent="addSelectionsRelease()" class="btn btn-sm btn-primary"> Adicionar lançamentos </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>

    <!-- FLATPICKER JS -->
    <script src="{{asset('build/assets/plugins/flatpickr/flatpickr.js')}}"></script>

    @vite('resources/assets/js/select2.js')
    <!-- MODAL JS -->
    @vite('resources/assets/js/modal.js')
@endsection

