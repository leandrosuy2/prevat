<div>
    <h3 class="cta-one__left__title">Nosso atendimento.</h3>
    @foreach($response->contacts as $itemContact)

    <h5 style=" margin-top: -10px; color: #FFF">{{$itemContact['name']}} </h5>
        @if($itemContact['whatsapp01'])
            <p class="mb-0 text-white">Whatsapp : <a href="https://wa.me/{{ preg_replace('/[^\d]/','',$itemContact['whatsapp02']) }}" target="_blank"> {{$itemContact['whatsapp01']}} </a></p>
        @endif
        @if($itemContact['whatsapp02'])
            <p class="mb-0 text-white">Whatsapp : <a href="https://wa.me/{{ preg_replace('/[^\d]/','',$itemContact['whatsapp02']) }}" target="_blank"> {{$itemContact['whatsapp02']}} </a></p>
        @endif
        @if($itemContact['email01'])
            <p class="mt-0 text-white">Email : {{$itemContact['email01']}} </p>
        @endif
        @if($itemContact['email02'])
            <p class="mt-0 text-white">Email : {{$itemContact['email02']}} </p>
        @endif
    @endforeach
</div>
