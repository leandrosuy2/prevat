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
                        <img  style="height: 60px" src="{{ url('pdf/images/prevat_logo_pdf.png')}}" alt="logo"><br>
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
                            ATESTADO
                        </div>
                    </th>
                    <th class="heading-qrcode">
                        <div class="qrcode-container">

                        </div>
                    </th>
                </tr>
                </thead>
            </table>
            <div class="line"></div>

            <div class="title">
                <div class="center">

                </div>
                <div class="center">
                </div>

            </div>

            <div class="content">
                 <br><br>

                <p class="">Atestamos que a <span class="bold"> {{$itemCertification['company']['name']}}  - CNPJ –
                {{$itemCertification['company']['employer_number']}} </span> Promoveu o CURSO DE {{$itemCertification['training']['name']}}, aos seus
                colaboradores, para o quantitativo de {{$itemCertification['training_participation']['participants']->count()}} brigadistas formados, com carga horária de {{$itemCertification['training_participation']['schedule_prevat']['workload']['name']}}/aula, com aproveitamento de 100% nos dias
                {{ formatDate($itemCertification['training_participation']['schedule_prevat']['start_event']) }} a {{formatDate($itemCertification['training_participation']['schedule_prevat']['end_event'])}},
                realizado nas dependências da própria empresa.
                </p>

            </div>
            <div class="date" style="padding-top: 80px;">
                <p class="right">Barcarena-PA, {{ formatCertificate($itemCertification['training_participation']['schedule_prevat']['end_event'])}}</p>
            </div>

            <div class="footer-certificate">
                <table class="line-signatures-container center">
                    <tr class="">
                        <td width="33%">
                            @foreach($professionals['professionals'] as $itemProfessional)
                                @if($itemProfessional['professional']['signature_image'] && $itemProfessional['front'])
                                    <img  style="height: 180px" src="{{ url('storage/'.$itemProfessional['professional']['signature_image'])}}" alt="assinatura">
                                @endif
                            @endforeach
                        </td>
                        <td width="33%">
                            <img  style="height:180px;" src="{{ url('images/assinaturas/assinatura_diretor.png')}}" alt="assinatura_tecnico">
                        </td>
                        <td width="33%">
                            <img  style="height: 180px; " src="{{ url('images/assinaturas/assinatura_participante.png')}}" alt="assinatura_participante">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="page-break"></div>

        </div>
        <div class="web-container">
            <table class="line-items-container">
                <thead>
                <tr>
                    <th class="heading-logo">
                        <img  style="height: 60px" src="{{ url('pdf/images/prevat_logo_pdf.png')}}" alt="logo"><br>
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

                        </div>
                    </th>
                </tr>
                </thead>
            </table>
            <div class="line"></div>

            <div class="title">
                <div class="center">

                </div>

                <div class="center">

                </div>
            </div>

            <div class="content">
                <br><br>
                <p>Conferimos o presente certificado à <span class="bold">{{$itemCertification['participant']['name']}}</span>, inscrito no C.P.F. sob o n° {{$itemCertification['participant']['taxpayer_registration']}} por sua
                    participação no CURSO DE <span class="bold">{{$itemCertification['training']['name']}}</span>, com carga horária total de {{$itemCertification['training_participation']['schedule_prevat']['workload']['name']}}/aula realizado no
                    período de {{ formatDate($itemCertification['training_participation']['schedule_prevat']['start_event']) }} à  {{formatDate($itemCertification['training_participation']['schedule_prevat']['end_event'])}}, realizado nas dependências da própria empresa, tudo em conformidade com a
                    InstruçãoTécnica 08/2019 da DST do CBMPA.
                    </p>
                <br>
            </div>

            <div class="date" style="padding-top: 80px;">
                <p class="right">Barcarena-PA, {{ formatCertificate($itemCertification['training_participation']['schedule_prevat']['end_event'])}}</p>
            </div>

            <div class="footer-certificate">
                <table class="line-signatures-container center">
                    <tr class="">
                        <td width="33%">
                            @foreach($professionals['professionals'] as $itemProfessional)
                                @if($itemProfessional['professional']['signature_image'] && $itemProfessional['front'])
                                    <img  style="height: 180px" src="{{ url('storage/'.$itemProfessional['professional']['signature_image'])}}" alt="assinatura">
                                @endif
                            @endforeach
                        </td>
                        <td width="33%">
                            <img  style="height:180px;" src="{{ url('images/assinaturas/assinatura_diretor.png')}}" alt="assinatura_tecnico">
                        </td>
                        <td width="33%">
                            <img  style="height: 180px; " src="{{ url('images/assinaturas/assinatura_participante.png')}}" alt="assinatura_participante">
                        </td>
                    </tr>
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
