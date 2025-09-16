<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title fs-14">Informações Pessoais</h3>
        </div>
        <div class="card-body">
            @if(session('profile-updated'))
                <div class="card text-white bg-gradient-success">
                    <div class="card-body">
                        <h4 class="card-title">Sucesso</h4>
                        <p class="card-text">{{ session('profile-updated') }}</p>
                    </div>
                </div>
            @endif
            <form wire:submit="save" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <label for="Nome do Usuário" class="form-label">Nome do Usuário</label>
                            <input type="text" wire:model="state.name" class="form-control">
                            @error('name')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <label for="E-mail" class="form-label">E-mail</label>
                            <input type="email" wire:model="state.email" class="form-control @error('email') is-invalid state-invalid @enderror">
                            @error('email')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xl-6">
                        <div class="form-group">
                            <label for="place-top-left" class="form-label">Telefone</label>
                            <input wire:model="state.phone" x-mask="(99) 9 9999-9999" class="form-control @error('phone') is-invalid state-invalid @enderror">
                            @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-6">
                        <div class="form-group">
                            <label for="place-top-right" class="form-label">Documento</label>
                            <input wire:model="state.document" x-mask="999.999.999-99" class="form-control @error('document') is-invalid state-invalid @enderror">
                            @error('document')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary"> Atualizar</button>
            </form>
        </div>

    </div>
</div>
