<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title fs-14">Alterar Senha</h3>
        </div>
        <div class="card-body">
            @if(session('password-updated'))
                <div class="card text-white bg-gradient-success">
                    <div class="card-body">
                        <h4 class="card-title">Sucesso</h4>
                        <p class="card-text">{{ session('password-updated') }}</p>
                    </div>
                </div>
            @endif
            @if($errors->count() > 0)
            <div class="card text-white bg-danger ">
                <div class="card-body">
                    <h4 class="card-title">Erros de Validação</h4>
                     @foreach ($errors->all() as $error)
                        <p class="card-text mb-0"> * {{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif
            <form wire:submit="save" class="form-horizontal">
                <div class="row">

                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <label class="form-label">Senha Atual</label>
                            <div class="input-group"  x-data="{ show: true }">
                                <input :type="show ? 'password' : 'text'"  wire:model="state.current_password" class="form-control">
                                <button class="btn btn-primary" type="button">
                                    <i class="fe text-white" :class="{'fe-eye': !show, 'fe-eye-off':show }" id="eyeOpen" @click="show = !show" ></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <label class="form-label">Senha</label>
                            <div class="input-group"  x-data="{ show: true }">
                                <input :type="show ? 'password' : 'text'"  wire:model="state.password" class="form-control">
                                <button class="btn btn-primary" type="button">
                                    <i class="fe text-white" :class="{'fe-eye': !show, 'fe-eye-off':show }" id="eyeOpen" @click="show = !show" ></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xl-12">
                        <div class="form-group">
                            <label class="form-label">Confirmar Senha</label>
                            <div class="input-group"  x-data="{ show: true }">
                                <input :type="show ? 'password' : 'text'"  wire:model="state.password_confirmation" class="form-control">
                                <button class="btn btn-primary" type="button">
                                    <i class="fe text-white" :class="{'fe-eye': !show, 'fe-eye-off':show }" id="eyeOpen" @click="show = !show" ></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary"> Atualizar</button>
            </form>
        </div>
    </div>
</div>
