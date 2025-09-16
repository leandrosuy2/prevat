@props([
    'label',
])

<div x-data="timepicker(@entangle($attributes->wire('model')))">
    <label class="form-label">{{$label}}</label>
    <div class="input-group" wire:ignore>
        <div class="input-group-text input-group-sm">
            <i class="typcn typcn-stopwatch tx-20 lh--9 op-6"></i>
        </div>
        <input type="text" x-ref="myTimepicker" x-model="value" {{$attributes}}   placeholder="Escolha a Hora">
    </div>
</div>

@once
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('timepicker', (model) => ({
                value: model,
                init(){
                    this.pickr = flatpickr(this.$refs.myTimepicker, {
                        altInput: true,
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true,
                        defaultDate: this.value
                    })
                    this.$watch('value', function(newValue){
                        this.pickr.setDate(newValue);
                    }.bind(this));
                },
                reset(){
                    this.value = null;
                }
            }))
        })
    </script>
@endonce
