<div>
    <form wire:submit="submit" class="contact-one__form ">
        <div class="row">
            <div class="col-md-12">
                @include('site.includes.alert')
            </div>
            <div class="col-md-5">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Cnpj" x-mask="99.999.999/9999-99" wire:model="state.employer_number">
                    @error('employer_number')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-1">
                <button wire:click.prevent="getCompany" class="eduact-btn eduact-btn-second">
                    <span class="eduact-btn__curve"></span>
                    <div class="text-center" wire:target="getCompany">
                        <span class="spinner-border-sm m-1" role="status" aria-hidden="true" wire:target="getCompany()" wire:loading.class="spinner-border"></span>
                        <span  wire:loading.remove class="fe fe-search text-white m-0" style=" font-weight: bold"></span>
                    </div>
                </button>
            </div>
            <div class="col-md-6">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Razão Social"  wire:model.live="state.name">
                    @error('name')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
             </div>

            <div class="col-md-6">
                <div class="contact-one__input-box">
                    <input type="email" placeholder="Email" wire:model="state.email" >
                    @error('email')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Telefone" x-mask="(99) 9 9999-9999" wire:model="state.phone" >
                    @error('phone')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="section-title  text-center mt-5">
            <span class="section-title__tagline" style=" font-weight: bold">
               Contrato
            </span>
            <p class="">Caso tenha o numero de contrato por favor insira no campo abaixo</p>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Contrato"  wire:model.live="state.suggestion_contract">
                    @error('suggestion_contract')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="section-title  text-center mt-5">
            <span class="section-title__tagline" style=" font-weight: bold">
               Endereço
            </span>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Cep" x-mask="99999-999"  wire:model="state.zip_code">
                    @error('zip_code')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-1">
                <button wire:click.prevent="getAddress"  class="eduact-btn eduact-btn-second">
                    <span class="eduact-btn__curve"></span>
                    <div class="text-center" wire:target="getAddress">
                        <span class="spinner-border-sm m-1" role="status" aria-hidden="true" wire:loading.class="spinner-border"></span>
                        <span  wire:loading.remove class="fe fe-search text-white m-0" style=" font-weight: bold"></span>
                    </div>
                </button>
            </div>
            <div class="col-md-6">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Logradouro" wire:model.live="state.address">
                    @error('address')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Numero" wire:model="state.number">
                    @error('number')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Complemento" wire:model="state.c">
                    @error('neighborhood')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Bairro" wire:model.live="state.neighborhood">
                    @error('neighborhood')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Cidade" wire:model.live="state.city">
                    @error('city')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Estado"  wire:model.live="state.uf">
                    @error('uf')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>

        </div>

        <div class="section-title  text-center mt-5">
            <span class="section-title__tagline" style=" font-weight: bold">
               Dados do usuário principal
            </span>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Nome do Usuário" wire:model="state.user.name">
                    @error('user.name')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-5">
                <div class="contact-one__input-box">
                    <input type="text" placeholder="Email do Usuário" wire:model="state.user.email" >
                    @error('user.email')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-one__input-box">
                    <input type="password" placeholder="Senha" wire:model="state.user.password">
                    @error('user.password')
                    <p class="text-danger text-start ml-1"> {{$message}}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-12">
                <div class="contact-one__btn-box">
                    <button type="submit" class="eduact-btn eduact-btn-second"><span class="eduact-btn__curve"></span>Cadastrar<i class="icon-arrow"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
