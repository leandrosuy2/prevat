@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">

<img src="https://www.prevat.com.br/site/arquivos/logo-branco.png" class="logo" alt="Laravel Logo">
{{--@if (trim($slot) === 'Laravel')--}}
{{--<img src="https://www.prevat.com.br/build/assets/images/brand/prevat_logo.png" class="logo" alt="Laravel Logo">--}}
{{--@else--}}
{{--{{ $slot }}--}}
{{--@endif--}}
</a>
</td>
</tr>
