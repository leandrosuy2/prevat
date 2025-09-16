<x-mail::message>
    <h1>Olá teste</h1>
    <p> Voce Acaba de receber um convite para se cadastrar em nosso sistema, clique no botao abaixo e faça o seu cadastro.</p>

{{--    <x-mail::button :url="$body['url']">--}}
{{--        Acessar--}}
{{--    </x-mail::button>--}}

    Obrigado,<br>
    {{ config('app.name') }}
</x-mail::message>
