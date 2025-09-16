<div>
    <div wire:ignore>
        <textarea class="content" > {!! nl2br(e($value)) !!}</textarea>


    </div>
    <p id="demo"></p>
</div>

@section('scripts')
<script src="{{asset('build/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
{{--    <script src="{{asset('build/assets/plugins/wysiwyag/wysiwyag.js')}}"></script>--}}

<script >
    $(function(e) {
        $('.content').richText();
        $('.content2').richText();
    });


</script>
@endsection
