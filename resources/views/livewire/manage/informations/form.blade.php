<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">Cadastro</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo as informações gerais que irá aparecer no site .
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Email Principal</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-envelope"></i></span>
                                        <input type="email" wire:model="state.email_01" class="form-control">
                                    </div>
                                    @error('email_01')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="Nome do Usuário" class="form-label">Email Secundário</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-envelope"></i></span>
                                        <input type="email" wire:model="state.email_02" class="form-control">
                                    </div>
                                    @error('email_02')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">Telefone Principal</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-phone"></i></span>
                                        <input type="text" x-mask="(99) 9 9999-9999" wire:model="state.phone_01" class="form-control">
                                    </div>
                                    @error('phone_01')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-3">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">Telefone Secundário</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-phone"></i></span>
                                        <input type="text" x-mask="(99) 9 9999-9999" wire:model="state.phone_02" class="form-control">
                                    </div>
                                    @error('phone_02')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Texto Sobre a Empresa"  class="form-label">Texto Sobre a Empresa</label>
                            <textarea wire:model="state.text_about" class="form-control" rows="5"></textarea>
                        </div>

                        <p class="card-sub-title text-muted">
                            Links das Redes Sociais.
                        </p>

                        <div class="row">
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Link Instagram" class="form-label">Link Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-instagram"></i></span>
                                        <input type="text" wire:model="state.link_instagram" class="form-control">
                                    </div>
                                    @error('link_instagram')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Link Facebook" class="form-label">Link Facebook</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-facebook"></i></span>
                                        <input type="text" wire:model="state.link_facebook" class="form-control">
                                    </div>
                                    @error('link_facebook')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Link twitter" class="form-label">Link twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-twitter"></i></span>
                                        <input type="text" wire:model="state.link_twitter" class="form-control">
                                    </div>
                                    @error('link_twitter')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="E-mail" class="form-label">Link Youtube</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-youtube"></i></span>
                                        <input type="text"  wire:model="state.link_youtube" class="form-control">
                                    </div>
                                    @error('link_youtube')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-4">
                                <div class="form-group">
                                    <label for="Link Linkedin" class="form-label">Link Linkedin</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-linkedin"></i></span>
                                        <input type="text"  wire:model="state.link_linkedin" class="form-control">
                                    </div>
                                    @error('link_linkedin')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Texto Rodapé"  class="form-label">Texto Rodapé</label>
                                <textarea wire:model="state.text_footer" class="form-control" rows="5"></textarea>
                            </div>
                        </div>


                        <p class="card-sub-title text-muted">
                            Logotipo da Empresa.
                        </p>

                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <div class="form-label">Imagem</div>
                                    <div class="input-group file-browser">
                                        <input type="file" wire:model.live="logo"
                                               class="form-control border-right-0 browse-file"
                                               placeholder="Upload Images" readonly>
                                    </div>
                                    @error('logo')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                @if(isset($logo) && $errors->count() == 0)
                                    <ul id="lightgallery" class="list-unstyled row">
                                        <li class="col-xs-6 col-sm-6 col-md-6  mt-5 border-bottom-0"
                                            data-responsive="{{ $logo->temporaryUrl() }}"
                                            data-src="{{ $logo->temporaryUrl() }}"
                                            data-sub-html="<h4>Imagem do usuário</h4>">
                                            <a href="javascript:void(0)">
                                                <img class="img-responsive br-7" src="{{ $logo->temporaryUrl() }}"
                                                     alt="Thumb-1">
                                            </a>
                                        </li>
                                    </ul>
                                @elseif(isset($state['logo']) && $errors->count() == 0)
                                    <ul id="lightgallery" class="list-unstyled row">
                                        <li class="col-xs-6 col-sm-6 col-md-6  mt-5 border-bottom-0"
                                            data-responsive="{{url('storage/'.$state['logo'])}}"
                                            data-src="{{url('storage/'.$state['logo'])}}"
                                            data-sub-html="<h4>Imagem do usuário</h4>">
                                            <a href="javascript:void(0)">
                                                <img class="img-responsive br-7" src="{{url('storage/'.$state['logo'])}}"
                                                     alt="Thumb-1">
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> {{$information ? 'Atualizar' : 'Cadastrar'}}</button>
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

