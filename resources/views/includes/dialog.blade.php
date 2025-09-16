<div class="modal fade" id="Vertically">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Atenção</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir o item selecionado ?</p>
                <p id="nomeUsuario"></p>
                <div class="d-none" id="confirmDelete"></div>
                <div class="d-none" id="idUsuario"></div>

            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" id="btn" value="">Apagar</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('livewire:init', () => {
        document.getElementById("btn").addEventListener("click", function(){

            var value = document.getElementById('idUsuario').textContent;
            var confirmDelete = document.getElementById('confirmDelete').textContent;

            Livewire.dispatch(confirmDelete, { id: value })
        });
    });
</script>
