<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">Cadastro de novo Usuário</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo os dados do novo usuário que irá acessar o sistema .
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Nome do Usuário</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
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
                                    <label class="form-label">Senha</label>
                                    <div class="input-group"  x-data="{ show: true }">
                                        <input :type="show ? 'password' : 'text'"  wire:model="state.password" class="form-control ">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fe text-white" :class="{'fe-eye': !show, 'fe-eye-off':show }" id="eyeOpen" @click="show = !show" ></i>
                                        </button>
                                        @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="place-top-left" class="form-label">Telefone</label>
                                    <input wire:model="state.phone" x-mask="(99) 9 9999-9999" class="form-control ">
                                    @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="place-top-right" class="form-label">Documento</label>
                                    <input wire:model="state.document" x-mask="999.999.999-99" class="form-control">
                                    @error('document')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if(auth()->user()->company->type == 'client')
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label class="form-label">Contrato</label>
                                    <x-select2 wire:model="state.contract_id" class="form-control form-select select2 select2-show-search">
                                        @foreach($response->contracts as $itemContract)
                                            <option value="{{$itemContract['value']}}" @if(isset($contract) && $contract['contractor_id'] == $itemContract['value']) selected @endif>
                                                {{$itemContract['label']}}</option>
                                        @endforeach
                                    </x-select2>
                                    @error('contract_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                        <select wire:model="state.status"  class="form-control form-select "
                                                 data-placeholder="Escolha">
                                            <option value="">Escolha</option>
                                            <option value="Ativo" @if(isset($company) && $company['status'] == 'Ativo') selected @endif>Ativo</option>
                                            <option value="Inativo" @if(isset($company) && $company['status'] == 'Inativo') selected @endif>Inativo</option>
                                        </select>
                                    @error('status')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            @if(auth()->user()->company->type == 'admin')
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Função</label>
                                        <select wire:model="state.role_id" class="form-control form-select"
                                             data-placeholder="Escolha">

                                            @foreach($response->roles as $itemRole)
                                                <option value="{{$itemRole['value']}}" @if(isset($user) && $user['role_id'] == $itemRole['value']) selected @endif>
                                                    {{$itemRole['label']}}</option>
                                            @endforeach
                                        </select>

                                    @error('role_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Notificações</label>
                                    <select wire:model="state.notifications"  class="form-control form-select "
                                            data-placeholder="Escolha">
                                        <option value="">Escolha</option>
                                        <option value="Ativo" @if(isset($company) && $company['notifications'] == 'Ativo') selected @endif>Ativo</option>
                                        <option value="Inativo" @if(isset($company) && $company['notifications'] == 'Inativo') selected @endif>Inativo</option>
                                    </select>
                                    @error('notifications')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="Observações"  class="form-label">Observações</label>
                            <textarea wire:model="state.observations" class="form-control" maxlength="225" id="textarea"
                                      rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <div class="form-label">Imagem</div>
                                    <div class="input-group file-browser">
                                        <input type="file" wire:model.live="profile_photo_path"
                                               class="form-control border-right-0 browse-file"
                                               placeholder="Upload Images" readonly>
                                    </div>
                                    @error('profile_photo_path')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                @if(isset($profile_photo_path) && $errors->count() == 0)
                                    <ul id="lightgallery" class="list-unstyled row">
                                        <li class="col-xs-6 col-sm-6 col-md-6  mt-5 border-bottom-0"
                                            data-responsive="{{ $profile_photo_path->temporaryUrl() }}"
                                            data-src="{{ $profile_photo_path->temporaryUrl() }}"
                                            data-sub-html="<h4>Imagem do usuário</h4>">
                                            <a href="javascript:void(0)">
                                                <img class="img-responsive br-7" src="{{ $profile_photo_path->temporaryUrl() }}"
                                                     alt="Thumb-1">
                                            </a>
                                        </li>
                                    </ul>
                                @elseif(isset($state['image']) && $errors->count() == 0)
                                    <ul id="lightgallery" class="list-unstyled row">
                                        <li class="col-xs-6 col-sm-6 col-md-6  mt-5 border-bottom-0"
                                            data-responsive="{{url('storage/'.$state['profile_photo_path'])}}"
                                            data-src="{{url('storage/'.$state['profile_photo_path'])}}"
                                            data-sub-html="<h4>Imagem do usuário</h4>">
                                            <a href="javascript:void(0)">
                                                <img class="img-responsive br-7" src="{{url('storage/'.$state['profile_photo_path'])}}"
                                                     alt="Thumb-1">
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> {{$user ? 'Atualizar' : 'Cadastrar'}}</button>
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
        // $(document).ready(function() {
        //     $('#testdropdown').select2();
        //     $('#testdropdown').on('change', function() {
        //         let data = $(this).val();
        //         console.log(data);
        //         // $wire.set('companies', data, false);
        //         // $wire.companies = data;
        //     @this.state.role_id = data;
        //     });


        // $(document).ready(function () {
        //     $('#select2').select2();
        //     $('#select2').on('change', function (e) {
        //         let data = $(this).val();
        //         // var data = $('#select2').select2("val");
        //
        //         console.log(data);
        //     @this.set('state.status', data);
        //     });
        // });

        // window.loadSelect2 = () => {
        //     $('#select2').select2({
        //         // theme: "bootstrap-5",
        //     }).on('change',function () {
        //         var data = $('#select2').select2("val");
        //         console.log(data)
        //     @this.set('state.status', data);
        //     });
        // }
        // document.addEventListener('livewire:init', () => {
        //     loadSelect2();
        //     Livewire.on('select2Hydrate',()=>{
        //         loadSelect2();
        //     });
        // });
    </script>
@endsection
