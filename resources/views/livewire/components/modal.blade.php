<div>
    <div class="modal fade" id="largemodal" tabindex="-1"  role="dialog" aria-labelledby="largemodal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    @if($blade && $params['id'] != null && isset($params['professional_id']) &&$params['professional_id'] != null )
                        @livewire($blade, $params, key($params['professional_id']))
                    @elseif($blade && $params['id'] != null && isset($params['contract_id']) &&$params['contract_id'] != null)
                        @livewire($blade, $params, key($params['contract_id']))
                    @elseif($blade && $params)
                        @livewire($blade, $params, key($params['id']))
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('showModal', (event) => {
            $('#largemodal' ).modal(event.show);
        });

        Livewire.on('closeModal', (event) => {
            $('#largemodal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });
</script>
