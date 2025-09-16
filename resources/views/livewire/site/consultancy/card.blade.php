<div>
    <div class="row">
        @foreach($response->consultancies as $itemConsultancy)
            <div class="col-xl-6 wow fadeInUp" data-wow-delay="200ms">
                <div class="blog-one__item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="blog-one__image">
                                @if($itemConsultancy['image'])
                                    <img src="{{url('storage/'.$itemConsultancy['image'])}}" alt="Nome do Conteúdo" loading="lazy" width="360" height="auto" style=" width: 100%; height: 180px;">
                                @else
                                    <img src="{{url('images/sem_foto.png')}}" alt="Sem Imagem" loading="lazy" width="360" height="auto" style=" width: 100%; height: 180px;">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7 d-flex align-items-center">
                            <div class="blog-one__content">
                                <h5 class="fs-12 mt-2">
                                    {{$itemConsultancy['name']}}
                                </h5>
                                <p class="fs-10">
                                    {!! $itemConsultancy['description'] !!}
                                </p>
                                {{--                                            <div class="hero-banner__btn wow fadeInUp" data-wow-delay="600ms" style= "margin-top: 20px">--}}
                                {{--                                                <a href="consultoria-detalhes.html" class="eduact-btn" style=" float: left; width: 100%;"><span class="eduact-btn__curve"></span>Acesse Agora <i class="icon-arrow"></i></a>--}}
                                {{--                                            </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
