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
                            <div class="col-md-12 col-xl-6">
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

                            @if(auth()->user()->company->type == 'admin')
                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label">Empresa</label>
                                        <x-select2 wire:model="state.company_id" class="form-control form-select select2 select2-show-search">
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
                            @endif

                            <div class="col-md-12 col-xl-3">
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

@endsection
