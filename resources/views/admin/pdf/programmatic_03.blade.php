<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Certificados Gerados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ url('pdf/web/modern-normalize.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/web/web-base.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/invoice.css')}}" rel="stylesheet" />

    <style>
        @font-face {
            font-family: Arial;
            font-style: normal;
        }
    </style>
</head>
<body>

<div class="web-container">

    <div class="content-programatic_03">
        <table style="font-size: 12px; line-height:1.5em; border-spacing: 15px; font-family: Arial; ">
            <tr>
                <th width="60%" style="text-align: left; vertical-align:top; padding-right: 30px; ">
                    <div class="content-programatic-title-02 center">
                        <p class="">PARTICIPANTES</p>
                    </div>
                    <table style="border: 1px solid;  border-collapse: collapse;">
                        <tr>
                            <th width="70%" style="text-align: left; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                NOME
                            </th>

                            <th width="30%" style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                CPF
                            </th>
                        </tr>
                            @foreach($participants as $itemParticipant)
                            <tr>
{{--                                @dd($itemParticipant)--}}
                                <th width="70%" style="text-align: left; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                    {{$itemParticipant['participant']['name']}}
                                </th>

                                <th width="30%" style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                    {{$itemParticipant['participant']['taxpayer_registration']}}
                                </th>
                            </tr>
                            @endforeach

                    </table>

                </th>
                <th width="40%" style="text-align: left; vertical-align:top;  ">
                    <div class="content-programatic-title-02 center">
                        <p class="bold">CONTEÚDO PROGRAMÁTICO <br> Aulas teóricas (16h):</p>
                    </div>
                    <ol type="1" style="font-size: 10px;">
                        <li> Introdução (Objetivos do curso e dos Brigadistas)</li>
                        <li> O que é fogo</li>
                        <li> Triangulo dofogo</li>
                        <li> Teoria do fogo (Combustão, seus elementos e a reação em
                        cadeia)</li>
                        <li> Propagação do fogo; Classes deincêndio</li>
                        <li> Métodos de extinção</li>
                        <li> Agentes extintores</li>
                        <li> Extintores de incêndio</li>
                        <li> Técnicas de combate a incêndio comextintores</li>
                        <li> Procedimentos básicos em locais de Incêndio</li>
                        <li> Sistemas fixos de combate a incêndio</li>
                        <li> Sistemas de detecção, alarme ecomunicações</li>
                        <li> Ferramentas de salvamento</li>
                        <li> Técnicas de combate a incêndio com uso de mangueiras e
                        hidrantes</li>
                        <li> Exigências legais quanto à instalação,
                        localização e sinalização dos extintores de incêndio e hidrantes</li>
                        <li> Pessoas com mobilidade reduzida</li>
                        <li> Procedimentos básicos em locais de Incêndio</li>
                        <li> Riscos específicos da planta e Prevenção de incêndio</li>
                        <li> Plano de Emergência</li>
                        <li> Procedimentos para abandono de área e controle de pânico</li>
                        <li> Aulas teóricas (08h)</li>
                        <li> Práticas (08h)</li>

                    </ol>
                </th>
        </table>

    </div>

    <div class="signatures">
        <table class="line-signatures-container center" style="padding-top: 10px;">
            <tr class="">
                <td class="">

                </td>

                <td class="">
                    @foreach($professionals as $itemProfessional)
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

    <div class="page-break"></div>

</div>

<div class="web-container">
    <div class="content03">
        <p> <span class="bold">OBJETIVO:</span> Proporcionar aos participantes, formação e conhecimentos técnicos na área de combate a incêndio e outras emergências tecnológicas,
            em áreas sinistradas, dispondo de todos os equipamentos e materiais necessários para um bom desempenho nas atividades de salvar vidas e preservar
            o bem patrimonial da empresa
        </p>
        <br>
    </div>

    <div class="content-programatic_03">
        <table style="font-size: 12px; line-height:1.5em; border-spacing: 15px; font-family: Arial; ">
            <tr>
                <th width="65%" style="text-align: left; vertical-align:top; padding-right: 30px; ">
                    <div class="content-programatic-title-02 center">
                        <p class="">CONTEÚDO PROGRAMÁTICO PARA TREINAMENTO DE BRIGADA DE INCÊNDIO </p>
                    </div>
                    <table style="border: 1px solid;  border-collapse: collapse;">
                        <tr>
                            <th width="50%" style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                MODULO
                            </th>

                            <th width="50%" style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                ASSUNTO
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                INTRODUÇÃO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Objetivos do curso e Brigada de incêndio
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                ASPECTOSLEGAIS.
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Responsabilidade do brigadista
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                TEORIA DO FOGO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Combustão, seus elementos e a reação em cadeia.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                PROPAGAÇÃO DO FOGO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Condução, irradiação e convecção.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                CLASSES DE INCÊNDIO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Classificação e características
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                PREVENÇÃO DE INCÊNDIOS
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Técnicas de prevenção.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                MÉTODOS DE EXTINÇÃO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Isolamento, abafamento, resfriamento e extinção química
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                INTRODUÇÃO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Objetivos do curso e Brigada de incêndio
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                AGENTES EXTINTORES
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Água, Pós, CO2, Espumas e outros.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                EPI (EQUIPAMENTOS DE PROTEÇÃO
                                INDIVIDUA
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                EPI.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                EQUIPAMENTOS DE COMBATE A INCÊNDIO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Extintores e acessórios
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                EQUIPAMENTOS DE COMBATEA INCÊNDIO
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Hidrantes, mangueiras e acessórios
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                EQUIPAMENTOS DE DETECÇÃO,
                                ALARME, LUZ DE EMERGÊNCIA E
                                COMUNICAÇÕES
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Tipos e funcionamento.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                ABANDONO DE ÁREA
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Conceitos.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                AVALIAÇÃO INICIAL
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Avaliação do cenário, mecanismo de lesão
                                e número de vítimas.

                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                VIAS AÉREAS
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Causas de obstrução e liberação
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                RCP (REANIMAÇÃO CARDIOPULMONAR)
                            </th>
                            <th  style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Ventilação artificial e compressão cardíaca externa.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding-right: 10px; border: 1px solid;  border-collapse: collapse;">
                                HEMORRAGIAS
                            </th>
                            <th style="text-align: center; vertical-align:top; border: 1px solid;  border-collapse: collapse; ">
                                Classificação e tratamento.
                            </th>
                        </tr>

                    </table>

                </th>
                <th width="35%" style="text-align: left; vertical-align:top;  ">
                    <table style="margin-top:20px; border: 1px solid;  border-collapse: collapse;">
                        <tr>
                            <th  style="text-align: center; font-style: italic; vertical-align:top; padding: 20px; border: 1px solid;  border-collapse: collapse;">
                                CERTIFICADO DE EDUCAÇÃO PROFISSIONAL DE NÍVEL
                                BÁSICO ESTA REGULAMENTADO PELO DECRETO 2.208, DE
                                17 DE ABRIL DE 1997, DO MINISTÉRIO DE EDUCAÇÃO E LEI
                                N° 6.514 DE 22 DE DEZEMBRO DE 1977, CAPITULO V DA
                                SEGURANÇA E MEDICINA DO TRABALHO.
                            </th>
                        </tr>
                        <tr>
                            <th  style="text-align: center; vertical-align:top; padding: 20px; border: 1px solid;  border-collapse: collapse;">
                                REGISTRO ESPECIFICAÇÃO
                                TREINAMENTO:FORMAÇÃO BRIGADA DE INCÊNDIOCFBI
                                CARGA HORÁRIA: 16 HORAS.NÍVELBÁSICO
                                REFERENCIANORMATIVA: PORTARIA Nº3.214/1978,NR
                                23
                                - PROTEÇÃO CONTRA INCÊNDIOS, NBR 14276 E IT 08
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center; vertical-align:top; font-size:14px; padding: 20px; border: 1px solid;  border-collapse: collapse;">
                                <span style="color:red;">
                                    Certificado de Licenciamento
                                Nº 390829
                                Validade: 09/05/2025
                                Nº do Protocolo: 677754
                                </span>
                            </th>
                        </tr>
                    </table>
                    <table class="">
                        <tr>
                            <th style="text-align: center; vertical-align:top; font-size:14px; color:red; padding: 20px;" >
                                @foreach($professionals as $itemProfessional)
                                    @if($itemProfessional['verse'] && $itemProfessional['professional']['signature_image'])
                                        <img  style="height: 120px; padding-bottom:25px; padding-left: 20px; padding-right: 30px;" src="{{ url('storage/'.$itemProfessional['professional']['signature_image'])}}" alt="assinatura">
                                    @endif
                                @endforeach


                            </th>
                        </tr>
                    </table>

        </table>

    </div>

    <div class="page-break"></div>
</div>


</body>
</html>
