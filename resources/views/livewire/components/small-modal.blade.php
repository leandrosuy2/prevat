<div>
    <div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true" aria-labelledby="smallModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="smallModal">Modal 1 asadsasda asd </h5>--}}
{{--                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>--}}
{{--                </div>--}}
                <div class="modal-body">
                    @if($blade && $params['id'] != null && isset($params['professional_id']) &&$params['professional_id'] != null )
                        @livewire($blade, $params, key($params['professional_id']))
                    @elseif($blade && $params['id'] != null && isset($params['contract_id']) &&$params['contract_id'] != null)
                        @livewire($blade, $params, key($params['contract_id']))
                    @elseif($blade && $params)
                        @livewire($blade, $params, key($params['id']))
                    @endif
                </div>
{{--                <div class="modal-footer">--}}
{{--                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('showSmallModal', (event) => {
            $('#smallModal' ).modal(event.show);
        });

        Livewire.on('hideSmallModal', (event) => {
            $('#smallModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });
</script>
