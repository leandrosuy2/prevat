<div>
    <div class="offcanvas-header">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Cadastrar Imagem</h3>
                    <div>
                        <a href="javascript:void(0);" class="card-options-collapse me-2"
                           data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                        <a href="javascript:void(0);" class="card-options-remove" data-bs-dismiss="offcanvas"><i
                                class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        Insira as imagens desejadas abaixo.
                    </p>
                    @include('includes.alerts')
                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <div class="input-group file-browser">
                                        <input type="file" wire:model="images"
                                               class="form-control border-right-1 browse-file"
                                               placeholder="Upload Images" readonly multiple>
                                    </div>
                                    @error('images')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"> Cadastrar </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @vite('resources/assets/js/form-elements.js')
@endsection
