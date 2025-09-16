<div>
    <form wire:submit.prevent="submit" class="contact-one__form">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-xl-8">
                <div class="contact-one__input-box">
                    <input type="email" placeholder="Email" wire:model="state.email"
                    @error('email')
                    <p class="text-danger"> {{$message}}</p>
                    @endif
                </div>
            </div>

            <div class="col-md-8 col-xl-8">
                <div class="contact-one__input-box">
                    <input type="password" placeholder="Senha" wire:model="state.password" >
                    @error('password')
                     <p class="text-danger"> {{$message}}</p>
                    @endif
                </div>
            </div>

            <div class="col-md-8 col-xl-8">
                @include('site.includes.alert')
                @if($error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endif
            </div>




            <div class="col-md-12">
                <div class="contact-one__btn-box">
                    <button class="eduact-btn eduact-btn-second"><span class="eduact-btn__curve"></span>Login<i class="icon-arrow"></i></button>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <a href="{{route('password.request')}}" style=" font-weight: bold;">Esqueceu a Senha ?</a>
            </div>
        </div>
    </form>
</div>
