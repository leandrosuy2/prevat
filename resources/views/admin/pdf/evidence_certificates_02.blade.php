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
{{--    @dd($certifications)--}}
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

                            @php
                                $reference = $itemCertification['reference'] ?? (new \App\Services\ReferenceService())->getReference();
                                $path = 'images/qrcodes/'.$reference.'.png';
                                
                                if(!file_exists(public_path($path))) {
                                    if(!is_dir(public_path('images/qrcodes'))) {
                                        mkdir(public_path('images/qrcodes'), 0755, true);
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
        </div>
        <div class="page-break"></div>
        <div class="web-container">
            <div class="header-programatic center">
                CONTEÚDO PROGRAMÁTICO DA AMBIENTAÇÃO
            </div>

            <div class="content-programatic_02">
                <table style="font-size: 12px; line-height:1.5em; border-spacing: 15px; font-family: Arial; border-bottom: 1px solid;">
                    <tr>
                        <th width="33%" style="text-align: left; vertical-align:top; border-right: 1px solid; padding-right: 10px; ">
                            <div class="content-programatic-title-02 center">
                                INTEGRAÇÃO DE HSE PARA NOVOS EMPREGADOS
                            </div>
                            <ul style="padding-top: 0px;">
                                <li>Vídeos institucionais da Albras</li>
                                <li>Perigos e Riscos Ocupacionais</li>
                                <li>Atendimento de incidente do Trabalho e
                                    Registro de Quase incidente</li>
                                <li>Programa Risco Zero</li>
                                <li>Uso de Adornos na Albras</li>
                                <li>Segurança para MÃOS e DEDOS</li>
                                <li>EPI - Equipamento de Proteção Individual</li>
                                <li>Regras Gerais de HSE</li>
                                <li>ADV</li>
                            </ul>
                        </th>
                        <th width="33%" style="text-align: left; vertical-align:top; border-right: 1px solid; ">
                            <div class="content-programatic-title-02 center">
                                ADV - AUTORIZAÇÃO PARA DIRIGIR VEÍCULOS:
                            </div>
                            <ul class="">
                                <li> Estatística de incidentes de trânsito</li>
                                <li> Exemplos de Veículos Industriais</li>
                                <li> Vídeos de condução perigosa na Albras e em outras
                                    plantas</li>
                                <li> Credenciamento de Veículos Leves/Pesados e Veículos
                                    Industriais</li>
                                <li> ADV – Autorização Para Dirigir Veículos e renovação da
                                    ADV</li>
                                <li> Infrações de Trânsito</li>
                                <li> Transporte de pessoas</li>
                                <li> Regras para circulação de veículos na Albras</li>
                                <li> Segurança no Trânsito para Motociclistas</li>
                            </ul>
                        </th>

                        <th width="33%" style="text-align: left; vertical-align:top; padding-right: 10px;">
                            <div class="content-programatic-title-02 center">
                                MDHO – MELHORIA DO DESEMPENHO HUMANO
                                ORGANIZACIONAL:
                            </div>
                            <ul class="">
                                <li> Introdução</li>
                                <dl>
                                    <dt> > O que é a Melhoria no Desempenho Humano e Organizacional – MDHO</dt>
                                    <dt> > Por que falamos de MDHO na Albras</dt>
                                </dl>
                                <li> Fundamentos da MDHO;
                                <li> Práticas preventivas para MDHO</li>
                                <dl>
                                    <dt> > RAS / CPT / WOC</dt>
                                    <dt> > Programa ANJO DA GUARDA</dt>
                                    <dt> > Cartão PARE – EU POSSO PARAR !</dt>
                                    <dt> > Exame Toxicológico conforme PPAD</dt>
                                </dl>
                                <li> Matriz de Suporte para Medidas Disciplinares em  HSE</li>
                                <li> Ciclo Virtuoso da MDHO</li>
                            </ul>
                        </th>
                </table>
                <table style="font-size: 12px; line-height:1.5em; border-spacing: 15px; font-family: Arial;">
                    <tr colspan="3">
                        <th width="50%" style="text-align: left; vertical-align:top; border-right: 1px solid; padding-right: 10px; ">
                            <div class="content-programatic-title-02 center">
                                GESTÃO DE RISCOS:
                            </div>
                            <ul class="">
                                <li> Permissões de Trabalho
                                    <dl>
                                        <dt> > PTQ - Permissão de Trabalho a Quente SOP AB-05-03-17</dt>
                                        <dt> > PTA - Permissão de Trabalho em Altura SOP AB-05-03-19</dt>
                                        <dt> > PTI – Permissão de Trabalho de Içamento SOP AB-05-03-32</dt>
                                        <dt> > PET – Permissão de Trabalho em Espaço Confinado SOP AB-05-03-14</dt>
                                    </dl>
                                <li> Protocolos Críticos da Hydro (Prevenção de Fatalidades)</li>
                                <li> Acesso ao subforno SOP AB-05-04-05</li>
                                <li> EBTV SOP AB-05-03-13</li>
                                <li> Hierarquia de controle dos riscos</li>
                            </ul>

                        </th>
                        <th width="50%" style="text-align: left; vertical-align:top; padding-right: 10px; ">
                            <div class="content-programatic-title-02 center">
                                REGRAS EMPRESARIAIS:
                            </div>
                            <ul class="">
                                <li> Telefones de Emergência</li>
                                <li> Serviço de Portaria</li>
                                <li> Segurança no Trânsito Interno</li>
                                <li> Cuidado Ativo </li>
                            </ul>
                        </th>
                    </tr>
                </table>
            </div>

            <div class="signatures">
                <table class="line-signatures-container center" style="padding-top: 10px;">
                    <tr class="">
                        <td class="">

                        </td>

                        <td class="">
                            @foreach($professionals['professionals'] as $itemProfessional)
                                @if($itemProfessional['verse'] && $itemProfessional['professional']['signature_image'])
                                    <img  style="height: 100px; padding-bottom:25px; padding-left: 20px; padding-right: 30px;" src="{{ url('storage/'.$itemProfessional['professional']['signature_image'])}}" alt="assinatura">
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

