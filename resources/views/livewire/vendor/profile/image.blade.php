<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title fs-14">Imagem de Perfil</h3>
        </div>
        <div class="card-body">
            @if(session('success-image'))
                <div class="card text-white bg-gradient-success">
                    <div class="card-body">
                        <h4 class="card-title mb-0">Sucesso</h4>
                        <p class="card-text mt-0 mb-0">{{ session('success-image') }}</p>
                    </div>
                </div>
            @endif

            <form wire:submit="update" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12 col-xl-12 mb-3">
                        @if (isset($profile_photo_path))
                            <img src="{{ $profile_photo_path->temporaryUrl() }}" class="rounded-circle mx-auto d-block w-75">
                        @elseif(auth()->user()->profile_photo_path == null)
                            <img src="{{ url('images/user-default.png') }}" class="rounded-circle mx-auto d-block w-75" alt="Sem Imagem" >
                        @else
                            <img src="{{ url('storage/'.auth()->user()->profile_photo_path) }}" class="rounded-circle mx-auto d-block w-75" alt="Usuario" >
                        @endif
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <div class="form-label">Imagem</div>
                            <div class="input-group file-browser">
                                <input type="file" wire:model.live="profile_photo_path"
                                       class="form-control border-right-1 browse-file"
                                       placeholder="Upload Images" readonly>
                            </div>
                            @error('profile_photo_path')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"> Atualizar </button>
            </form>
        </div>

    </div>
</div>
