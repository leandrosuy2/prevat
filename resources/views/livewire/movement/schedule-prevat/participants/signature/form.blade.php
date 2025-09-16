<div>
    <div class="offcanvas-header">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Assinatura do Participante</h3>
                    <div>
                        <a href="javascript:void(0);" class="card-options-collapse me-2"
                           data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                        <a href="javascript:void(0);" class="card-options-remove" data-bs-dismiss="offcanvas"><i
                                class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit="submit" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
{{--                                    <label for="Nome do Usuário" class="form-label">Nome do Participante</label>--}}
                                    <x-signature-pad wire:model.defer="signature" ></x-signature-pad>
                                    @error('signature')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                        </div>

{{--                        <button type="submit" class="btn btn-primary"> Salvar </button>--}}

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
@endsection
