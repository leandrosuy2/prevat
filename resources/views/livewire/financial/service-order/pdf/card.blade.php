<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Vizualização PDF</h3>
                    <div class="">
                        <button wire:click.prevent="downloadOS({{$serviceOrder['id']}})" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Download OS" wire:loading.class="btn-loading ">
                            <i wire:target="downloadOS()" wire:loading.remove class="fa-solid fa-file-arrow-down"></i> Download OS
                        </button>

                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-icon btn-cyan" data-bs-toggle="tooltip" data-bs-placement="top"
                           title="Voltar">
                            <i class="fa-solid fa-backward-step"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body" style="z-index: 5">
                    <div class="w-full">
                        <embed
                            src="{{url('storage/'.strtr($serviceOrder['os_path'], ['app/public/' => '']))}}#toolbar=1&navpanes=0&scrollbar=0"
                            type="application/pdf"
                            frameBorder="0"
                            scrolling="auto"
                            height="1000px"
                            width="100%"
                        ></embed>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


