<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title fs-14">Listagem dos certificados</h3>

                    <div class="">
                        <button wire:click="refreshPDF({{$trainingParticipation['id']}})" wire:loading.class="btn-loading" class="fw-semibold btn btn-sm btn-green">
                            <i wire:target="refreshPDF()" wire:loading.remove class="fa fa-arrows-rotate"></i> Atualizar PDF </button>

                        <button wire:click="downloadPDF({{$trainingParticipation['id']}})" wire:loading.class="btn-loading" class="fw-semibold btn btn-sm btn-primary">
                            <i wire:target="downloadPDF()" wire:loading.remove class="fa fa-file-pdf"></i> Baixar PDF
                        </button>

                        <button wire:click="generateQRCode({{$trainingParticipation['id']}})"  wire:loading.class="btn-loading " class="fw-semibold btn btn-sm btn-red">
                            <i wire:target="downloadOS()" wire:loading.remove class="fa-solid fa-qrcode"></i>  Ref. QrCode
                        </button>

                        <a href="{{ route('movement.participant-training.printer', $trainingParticipation['id']) }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                           title="Imprimir PDF">
                            <i class="fa fa-print"></i> Imprimir
                        </a>
                    </div>
                    {{--                    @endcan--}}
                </div>



                @foreach($response->certificates as $itemCertificate)

                    @if($trainingParticipation['template_id'] == 1)
                        <div class="card-body" style="z-index: 5">
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
                                            Registro : {{formatNumber($itemCertificate['registry'])}} / {{$itemCertificate['year']}}
                                        </div>

                                        @if($itemCertificate['path_qrcode'] != null)
                                            <img src="{{ url($itemCertificate['path_qrcode']) }}" alt="qrcode">
                                        @else
                                            <img src="{{ url('pdf/images/qr_code_prevat.png') }}" alt="qrcode">
                                        @endif

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

                            <span class="center"> {{$itemCertificate['participant']['name']}} - CPF: {{$itemCertificate['participant']['taxpayer_registration']}}</span>
                        </div>

                        <div class="content" >
                            {{$itemCertificate['training']['description']}}

                            <br><br>

{{--                            @dd($itemCertificate['training_participation']['schedule_prevat']['training'])--}}
                            <span>Carga Horária do Treinamento: {{$itemCertificate['training_participation']['schedule_prevat']['workload']['name']}} </span><br>

                            @if($itemCertificate['training_participation']['schedule_prevat']['time02_id'] != null)
                            <span> Data do Treinamento: {{ formatDate($itemCertificate['training_participation']['schedule_prevat']['start_event']) }} a {{formatDate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}}</span><br>
                            @else
                                <span> Data do Treinamento: {{ formatDate($itemCertificate['training_participation']['schedule_prevat']['start_event']) }}</span><br>
                            @endif
                            <span> Local do Treinamento: {{$itemCertificate['training_participation']['schedule_prevat']['location']['name']}} -
                {{$itemCertificate['training_participation']['schedule_prevat']['location']['address']}} - {{$itemCertificate['training_participation']['schedule_prevat']['location']['number']}} -
                {{$itemCertificate['training_participation']['schedule_prevat']['location']['complement']}}  - {{$itemCertificate['training_participation']['schedule_prevat']['location']['neighborhood']}} -
                {{$itemCertificate['training_participation']['schedule_prevat']['location']['city']}} - {{$itemCertificate['training_participation']['schedule_prevat']['location']['uf']}} </span>

                        </div>
                        <div class="date">
                            <br>
                            <p class="right">Barcarena-PA, {{ formatCertificate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}}</p>
                        </div>

                        <div class="signatures">
                            <table class="line-signatures-container center">
                                <tr class="">
                                    <td width="33%">
                                        @foreach($trainingParticipation['professionals'] as $itemProfessional)
                                            @if($itemProfessional['professional']['signature_image'] && $itemProfessional['front'])
                                                <img style="height: 240px" src="{{ url('images/signatures/' . $itemProfessional['professional']['signature_image']) }}" alt="assinatura_tecnico">
                                            @endif
                                        @endforeach
                                    </td>
                                    <td width="33%">
                                        <img style="height:240px;" src="{{ url('images/signatures/assinatura_diretor.png') }}" alt="assinatura_tecnico">
                                     </td>
                                    <td width="33%">
                                        <img style="height: 240px; " src="{{ url('images/signatures/assinatura_participante.png') }}" alt="assinatura_participante">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                        </div>
                    @elseif($trainingParticipation['template_id'] == 2)
                        <div class="card-body" style="z-index: 5">
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
                                                <span class="center text-lg-center" style="white-space: nowrap;"> {{$itemCertificate['note']}}</span>
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
                                    {{$itemCertificate['participant']['name']}} - CPF : {{$itemCertificate['participant']['taxpayer_registration']}}
                                </div>

                            </div>

                            <div class="content">
                                {!! $itemCertificate['training']['description'] !!}

                                <br><br>
                                <span>Carga Horária do Treinamento: {{$itemCertificate['training_participation']['schedule_prevat']['workload']['name']}} </span><br>

                                @if($itemCertificate['training_participation']['schedule_prevat']['time02_id'] != null)
                                    <span> Data do Treinamento: {{ formatDate($itemCertificate['training_participation']['schedule_prevat']['start_event']) }} a {{formatDate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}}</span><br>
                                @else
                                    <span> Data do Treinamento: {{ formatDate($itemCertificate['training_participation']['schedule_prevat']['start_event']) }}</span><br>
                                @endif

                                {{--            <span> Data do Treinamento: {{ formatDate($itemCertificate['training_participation']['schedule_prevat']['date_event']) }} </span><br>--}}
                                <span> Local do Treinamento: {{$itemCertificate['training_participation']['schedule_prevat']['location']['name']}} -
                                {{$itemCertificate['training_participation']['schedule_prevat']['location']['address']}} - {{$itemCertificate['training_participation']['schedule_prevat']['location']['number']}} -
                                {{$itemCertificate['training_participation']['schedule_prevat']['location']['complement']}}  - {{$itemCertificate['training_participation']['schedule_prevat']['location']['neighborhood']}} -
                                        {{$itemCertificate['training_participation']['schedule_prevat']['location']['city']}} - {{$itemCertificate['training_participation']['schedule_prevat']['location']['uf']}} </span>
                            </div>
                            <div class="date" style="padding-top: 100px;">
                                <p class="right">Barcarena-PA, {{ formatCertificate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}}</p>
                            </div>

                            <div class="signatures">
                                <table class="line-signatures-container center" >
                                    <tr class="">
                                        <td width="33%">
                                            <img style="height:240px;" src="{{ url('images/signatures/assinatura_diretor.png') }}" alt="assinatura_tecnico">
                                        </td>
                                        <td width="33%" style="margin-right: 50px;">
                                            <img style="height: 240px; " src="{{ url('images/signatures/assinatura_participante.png') }}" alt="assinatura_participante">
                                        </td>
                                        <td width="5%" style="margin-right: 30px;">
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div  style="height: 120px;">
                                <table class="line-signatures-container center">

                                </table>
                            </div>
                        </div>
                        </div>
                    @elseif($trainingParticipation['template_id'] == 3)
                        <div class="card-body" style="z-index: 5">
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

                                <p class="">Atestamos que a <span class="bold"> {{$itemCertificate['company']['name']}}  - CNPJ –
                {{$itemCertificate['company']['employer_number']}} </span> Promoveu o CURSO DE {{$itemCertificate['training']['name']}}, aos seus
                                    colaboradores, para o quantitativo de {{$itemCertificate['training_participation']['participants']->count()}} brigadistas formados, com carga horária de {{$itemCertificate['training_participation']['schedule_prevat']['workload']['name']}}/aula, com aproveitamento de 100% nos dias
                                    {{ formatDate($itemCertificate['training_participation']['schedule_prevat']['start_event']) }} a {{formatDate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}},
                                    realizado nas dependências da própria empresa.
                                </p>

                            </div>
                            <div class="date" style="padding-top: 80px;">
                                <p class="right">Barcarena-PA, {{ formatCertificate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}}</p>
                            </div>

                            <div class="signatures">
                                <table class="line-signatures-container center">
                                    <tr class="">
                                        <td width="33%">
                                            @foreach($trainingParticipation['professionals'] as $itemProfessional)
                                                @if($itemProfessional['professional']['signature_image'] && $itemProfessional['front'])
                                                    <img style="height: 240px" src="{{ url('images/signatures/' . $itemProfessional['professional']['signature_image']) }}" alt="assinatura_tecnico">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td width="33%">
                                            <img style="height:240px;" src="{{ url('images/signatures/assinatura_diretor.png') }}" alt="assinatura_tecnico">
                                        </td>
                                        <td width="33%">
                                            <img style="height: 240px; " src="{{ url('images/signatures/assinatura_participante.png') }}" alt="assinatura_participante">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        </div>
                        <div class="card-body" style="z-index: 5">
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
                                <p>Conferimos o presente certificado à <span class="bold">{{$itemCertificate['participant']['name']}}</span>, inscrito no C.P.F. sob o n° {{$itemCertificate['participant']['taxpayer_registration']}} por sua
                                    participação no CURSO DE <span class="bold">{{$itemCertificate['training']['name']}}</span>, com carga horária total de {{$itemCertificate['training_participation']['schedule_prevat']['workload']['name']}}/aula realizado no
                                    período de {{ formatDate($itemCertificate['training_participation']['schedule_prevat']['start_event']) }} à  {{formatDate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}}, realizado nas dependências da própria empresa, tudo em conformidade com a
                                    InstruçãoTécnica 08/2019 da DST do CBMPA.
                                </p>
                                <br>
                            </div>

                            <div class="date" style="padding-top: 80px;">
                                <p class="right">Barcarena-PA, {{ formatCertificate($itemCertificate['training_participation']['schedule_prevat']['end_event'])}}</p>
                            </div>

                            <div class="signatures">
                                <table class="line-signatures-container center">
                                    <tr class="">
                                        <td width="33%">
                                            @foreach($trainingParticipation['professionals'] as $itemProfessional)
                                                @if($itemProfessional['professional']['signature_image'] && $itemProfessional['front'])
                                                    <img style="height: 240px" src="{{ url('images/signatures/' . $itemProfessional['professional']['signature_image']) }}" alt="assinatura_tecnico">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td width="33%">
                                            <img style="height:240px;" src="{{ url('images/signatures/assinatura_diretor.png') }}" alt="assinatura_tecnico">
                                        </td>
                                        <td width="33%">
                                            <img style="height: 240px; " src="{{ url('images/signatures/assinatura_participante.png') }}" alt="assinatura_participante">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        </div>
                    @endif

                @endforeach
            </div>
        </div>
    </div>
</div>
