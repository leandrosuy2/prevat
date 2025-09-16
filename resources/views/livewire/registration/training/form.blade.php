<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$training ? 'Edição de ' : 'Cadastro de novo '}}  Treinamento</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo as informações do Treinamento
                    </p>

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label for="Sigla" class="form-label">Sigla</label>
                                    <input type="text" wire:model="state.acronym" class="form-control">
                                    @error('acronym')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">
                                    <label class="form-label">Categoria</label>
                                    <x-select2 wire:model="state.category_id" placeholder="Select Members" class="select2 form-select">
                                        @foreach($response->categories as $itemCategory)
                                            <option value="{{$itemCategory['value']}}">{{$itemCategory['label']}}</option>
                                        @endforeach

                                    </x-select2>

                                    @error('category_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <label for="Nome do Treinamento" class="form-label">Nome do Treinamento</label>
                                    <input type="text" wire:model="state.name" class="form-control">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 col-xl-2">
                                <div class="form-group">

                                    <label for="Valor" class="form-label">Valor</label>
                                    <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend">R$</span>
                                    <input wire:model="state.value" x-mask:dynamic="$money($input, ',')" class="form-control">
                                    @error('value')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    </div>
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

                        <div class="form-group">
                            <label for="Descrição"  class="form-label">Descrição</label>
                            <textarea wire:model="state.description" class="form-control"
                                      rows="8"></textarea>
                            @error('description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <p class="card-sub-title text-muted">
                            Dados do Conteúdo Programático
                        </p>

                        <div class="form-group">
                            <label for="Nome do Treinamento" class="form-label">Titulo Conteúdo Programático</label>
                            <input type="text" wire:model="state.content_title" class="form-control">
                            @error('content_title')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="Conteúdo"  class="form-label">Conteúdo Modulo 01</label>
                                <textarea wire:model="state.content" class="form-control "
                                          rows="12"></textarea>
                            @error('content')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="Conteúdo"  class="form-label">Conteúdo Modulo 02</label>
                            <textarea wire:model="state.content02" class="form-control "
                                      rows="12"></textarea>
                            @error('content02')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <div class="form-label">Imagem</div>
                                    <div class="input-group file-browser">
                                        <input type="file" wire:model.live="image"
                                               class="form-control border-right-0 browse-file"
                                               placeholder="Upload Images" readonly>
                                    </div>
                                    @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                @if(isset($image) && $errors->count() == 0)
                                    <ul id="lightgallery" class="list-unstyled row">
                                        <li class="col-xs-6 col-sm-6 col-md-6  mt-5 border-bottom-0"
                                            data-responsive="{{ $image->temporaryUrl() }}"
                                            data-src="{{ $image->temporaryUrl() }}"
                                            data-sub-html="<h4>Imagem</h4>">
                                            <a href="javascript:void(0)">
                                                <img class="img-responsive br-7" src="{{ $image->temporaryUrl() }}"
                                                     alt="Thumb-1">
                                            </a>
                                        </li>
                                    </ul>
                                @elseif(isset($state['image']) && $errors->count() == 0)
                                    <ul id="lightgallery" class="list-unstyled row">
                                        <li class="col-xs-6 col-sm-6 col-md-6  mt-5 border-bottom-0"
                                            data-responsive="{{url('storage/'.$state['image'])}}"
                                            data-src="{{url('storage/'.$state['image'])}}"
                                            data-sub-html="<h4>Imagem do usuário</h4>">
                                            <a href="javascript:void(0)">
                                                <img class="img-responsive br-7" src="{{url('storage/'.$state['image'])}}"
                                                     alt="Thumb-1">
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> {{$training ? 'Atualizar' : 'Cadastrar'}}</button>
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

    <!-- INTERNAL WYSIWYG EDITOR JS -->
{{--    <script src="{{asset('build/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>--}}
{{--    <script src="{{asset('build/assets/plugins/wysiwyag/wysiwyag.js')}}"></script>--}}

{{--    <script src="{{asset('build/assets/plugins/quill/quill.min.js')}}"></script>--}}
{{--    @vite('resources/assets/js/form-editor2.js')--}}

@endsection


