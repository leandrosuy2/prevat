<div
    x-data="{ model: @entangle($attributes->wire('model'))}"
    x-init="
       select2 = $($refs.select).select2();

       select2.on('select2:select', (event) => {
          if (event.target.hasAttribute('multiple')) {
            model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
          } else {
            model = event.target.value;
          }
       });

        select2.on('select2:unselect', (event) => {
            model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
        });

       $watch('model', (value) => {
           select2.val(value).trigger('change');
    });
    "
    wire:ignore
>
    <select x-ref="select" {{ $attributes->merge(['class' => 'form-control']) }}>
        {{ $slot }}
    </select>
</div>

{{--<script src="{{asset('build/assets/plugins/select2/select2.full.min.js')}}"></script>--}}
{{--@vite('resources/assets/js/select2.js')--}}
