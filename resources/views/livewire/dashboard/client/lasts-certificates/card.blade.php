<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom-0">
            <h3 class="card-title mb-0">Últimos Certificados Gerados</h3>
            <a href="{{ route('client.certificates') }}" class="btn btn-sm bg-warning-transparent fw-bold">
                Vizualizar todos
            </a>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-lg-group list-group-flush">
                @foreach($response->certificates as $itemCertificate)
                    <li class="list-group-item d-flex align-items-start">
                        <div class="px-2 py-2">
                            <i class="fa-solid fa-graduation-cap text-warning fs-26"></i>
                        </div>

                        <div class="mt-1 ml-2">
                            <h6 class="fw-semibold text-dark mb-0 fs-13"> {{$itemCertificate['training_participation']['schedule_prevat']['training']['name']}}</h6>
                            <span class="text-muted fs-11">{{$itemCertificate['training_participation']['schedule_prevat']['training']['acronym']}}</span>
                        </div>

                        <div class="ms-auto d-flex">
                            <button wire:click="download({{$itemCertificate['id']}})" class="btn btn-sm btn-light">
                                <i class="fa-solid fa-download text-warning"></i>
                            </button>
                        </div>
                    </li>
                @endforeach
            </div>
        </div>
    </div>
</div>
