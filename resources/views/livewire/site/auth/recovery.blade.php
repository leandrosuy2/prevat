<div>
    <form wire:submit="submit" class="contact-one__form contact-form-validated">
        <div class="row justify-content-md-center">

            <div class="col-md-8 col-xl-8">
                @include('site.includes.alert')
            </div>

            @if(!$sent)
            <div class="col-md-8 col-xl-8">
                <div class="contact-one__input-box">
                    <input type="email" placeholder="Email" wire:model="state.email"
                    @error('email')
                    <p class="text-danger"> {{$message}}</p>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="contact-one__btn-box">
                    <button type="submit" class="eduact-btn eduact-btn-second"><span class="eduact-btn__curve"></span>Enviar Email<i class="icon-arrow"></i></button>
                </div>
            </div>

            @else
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Email Enviado com succeso !</h4>
                    <p>Senha Enviada com sucesso, por favor veja seu email as instruções para cadastrar uma nova senha</p>
                </div>

            @endif

        </div>
    </form>
</div>
