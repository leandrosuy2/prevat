<div>
</div>

    <!-- INTERNAL NOTIFICATIONS JS -->
    <script src="{{asset('build/assets/plugins/notify/js/rainbow.js')}}"></script>
    <script src="{{asset('build/assets/plugins/notify/js/jquery.growl.js')}}"></script>
    <script src="{{asset('build/assets/plugins/notify/js/notifIt.js')}}"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('notificationSuccess', (event) => {
                success(event)
                function success(){
                    notif({
                        msg: "<b>Sucesso : </b> " +event.phrase,
                        type: "success",
                        position: "left"
                    });
                }
            });

            Livewire.on('notificationError', (event) => {
                danger(event)
                function danger(){
                    notif({
                        msg: "<b>Erro : </b> " +event.phrase,
                        type: "error",
                        position: "left"
                    });
                }
            });
        });
    </script>

</div>
