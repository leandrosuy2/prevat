<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title fs-15">Visualização Conteúdo programático</h4>
                    {{--                    @can('add_professional')--}}
                    <div class="">
                        <button wire:click="refreshPDF({{$trainingParticipation['id']}})" class="fw-semibold btn btn-sm btn-green"> <i class="fa fa-arrows-rotate"></i> Atualizar PDF </button>

                        <button wire:click="downloadPDF({{$trainingParticipation['id']}})" class="fw-semibold btn btn-sm btn-primary"> <i class="fa fa-file-pdf"></i> Baixar PDF </button>

                        <a href="{{ route('movement.participant-training.programmatic-printer', $trainingParticipation['id']) }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                           title="Imprimir PDF">
                            <i class="fa fa-print"></i> Imprimir
                        </a>
                    </div>

                    {{--                    @endcan--}}
                </div>

                @if($trainingParticipation['template_id'] == 1)
                    <div class="card-body" style="z-index: 5">
                    <div class="web-container" id="print-area">
                        <div class="header-programatic center">
                            CONTEÚDO PROGRAMÁTICO DE TREINAMENTO
                        </div>

                        <div class="content-programatic-title center">
                            {{$trainingParticipation['schedule_prevat']['training']['name']}}
                        </div>

                        <div class="content-programatic">
                            <table style="font-size: 16px; line-height:1.5em; border-spacing: 30px; font-family: Arial;  ">
                                @if($trainingParticipation['schedule_prevat']['training']['content02'])
                                    <tr>
                                        <th width="50%" style="text-align: left; vertical-align:top; margin-right: 50px">
                                            {!! nl2br(e($trainingParticipation['schedule_prevat']['training']['content'])) !!}
                                        </th>
                                        <th width="50%" style="text-align: left; vertical-align:top;">
                                            {!! nl2br(e($trainingParticipation['schedule_prevat']['training']['content02'])) !!}
                                        </th>
                                        @else
                                            <th width="50%" style="text-align: left; vertical-align:top; margin-right: 50px">
                                                {!! nl2br(e($trainingParticipation['schedule_prevat']['training']['content'])) !!}
                                            </th>

                                        @endif
                                    </tr>
                            </table>
                        </div>

                        <div class="signatures-site">
                            <table class="line-signatures-container center" style="padding-top: 20px; " >
                                <tr class="">

                                    <td class="">

                                    </td>
                                    <td class="">
                                        @if($trainingParticipation['professionals'])
                                            @foreach($trainingParticipation['professionals'] as $itemProfessional)
                                                @if($itemProfessional['verse'] && $itemProfessional['professional']['signature_image'])
                                                    <img  style="height: 240px; padding-bottom:50px; padding-left: 30px; padding-right: 30px;" src="{{ url('storage/'.$itemProfessional['professional']['signature_image'])}}" alt="assinatura">
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="">

                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="footer-programatic-site">
                            <span class="">PREVAT - Treinamento</span>
                            <div class="">
                                Amparo Legal: Art. 1 do Decreto 5154/04, a Educação Profissional prevista no Art. 39 da Lei 9394/96 Lei de Diretrizes e Bases da Educação
                            </div>
                        </div>

                    </div>
                </div>
                @elseif($trainingParticipation['template_id'] == 2)
                    <div class="card-body" style="z-index: 5">
                        <div class="web-container" id="print-area">
                            <div class="header-programatic center">
                                CONTEÚDO PROGRAMÁTICO DE TREINAMENTO
                            </div>

                            <div class="content-programatic-title center">
                                {{$trainingParticipation['schedule_prevat']['training']['name']}}
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

                            <div class="signatures-site">
                                <table class="line-signatures-container center" style="padding-top: 20px; " >
                                    <tr class="">

                                        <td class="">

                                        </td>
                                        <td class="">
                                            @if($trainingParticipation['professionals'])
                                                @foreach($trainingParticipation['professionals'] as $itemProfessional)
                                                    @if($itemProfessional['verse'] && $itemProfessional['professional']['signature_image'])
                                                        <img  style="height: 240px; padding-bottom:50px; padding-left: 30px; padding-right: 30px;" src="{{ url('storage/'.$itemProfessional['professional']['signature_image'])}}" alt="assinatura">
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="">

                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="footer-programatic-site">
                                <span class="">PREVAT - Treinamento</span>
                                <div class="">
                                    Amparo Legal: Art. 1 do Decreto 5154/04, a Educação Profissional prevista no Art. 39 da Lei 9394/96 Lei de Diretrizes e Bases da Educação
                                </div>
                            </div>

                        </div>
                    </div>
                @elseif($trainingParticipation['template_id'] == 3)
                    <div class="card-body" style="z-index: 5">
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
                                                @foreach($trainingParticipation['participants'] as $itemParticipant)
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
                                            @foreach($trainingParticipation['professionals'] as $itemProfessional)
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
                    </div>
                    <div class="card-body" style="z-index: 5">
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
                                                        @foreach($trainingParticipation['professionals'] as $itemProfessional)
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
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet">

<script>
    $(document).ready(function(){
        $("#btnPrint").on("click",function(){
            printJS({
                printable: 'print-area',
                type: 'html'});
        })
    })
</script>
@endsection
