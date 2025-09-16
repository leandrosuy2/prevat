<style>
    .wrapper {
        position: relative;
        width: 600px;
        height: 200px;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .signature-pad {
        width:100%;
        height:100%;
        background-color: white;
    }
</style>

<div wire:ignore x-data="{
    signature: @entangle($attributes->get('wire:model')),
    signaturePadId: $id('signature'), // track the pad ID when showing notification
    signaturePad: null,
    signature: null, // variable to save the signature
    ratio: null,
    init() {
{{--        this.resizeCanvas(); // resize canvas before initializing--}}
        this.signaturePad = new SignaturePad($refs.canvas);
        // load if the signature is not null﻿ (usefull to show the saved signature in db)
        if (this.signature) {
            this.signaturePad.fromDataURL(this.signature);
        }
    },
        save() {
        this.signature = this.signaturePad.toDataURL('image/png');
{{--        this.$dispatch('signature-saved', this.signature);--}}
{{--        Livewire.dispatch('signature-saved', { text: content});--}}
{{--         $wire.dispatch('signature-saved');--}}
         $wire.dispatch('signature-saved', { refreshPosts: this.signature });

    },
    clear() {
        this.signaturePad.clear(); // clear the signature pad
        this.signature = null;
    },
}">
{{--    <div class="wrapper">--}}
    <canvas x-ref="canvas" class="signature-pad border rounded shadow" width=400 height=200></canvas>
{{--    </div>--}}
    <div class="flex mt-2 space-x-2 py-4">
        <button x-on:click.prevent="clear()" type="submit" class="btn btn-danger"> Limpar </button>

        <button x-on:click.prevent="save()" class="btn btn-primary"> Salvar </button>

    </div>
</div>

<!-- Push to the stack we created in app.blade.php -->
@pushonce('scripts')
{{--    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
@endpushonce
