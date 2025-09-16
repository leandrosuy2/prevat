<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 6000">
    <div id="liveToastSuccess" class="toast" role="alert"
         aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="Title"></strong>
            <button aria-label="Close" class="btn-close fs-15"
                    data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="Pharse">
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('showToast', (event) => {

            $('#Title').text(event.title);
            $('#Pharse').text(event.phrase);
            $('#liveToastSuccess').toast('show');
        });
    });
</script>


@section('scripts')

    <!-- INTERNAL NOTIFICATIONS JS -->
    <script src="{{asset('build/assets/plugins/notify/js/rainbow.js')}}"></script>
    <script src="{{asset('build/assets/plugins/notify/js/sample.js')}}"></script>
    <script src="{{asset('build/assets/plugins/notify/js/jquery.growl.js')}}"></script>
    <script src="{{asset('build/assets/plugins/notify/js/notifIt.js')}}"></script>

@endsection
