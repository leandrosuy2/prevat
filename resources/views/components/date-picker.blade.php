@props([
    'label',
])

<div x-data="datepicker(@entangle($attributes->wire('model')))">
    <label class="form-label">{{$label}}</label>
    <div class="input-group" wire:ignore>
        <div class="input-group-text input-group-sm">
            <i class="typcn typcn-calendar-outline tx-20 lh--2 op-6"></i>
        </div>
        <input type="text" x-ref="myDatepicker" x-model="value" {{$attributes}}   placeholder="Escolha a data">
    </div>
</div>

@once
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('datepicker', (model) => ({
                value: model,
                init(){
                    this.pickr = flatpickr(this.$refs.myDatepicker, {
                        altInput: true,
                        altFormat: "j, F Y",
                        dateFormat: "Y-m-d",
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
