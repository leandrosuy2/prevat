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
{{--    <label class="form-label">{{$label}}</label>--}}
    <div class wire:ignore>

        <textarea type="text" x-ref="myTextArea" x-model="value" {{$attributes}} id="teteia" ></textarea>
    </div>
</div>


@section('scripts')
    @once
        <script src="{{asset('build/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('textarea', (model) => ({

                    value: model,

                    init() {
                        // $('#teteia').text(this.value);

                        $('#teteia').val(this.value).html();

                        $('.testes').richText( {

                            // text formatting
                            bold: true,
                            italic: true,
                            underline: true,

                            // text alignment
                            leftAlign: true,
                            centerAlign: true,
                            rightAlign: true,
                            justify: true,

                            // lists
                            ol: true,
                            ul: true,

                            // title
                            heading: true,

                            // fonts
                            fonts: true,
                            fontList: [
                                "Arial",
                                "Arial Black",
                                "Comic Sans MS",
                                "Courier New",
                                "Geneva",
                                "Georgia",
                                "Helvetica",
                                "Impact",
                                "Lucida Console",
                                "Tahoma",
                                "Times New Roman",
                                "Verdana"
                            ],
                            fontColor: true,
                            backgroundColor: true,
                            fontSize: true,

                            // uploads
                            imageUpload: true,
                            fileUpload: true,

                            // media
                            videoEmbed: true,

                            // link
                            urls: true,

                            // tables
                            table: true,

                            // code
                            removeStyles: true,
                            code: true,

                            // colors
                            colors: [],

                            // dropdowns
                            fileHTML: '',
                            imageHTML: '',

                            // translations
                            translations: {
                                'title': 'Title',
                                'white': 'White',
                                'black': 'Black',
                                'brown': 'Brown',
                                'beige': 'Beige',
                                'darkBlue': 'Dark Blue',
                                'blue': 'Blue',
                                'lightBlue': 'Light Blue',
                                'darkRed': 'Dark Red',
                                'red': 'Red',
                                'darkGreen': 'Dark Green',
                                'green': 'Green',
                                'purple': 'Purple',
                                'darkTurquois': 'Dark Turquois',
                                'turquois': 'Turquois',
                                'darkOrange': 'Dark Orange',
                                'orange': 'Orange',
                                'yellow': 'Yellow',
                                'imageURL': 'Image URL',
                                'fileURL': 'File URL',
                                'linkText': 'Link text',
                                'url': 'URL',
                                'size': 'Size',
                                'responsive': 'Responsive',
                                'text': 'Text',
                                'openIn': 'Open in',
                                'sameTab': 'Same tab',
                                'newTab': 'New tab',
                                'align': 'Align',
                                'left': 'Left',
                                'justify': 'Justify',
                                'center': 'Center',
                                'right': 'Right',
                                'rows': 'Rows',
                                'columns': 'Columns',
                                'add': 'Add',
                                'pleaseEnterURL': 'Please enter an URL',
                                'videoURLnotSupported': 'Video URL not supported',
                                'pleaseSelectImage': 'Please select an image',
                                'pleaseSelectFile': 'Please select a file',
                                'bold': 'Bold',
                                'italic': 'Italic',
                                'underline': 'Underline',
                                'alignLeft': 'Align left',
                                'alignCenter': 'Align centered',
                                'alignRight': 'Align right',
                                'addOrderedList': 'Ordered list',
                                'addUnorderedList': 'Unordered list',
                                'addHeading': 'Heading/title',
                                'addFont': 'Font',
                                'addFontColor': 'Font color',
                                'addBackgroundColor': 'Background color',
                                'addFontSize': 'Font size',
                                'addImage': 'Add image',
                                'addVideo': 'Add video',
                                'addFile': 'Add file',
                                'addURL': 'Add URL',
                                'addTable': 'Add table',
                                'removeStyles': 'Remove styles',
                                'code': 'Show HTML code',
                                'undo': 'Undo',
                                'redo': 'Redo',
                                'close': 'Close',
                                'save': 'Save'
                            },

                            // privacy
                            youtubeCookies: false,

                            // preview
                            preview: false,

                            // placeholder
                            placeholder: '',

                            // developer settings
                            useSingleQuotes: false,
                            height: 0,
                            heightPercentage: 0,
                            adaptiveHeight: false,
                            id: "",
                            class: "",
                            useParagraph: false,
                            maxlength: 0,
                            maxlengthIncludeHTML: false,
                            callback: undefined,
                            useTabForNext: false,
                            save: false,
                            saveCallback: undefined,
                            saveOnBlur: 0,
                            undoRedo: true
                        });
                    }

                    //     this.pickr = flatpickr(this.$refs.myDaterange, {
                    //         altInput: true,
                    //         mode: "range",
                    //         altFormat: "j, F Y",
                    //         dateFormat: "Y-m-d",
                    //         defaultDate: this.value
                    //     })
                    //     this.$watch('value', function(newValue){
                    //         this.pickr.setDate(newValue);
                    //     }.bind(this));
                    // },
                    // reset(){
                    //     this.value = null;
                    // }
                }))
            })
        </script>

{{--        <script>--}}

{{--            function quillEditor() {--}}
{{--                var quill = new Quill($refs.quillEditor, {--}}
{{--                    modules: {--}}
{{--                        toolbar: [--}}
{{--                            [{ header: [1, 2, false] }],--}}
{{--                            ['bold', 'italic', 'underline'],--}}
{{--                            [{ 'align': ['', 'right', 'center']}],--}}
{{--                        ],--}}
{{--                    },--}}
{{--                    theme: 'snow'--}}
{{--                });--}}
{{--            }--}}

{{--            // document.addEventListener('alpine:init', () => {--}}
{{--            //     Alpine.data('textarea', (model) => ({--}}
{{--            //         value: model,--}}
{{--            //--}}
{{--            //         init() {--}}
{{--            //             new Quill('#quillTeste', {--}}
{{--            //                 modules: {--}}
{{--            //                     toolbar: toolbarOptions--}}
{{--            //                 },--}}
{{--            //                 theme: 'snow'--}}
{{--            //             });--}}
{{--            //             quill.on('text-change', function () {--}}
{{--            //             @this.set('value', quill.getContents())--}}
{{--            //             });--}}
{{--            //         }--}}
{{--            //     }))--}}
{{--            //--}}
{{--            //--}}
{{--            // })--}}
{{--        </script>--}}
    @endonce
@endsection
