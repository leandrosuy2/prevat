<div>
    <div class="modal fade" id="confirmDeleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{$title}}</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <p>{{$pharse}}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-danger" wire:click="delete({{$id}})">Apagar</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('showConfirmDeleteModal', (event) => {
            $('#confirmDeleteModal' ).modal(event.show);
        });

        Livewire.on('hideConfirmDeleteModal', (event) => {
            $('#confirmDeleteModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });
</script>
