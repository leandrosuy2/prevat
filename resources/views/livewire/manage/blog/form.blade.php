<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fs-14">{{$blog ? 'Edição de ' : 'Cadastro de novo '}}  Post</h3>
                </div>
                <div class="card-body">
                    <p class="card-sub-title text-muted">
                        Insira abaixo as informações do Post
                    </p>

                    @include('includes.alerts')

                    <form wire:submit="save" class="form-horizontal">
                        <div class="row">
                             <div class="col-md-12 col-xl-3">
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

                            <div class="col-md-12 col-xl-9">
                                <div class="form-group">
                                    <label for="Nome do Treinamento" class="form-label">Titulo</label>
                                    <input type="text" wire:model="state.title" class="form-control">
                                    @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                         </div>

                        <div class="form-group">
                            <label for="Descrição"  class="form-label">Conteúdo</label>
                            <textarea wire:model="state.content" class="form-control"
                                      rows="10"></textarea>
                            @error('content')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group">
                                    <div class="form-label">Imagem</div>
                                    <div class="input-group file-browser">
                                        <input type="file" wire:model.live="image"
                                               class="form-control border-right-1 browse-file"
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
                                            <button class="btn btn-sm btn-icon btn-danger mt-1" wire:click.prevent="removeImage({{$state['id']}})"  >
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"> {{$blog ? 'Atualizar' : 'Cadastrar'}}</button>
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
    <script src="{{asset('build/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
    <script src="{{asset('build/assets/plugins/wysiwyag/wysiwyag.js')}}"></script>

@endsection



