<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Lista de Participantes</h3>
                </div>

                <div class="card-body" style="z-index: 5">

                    @include('includes.alerts')

                    @livewire('financial.releases.participants.filter')

                    <div class="e-table">
                        <div class="table-responsive table-lg">
                            <table class="table table-bordered text-dark">
                                <thead class="text-dark">
                                <tr>
                                    <th class="fw-bold fs-12">Nome</th>
                                    <th class="fw-bold fs-12">Documentos</th>
                                    <th class="fw-bold fs-12">Empresa</th>
                                    <th class="fw-bold fs-12 w-10">Quantidade</th>
                                    <th class="fw-bold fs-12 w-15">Valor</th>
                                    <th class="fw-bold fs-12 w-15">Valor Total</th>
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
                                        <td>
                                            <input type="number" min="0" max="10" wire:model.live="quantity.{{$key}}" class="form-control @error('quantity.*') is-invalid state-invalid @enderror" >
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-text">  R$  </div>
                                                <input x-mask:dynamic="$money($input, ',')"   wire:model.live.debounce.500ms="value.{{$key}}" class="form-control @if($errors->has('note.'.$key)) x-mask:dynamic="$money($input, ',')"is-invalid state-invalid @endif">
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-dark">
                                            <span class="text-muted fw-semibold fs-13">{{formatMoney($itemParticipant['quantity'] * $itemParticipant['value'])}}</span>
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
