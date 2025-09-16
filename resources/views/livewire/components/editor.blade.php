<div>
{{--    <div x-data="textarea(@entangle($attributes->wire('model')))"--}}
{{--         x-ref="editorQuill"--}}
{{--        --}}{{--     x-init="editorQuill"--}}
{{--    >--}}
        <div class="ql-wrapper ql-wrapper-demo" >
            <div id="{{ $quillId }}" wire:ignore>
                {!! nl2br(e($value)) !!}
            </div>
        </div>
{{--    </div>--}}
</div>

{{--@section('scripts')--}}
    <!-- INTERNAL FORMEDITOR JS -->
    <script src="{{asset('build/assets/plugins/quill/quill.min.js')}}"></script>

        <script>

            var icons = Quill.import('ui/icons');
            icons['bold'] = '<i class="fa fa-bold" aria-hidden="true"><\/i>';
            icons['italic'] = '<i class="fa fa-italic" aria-hidden="true"><\/i>';
            icons['underline'] = '<i class="fa fa-underline" aria-hidden="true"><\/i>';
            icons['strike'] = '<i class="fa fa-strikethrough" aria-hidden="true"><\/i>';
            icons['list']['ordered'] = '<i class="fa fa-list-ol" aria-hidden="true"><\/i>';
            icons['list']['bullet'] = '<i class="fa fa-list-ul" aria-hidden="true"><\/i>';
            icons['link'] = '<i class="fa fa-link" aria-hidden="true"><\/i>';
            icons['image'] = '<i class="fa fa-image" aria-hidden="true"><\/i>';
            icons['video'] = '<i class="fa fa-film" aria-hidden="true"><\/i>';
            icons['code-block'] = '<i class="fa fa-code" aria-hidden="true"><\/i>';

            var toolbarOptions = [
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                ['link', 'image', 'video']
            ];

            const quill = new Quill('#{{ $quillId }}', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });

            quill.on('text-change', function () {
                let value = document.getElementsByClassName('ql-editor')[0].innerHTML;
                @this.set('value', value)
            })
        </script>





