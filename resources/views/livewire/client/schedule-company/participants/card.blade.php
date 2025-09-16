<div>
    <div class="offcanvas-header">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Participantes</h3>
                    <div>
                        <a href="javascript:void(0);" class="card-options-collapse me-2"
                           data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                        <a href="javascript:void(0);" class="card-options-remove" data-bs-dismiss="offcanvas"><i
                                class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('client.schedule-company.participants.search')
                    <p class="mb-0">
                        Selecione abaixo os participantes da empresa selecionada
                    </p>
                    @include('includes.alerts')
                    <div class="panel panel-warning">
                        <div class="list-group">
                            @foreach($response->participants as $itemParticipant)
                                <a href="javascript:void(0);" class="list-group-item" wire:click="addParticipant({{$itemParticipant['id']}})">{{ $itemParticipant['name'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
