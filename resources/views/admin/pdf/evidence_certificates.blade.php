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
                            CERTIFICADO
                        </div>
                    </th>
                    <th class="heading-qrcode">
                        <div class="qrcode-container">
                            <div class="registry text-nowrap">
                                Registro : {{formatNumber($itemCertification['registry'])}} / {{$itemCertification['year']}}
                            </div>

                            @php
                                $reference = $itemCertification['reference'] ?? (new \App\Services\ReferenceService())->getReference();
                                $path = 'qrcodes/'.$reference.'.png';
                                
                                if(!file_exists(public_path($path))) {
                                    if(!is_dir(public_path('qrcodes'))) {
                                        mkdir(public_path('qrcodes'), 0755, true);
                                    }
                                    $qrCodePath = public_path($path);
                                    \LaravelQRCode\Facades\QRCode::url(url('consulta-certificado/'.$reference))
                                        ->setOutfile($qrCodePath)
                                        ->setSize(4)
                                        ->setMargin(2)
                                        ->png();
                                    
                                    $itemCertification->path_qrcode = $path;
                                    $itemCertification->save();
                                }
                            @endphp
                            <img src="{{ url($path) }}" alt="qrcode">

                            <span class="center text-xs" style="white-space: nowrap;"> Consulte Aqui</span>

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
                    {{$itemCertification['participant']['name'] ?? ' '}} - CPF : {{$itemCertification['participant']['taxpayer_registration'] ?? 'S/C'}}
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

{{--            @if(!$loop->last)--}}
{{--                <div class="page-break"></div>--}}
{{--            @endif--}}
        </div>
        <div class="page-break"></div>
        <div class="web-container">
            <div class="header-programatic center">
                CONTEÚDO PROGRAMÁTICO DE TREINAMENTO
            </div>

            <div class="content-programatic-title center">
                {{$content['training']['name']}}
            </div>

            <div class="content-programatic">
                <table style="font-size: 14px; line-height:1.5em; border-spacing: 15px; font-family: Arial;">
                    @if($content['training']['content02'])
                        <tr>
                            <th width="50%" style="text-align: left; vertical-align:top; margin-right: 50px">
                                {!! nl2br(e($content['training']['content'])) !!}
                            </th>
                            <th width="50%" style="text-align: left; vertical-align:top;">
                                {!! nl2br(e($content['training']['content02'])) !!}
                            </th>
                            @else
                                <th width="50%" style="text-align: left; vertical-align:top; margin-right: 50px">
                                    {!! nl2br(e($content['training']['content'])) !!}
                                </th>
                            @endif
                        </tr>
                </table>
            </div>

            <div class="signatures">
                <table class="line-signatures-container center" style="padding-top: 30px;">
                    <tr class="">
                        <td class="">

                        </td>

                        <td class="">
                            @foreach($professionalsProgramatic as $itemProfessionalP)
                                @if($itemProfessionalP['verse'] && $itemProfessionalP['professional']['signature_image'])
                                    <img  style="height: 100px; padding-bottom:50px; padding-left: 20px; padding-right: 30px;" src="{{ url('storage/'.$itemProfessionalP['professional']['signature_image'])}}" alt="assinatura">
                                @endif
                            @endforeach
                        </td>

                        <td class="">

                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer-programatic">
                <span class="">PREVAT - Treinamento</span>
                <div class="">
                    Amparo Legal: Art. 1 do Decreto 5154/04, a Educação Profissional prevista no Art. 39 da Lei 9394/96 Lei de Diretrizes e Bases da Educação
                </div>
            </div>

        </div>
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
</div>
@endforeach

</body>
</html>

