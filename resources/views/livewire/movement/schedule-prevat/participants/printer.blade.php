<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Impressão da lista de participantes</h3>
                    <div class="">
                        {{--                            <button wire:click="openModal('movement.schedule-company.form', {'id' : null })" class="fw-semibold btn btn-sm btn-success"><i class="fa fa-user"></i> Adicionar participante </button>--}}

                            <button wire:click="downloadPDF({{$schedulePrevat['id']}})" class="fw-semibold btn btn-sm btn-primary"> <i class="fa fa-file-pdf"></i> Baixar PDF </button>

                        <a href="{{ route('movement.schedule-prevat.participants', $schedulePrevat['id']) }}" class="btn btn-sm btn-icon btn-cyan" data-bs-toggle="tooltip" data-bs-placement="top"
                           title="Voltar">
                            <i class="fa-solid fa-backward-step"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body" style="z-index: 5">
{{--@dd($schedulePrevat['file_presence'])--}}
                    <div class="w-full">
                        <embed
                            src="{{url('storage/'.strtr($schedulePrevat['file_presence'], ['app/public/' => '']))}}#toolbar=1&navpanes=0&scrollbar=0"
                            type="application/pdf"
                            frameBorder="0"
                            scrolling="auto"
                            height="1000px"
                            width="100%"
                        ></embed>
                    </div>

{{--                    <iframe src="{{storage_path($schedulePrevat['file_presence'])}}"--}}
{{--                            width="100%" height="100%"></iframe>--}}
               </div>
            </div>
        </div>
    </div>
</div>
