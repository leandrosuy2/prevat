@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Sucesso !</h4>
        <p>{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Erro !</h4>
        @if(session('error') == 333)
            <p> O Cnpj informado já possuí um cadastro em nosso sistema por favor entre em contato no whatpsapp abaixo.</p>
            <a href="https://wa.me/5591993676162" target="_blank" class="eduact-btn"><span class="eduact-btn__curve"></span>(91) 9 9367-6162</a>
        @else
            <p> {{ session('error') }}</p>
        @endif
    </div>
@endif
