<!-- OFFCANVAS PLACEMENT-RIGHT -->
<div class="offcanvas offcanvas-end w-40" data-bs-scroll="true" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel"  style="z-index: 5000" >
    <div class="offcanvas-body">
        @if($blade && $params['id'] != null && isset($params['professional_id']) &&$params['professional_id'] != null )
            @livewire($blade, $params, key($params['professional_id']))
        @elseif($blade && $params['id'] != null && isset($params['contract_id']) &&$params['contract_id'] != null)
            @livewire($blade, $params, key($params['contract_id']))
        @elseif($blade && isset($params['id']))
            @livewire($blade, $params, key($params['id']))
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('showSlide', (event) => {
            console.log(event)
            $('#offcanvasEnd' ).offcanvas(event.show);
        });

        Livewire.on('closeSlide', (event) => {
            $('#offcanvasEnd' ).offcanvas('hide');
        });
    });
</script>
