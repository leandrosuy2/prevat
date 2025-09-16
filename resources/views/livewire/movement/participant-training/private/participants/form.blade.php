<div>
    <div class="offcanvas-header">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-status card-status-left bg-primary br-bl-7 br-tl-7"></div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Adicionar Participante</h3>
                    <div>
                        <a href="javascript:void(0);" class="card-options-collapse me-2"
                           data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                        <a href="javascript:void(0);" class="card-options-remove" data-bs-dismiss="offcanvas"><i
                                class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Nome do Participante</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">E-mail</label>
                                    <input type="email" wire:model="state.email" class="form-control">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <label class="form-label">Função</label>
                                    <x-select2 wire:model="state.participant_role_id" class="form-control select2 form-select  select2-show-search" >
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

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="CPF" class="form-label">CPF</label>
                                    <input x-mask="999.999.999-99" wire:model="state.taxpayer_registration" class="form-control">
                                    @error('taxpayer_registration')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="RG" class="form-label">RG</label>
                                    <input wire:model="state.identity_registration" class="form-control">
                                    @error('identity_registration')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="CNH" class="form-label">CNH</label>
                                    <input x-mask="999999999" wire:model="state.driving_license" class="form-control">
                                    @error('driving_license')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if(auth()->user()->company->type == 'admin')
                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group">
                                        <label class="form-label">Empresa</label>
                                        <select wire:model="state.company_id" class="form-control form-select " disabled>
                                            @foreach($response->companies as $itemParticipantRole)
                                                <option value="{{$itemParticipantRole['value']}}" @if(isset($company) && $company['id'] == $itemParticipantRole['value']) selected @endif>
                                                    {{$itemParticipantRole['label']}}</option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 col-xl-3">
                                    <div class="form-group">
                                        <label class="form-label">Contrato</label>
                                        <select wire:model="state.contract_id" class="form-control form-select " disabled>
                                            @foreach($response->contracts as $itemContract)
                                                <option value="{{$itemContract['value']}}" @if(isset($company) && $company['id'] == $itemContract['value']) selected @endif>
                                                    {{$itemContract['label']}}</option>
                                            @endforeach
                                        </select>
                                        @error('contract_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif




                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <x-select2 wire:model="state.status" class="selectexample">
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

                        <button type="submit" class="btn btn-primary"> Cadastrar</button>
                        <button wire:click="createAdded()" class="btn btn-warning"> Cadastrar e Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

