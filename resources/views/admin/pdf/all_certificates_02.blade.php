<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Certificados Gerados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ url('pdf/web/modern-normalize.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/web/web-base.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/invoice.css')}}" rel="stylesheet" />

</head>
<body>

<div>
    @foreach($certifications as $itemCertification)
    <div class="web-container">
        <table class="line-items-container">
            <thead>
            <tr>
                <th class="heading-logo">
                    <img  style="height: 70px" src="{{ url('pdf/images/prevat_logo_pdf.png')}}" alt="logo"><br>
                    <div class="logo-info ">
                        <span>CNPJ: 20.827.565/0001-54 </span><br>
                        <span>End.: Rua Raimundo José Coutinho, Qd. 246. Lt.21, </span><br>
                        <span>Bairro Núcleo Urbano, CEP: 68447-000 </span><br>
                        <span> Vila dos Cabanos – Barcarena / PA. </span><br>
                        <span>Fone: (91) 99231-4994 / 99367-6162 / 99663-1126 </span><br>
                        <span>E-mail: atendimento2@prevat.com.br </span>
                    </div>
                </th>

                <th class="heading-description">
                    <div class="text-certificate center">
                        CERTIFICADO
                    </div>
                </th>
                <th class="heading-qrcode">
                    <div class="qrcode-container">
                        <div class="registry text-nowrap">
                            NOTA
                        </div>

                        <div class="note text-nowrap">
                            <span class="center text-lg-center" style="white-space: nowrap;"> {{$itemCertification['note']}}</span>
                        </div>

                    </div>
                </th>
            </tr>
            </thead>
        </table>
        <div class="line"></div>

        <div class="title">
            <div class="center">
                Certificado de Conclusão do Sr.(a):
            </div>

            <div class="center">
                {{$itemCertification['participant']['name']}} - CPF : {{$itemCertification['participant']['taxpayer_registration']}}
            </div>

        </div>

        <div class="content">
           {!! $itemCertification['training']['description'] !!}

        <br><br>
            <span>Carga Horária do Treinamento: {{$itemCertification['training_participation']['schedule_prevat']['workload']['name']}} </span><br>

            @if($itemCertification['training_participation']['schedule_prevat']['time02_id'] != null)
                <span> Data do Treinamento: {{ formatDate($itemCertification['training_participation']['schedule_prevat']['start_event']) }} a {{formatDate($itemCertification['training_participation']['schedule_prevat']['end_event'])}}</span><br>
            @else
                <span> Data do Treinamento: {{ formatDate($itemCertification['training_participation']['schedule_prevat']['start_event']) }}</span><br>
            @endif

{{--            <span> Data do Treinamento: {{ formatDate($itemCertification['training_participation']['schedule_prevat']['date_event']) }} </span><br>--}}
            <span> Local do Treinamento: {{$itemCertification['training_participation']['schedule_prevat']['location']['name']}} -
        {{$itemCertification['training_participation']['schedule_prevat']['location']['address']}} - {{$itemCertification['training_participation']['schedule_prevat']['location']['number']}} -
        {{$itemCertification['training_participation']['schedule_prevat']['location']['complement']}}  - {{$itemCertification['training_participation']['schedule_prevat']['location']['neighborhood']}} -
                {{$itemCertification['training_participation']['schedule_prevat']['location']['city']}} - {{$itemCertification['training_participation']['schedule_prevat']['location']['uf']}} </span>
        </div>
        <div class="date">
              <p class="right">Barcarena-PA, {{ formatCertificate($itemCertification['training_participation']['schedule_prevat']['end_event'])}}</p>
        </div>

        <div class="footer-certificate">
            <table class="line-signatures-container center" style="margin-bottom: 100px;" >
                <tr class="">
                    <td width="33%">
                        <img  style="height:180px;" src="{{ url('images/assinaturas/assinatura_diretor.png')}}" alt="assinatura_tecnico">
                    </td>
                    <td width="33%" style="margin-right: 50px;">
                        <img  style="height: 180px; " src="{{ url('images/assinaturas/assinatura_participante.png')}}" alt="assinatura_participante">
                    </td>
                    <td width="1%">
                    </td>
                </tr>
            </table>
        </div>

        <div  style="height: 120px;">
            <table class="line-signatures-container center">
            </table>
        </div>
        @if(!$loop->last)
        <div class="page-break"></div>
        @endif
    </div>
</div>
@endforeach

</body>
</html>
