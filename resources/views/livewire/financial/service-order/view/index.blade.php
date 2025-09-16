<div>

        <div wire:loading.class="opacity-100 ">
            <div  wire:loading id="global-loader" >
                <img src="{{asset('build/assets/images/svgs/loader.svg')}}" alt="loader">
            </div>
        </div>

     @livewire('financial.service-order.view.top.card', ['id' => $id])


    <div class="row">
        @livewire('financial.service-order.view.details.card', ['id' => $id])

        @livewire('financial.service-order.view.releases.table', ['id' => $id])
    </div>

    <div class="row">
        @livewire('financial.service-order.view.participants.table', ['id' => $id])
    </div>
</div>
