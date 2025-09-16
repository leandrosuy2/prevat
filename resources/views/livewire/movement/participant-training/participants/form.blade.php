<div>
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title fs-14">Participantes</h3>
            </div>

            <div class="px-2 pt-5" style="z-index: 5"  >
            @livewire('movement.participant-training.participants.filter')
            </div>

            <div class="card-body" style="z-index: 5"  >

                @include('includes.alerts')
                @if($filters)
                <div class="table-responsive">
                    <table id="data-table3" class="table table-bordered text-nowrap mb-0">
                        <thead class="text-dark">
                        <tr>
                            <th class="fw-semibold">Nome</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($response->participants as $itemParticipant)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="flex-1">
                                            <h6 class="mb-0 mt-1 text-dark fw-semibold">
                                                <a href="javascript:void(0);" wire:click="addParticipant({{$itemParticipant['id']}})">{{ $itemParticipant['name'] }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="card border-info">
                            <div class="card-body text-info">
                                <h4 class="card-title">Busca</h4>
                                <p class="card-text"> Insira acima o nome do participante</p>
                            </div>
                        </div>
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')

@endsection
