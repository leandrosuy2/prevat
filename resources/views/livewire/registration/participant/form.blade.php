<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$participant ? 'Edição de ' : 'Cadastro de novo '}} Participante</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo os dados da novo Participante.
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Nome do Participante</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Função</label>

                                    <x-select2 wire:model="state.participant_role_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->participantRoles as $itemParticipantRole)
                                            <option value="{{$itemParticipantRole['value']}}" @if(isset($participant) && $participant['participant_role_id'] == $itemParticipantRole['value']) selected @endif>
                                                {{$itemParticipantRole['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('participant_role_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="CPF" class="form-label">CPF</label>
                                    <input x-mask="999.999.999-99" wire:model="state.taxpayer_registration" class="form-control">
                                    @error('taxpayer_registration')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="RG" class="form-label">RG</label>
                                    <input wire:model="state.identity_registration" class="form-control">
                                    @error('identity_registration')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="CNH" class="form-label">CNH</label>
                                    <input x-mask="999999999" wire:model="state.driving_license" class="form-control">
                                    @error('driving_license')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">E-mail</label>
                                    <input type="email" wire:model="state.email" class="form-control">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Empresa</label>
                                    <x-select2 wire:model.live="state.company_id" class="form-control form-select select2 select2-show-search">
                                    @foreach($response->companies as $itemParticipantRole)
                                        <option value="{{$itemParticipantRole['value']}}" @if(isset($participant) && $participant['company_id'] == $itemParticipantRole['value']) selected @endif>
                                            {{$itemParticipantRole['label']}}</option>
                                        @endforeach
                                        </x-select2>
                                        @error('company_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Contrato</label>
                                    <select wire:model.live="state.contract_id" class="form-control form-select">
                                        @foreach($response->contracts as $itemRoom)
                                            <option value="{{$itemRoom['value']}}" @if(isset($participant) && $participant['contract_id'] == $itemRoom['value']) selected @endif>
                                                {{$itemRoom['label']}}</option>
                                        @endforeach
                                    </select>
                                    @error('contract_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <x-select2 wire:model="state.status"  class=" select2 form-select">
                                        <option value="">Escolha</option>
                                        <option value="Ativo">Ativo</option>
                                        <option value="Inativo">Inativo</option>
                                    </x-select2>

                                    @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Campo de Assinatura -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Assinatura</label>
                                <div id="signature-container" style="border:1px solid #ccc; border-radius:4px; position:relative; width:100%;">
                                    <canvas id="signature-pad" style="touch-action: none; background: #fff; width:100%; height:200px;"></canvas>
                                    <input type="hidden" wire:model="state.signature" id="signature-input">
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="clear-signature">Limpar Assinatura</button>
                                @error('signature')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @if(isset($participant) && $participant['signature_image'])
                                    <div class="mt-3">
                                        <div class="form-label">Assinatura atual</div>
                                        <img alt="signature" class="img-responsive br-7" style="max-height:150px" src="{{ asset('storage/' . $participant['signature_image']) }}">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-danger" wire:click="removeSignature">Remover assinatura</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> {{$participant ? 'Atualizar' : 'Cadastrar'}}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

    <!-- SELECT2 JS -->
    <script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>
    @vite('resources/assets/js/select2.js')


    <script>

        $(document).ready(function () {
            $('#select2').select2();
            $('#select2').on('change', function (e) {
                var data = $('#select2').select2("val");

                console.log(data);
            @this.set('selected', data);
            });
        });
    </script>

    <script>
        // Assinatura Canvas
        let canvas = document.getElementById('signature-pad');
        let signatureInput = document.getElementById('signature-input');
        if (canvas) {
            let ctx = canvas.getContext('2d');
            let drawing = false;
            let lastPos = { x: 0, y: 0 };

            function resizeCanvas() {
                const container = document.getElementById('signature-container');
                if (!container) return;
                const ratio = window.devicePixelRatio || 1;
                const displayWidth = container.clientWidth;
                const displayHeight = 200; // matches CSS height
                canvas.width = Math.floor(displayWidth * ratio);
                canvas.height = Math.floor(displayHeight * ratio);
                canvas.style.width = displayWidth + 'px';
                canvas.style.height = displayHeight + 'px';
                ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
            }
            // init and on resize
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            function getMousePos(canvas, evt) {
                let rect = canvas.getBoundingClientRect();
                return {
                    x: evt.clientX - rect.left,
                    y: evt.clientY - rect.top
                };
            }
            function getTouchPos(canvas, touch) {
                let rect = canvas.getBoundingClientRect();
                return {
                    x: touch.touches[0].clientX - rect.left,
                    y: touch.touches[0].clientY - rect.top
                };
            }
            function drawLine(from, to) {
                ctx.beginPath();
                ctx.moveTo(from.x, from.y);
                ctx.lineTo(to.x, to.y);
                ctx.strokeStyle = '#222';
                ctx.lineWidth = 2;
                ctx.stroke();
                ctx.closePath();
            }
            canvas.addEventListener('mousedown', function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            });
            canvas.addEventListener('mousemove', function(e) {
                if (!drawing) return;
                let mousePos = getMousePos(canvas, e);
                drawLine(lastPos, mousePos);
                lastPos = mousePos;
            });
            canvas.addEventListener('mouseup', function() {
                drawing = false;
                signatureInput.value = canvas.toDataURL();
                signatureInput.dispatchEvent(new Event('input'));
            });
            canvas.addEventListener('mouseleave', function() {
                drawing = false;
            });
            // Touch events
            canvas.addEventListener('touchstart', function(e) {
                drawing = true;
                lastPos = getTouchPos(canvas, e);
            });
            canvas.addEventListener('touchmove', function(e) {
                if (!drawing) return;
                let touchPos = getTouchPos(canvas, e);
                drawLine(lastPos, touchPos);
                lastPos = touchPos;
                e.preventDefault();
            });
            canvas.addEventListener('touchend', function() {
                drawing = false;
                signatureInput.value = canvas.toDataURL();
                signatureInput.dispatchEvent(new Event('input'));
            });
            document.getElementById('clear-signature').addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                signatureInput.value = '';
                signatureInput.dispatchEvent(new Event('input'));
            });
        }
    </script>
@endsection
