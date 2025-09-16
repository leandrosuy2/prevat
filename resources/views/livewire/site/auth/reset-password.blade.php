<div>
    <form wire:submit.prevent="submit">
        <div class="row justify-content-md-center">

            <div class="col-md-8 col-xl-8">
                <div class="contact-one__input-box">
                <input type="password" wire:model.defer="state.password" placeholder="Nova Senha">
                </div>
            </div>

            <div class="col-md-8 col-xl-8">
                <div class="contact-one__input-box">
                <input type="password" wire:model.defer="state.password_confirmation" placeholder="Repita Nova Senha">
                </div>
            </div>

            @if ($errors->any())
                <div class="col-md-8 col-xl-8">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Ops, alguns erros foram detectados</h4>
                        @error('password')
                        <p>{{ $message }}</p>
                        @enderror
                        <hr>
                        @error('password_confirmation')
                        <p class="mb-0">{{ $message }}</p>
                        @enderror
                    </div>
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            @error('password')--}}
{{--                            <li>{{ $message }}</li>--}}
{{--                            @enderror--}}
{{--                            @error('password_confirmation')--}}
{{--                            <li>{{ $message }}</li>--}}
{{--                            @enderror--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                </div>
            @endif
            <div class="col-md-12">
                <div class="contact-one__btn-box">
                    <button type="submit" class="eduact-btn eduact-btn-second"><span class="eduact-btn__curve"></span>Alterar Senha<i class="icon-arrow"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
