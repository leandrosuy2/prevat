<div
    x-data="{ model: @entangle($attributes->wire('model'))}"
    x-init="select2Alpine"
    x-on:post-created="select2Alpine"
    wire:ignore
>
    <select x-ref="select" {{ $attributes->merge(['class' => 'form-select']) }}>
        {{ $slot }}
    </select>
</div>

@push('scripts')
<script>
    function select2Alpine() {
        this.select2 = $(this.$refs.select).select2({
            dropdownParent: $('#largemodal')
        });

        this.select2.on('select2:select', (event) => {
            if (event.target.hasAttribute('multiple')) {
                this.model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
            } else {
                this.model = event.target.value;
            }
        });

        this.select2.on('select2:change', (event) => {
            if (event.target.hasAttribute('multiple')) {
                this.model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
            } else {
                this.model = event.target.value;
            }
        });

        this.select2.on('select2:unselect', (event) => {
            this.model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
        });

        this.$watch('model', (value) => {
            this.select2.val(value).trigger('change');

        });
    }

    document.addEventListener('livewire:init', () => {
        Livewire.on('post-created', (event) => {
            select2Alpine()

        });
    });
</script>


@endpush
{{--<script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>--}}
{{--@vite('resources/assets/js/select2.js')--}}
