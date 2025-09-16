<div>
    <section class="testimonial-two" style="background-image: url(assets/images/shapes/testimonial-bg-2.webp);  padding-top: 30px" >
        <div class="container">
            @if($certificate)
            <div class="section-title text-center">
                    <span class="section-title__tagline" style=' font-weight: bold'>

                        {{$certificate['participant']['name']}}<br>
                        {{$certificate['participant']['taxpayer_registration']}}
                    </span>
                <h2 class="section-title__title mt-2">{{$certificate['training']['name']}}</h2>
                <br>
                <span class="section-title__tagline" style=' font-weight: bold'>

                    Nota :
                    {{$certificate['note']}}
                </span>

            </div>
            <p class="">
                {{$certificate['training']['description']}}
            </p>

            <span>Carga Horária do Treinamento: {{$certificate['training_participation']['schedule_prevat']['workload']['name']}} </span><br>

            @if($certificate['training_participation']['schedule_prevat']['time02_id'] != null)
                <span> Data do Treinamento: {{ formatDate($certificate['training_participation']['schedule_prevat']['start_event']) }} a {{formatDate($certificate['training_participation']['schedule_prevat']['end_event'])}}</span><br>
            @else
                <span> Data do Treinamento: {{ formatDate($certificate['training_participation']['schedule_prevat']['start_event']) }}</span><br>
            @endif

            <span> Local do Treinamento: {{$certificate['training_participation']['schedule_prevat']['location']['name']}} -
                {{$certificate['training_participation']['schedule_prevat']['location']['address']}} - {{$certificate['training_participation']['schedule_prevat']['location']['number']}} -
                {{$certificate['training_participation']['schedule_prevat']['location']['complement']}}  - {{$certificate['training_participation']['schedule_prevat']['location']['neighborhood']}} -
                {{$certificate['training_participation']['schedule_prevat']['location']['city']}} - {{$certificate['training_participation']['schedule_prevat']['location']['uf']}} </span>

        </div>
        @else
            <div class="section-title text-center">

                <h2 class="section-title__title pt-5">Registro não encontrado</h2>

            </div>
        @endif
    </section>
</div>
