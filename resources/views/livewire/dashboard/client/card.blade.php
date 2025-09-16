<div>

    @include('includes.alerts')

    @livewire('dashboard.client.info.card', ['contract' => 'true' ?? 'false'])

    <div class="row">
        @livewire('dashboard.client.lasts-schedule.card')

        @livewire('dashboard.client.lasts-certificates.card')
    </div>

</div>
