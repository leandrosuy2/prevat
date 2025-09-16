@props([
    'label',
])

{{--<div--}}
{{--    x-data="{content: @entangle($attributes->wire('model')),...setupEditor()}"--}}
{{--    x-init="() => init($refs.editor)"--}}
{{--    wire:ignore--}}
{{--    {{ $attributes->whereDoesntStartWith('wire:model') }}>--}}
{{--    <textarea x-ref="editor" ></textarea>--}}

{{--</div>--}}

<div x-data="textarea(@entangle($attributes->wire('model')))">
    <label class="form-label">{{$label}}</label>
    <div class wire:ignore>

        <textarea type="text" x-ref="myTextArea" x-model="value" {{$attributes}} ></textarea>
    </div>
</div>


@section('scripts')
@once
    <script src="{{asset('build/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
    <script>
        console.log('teste');
        document.addEventListener('alpine:init', () => {
            Alpine.data('textarea', (model) => ({

                value: model,

                init() {
                    console.log('I\'m being initialized!')
                    this.value = 'teste';
                }



            }))
        })
    </script>
@endonce
@endsection
