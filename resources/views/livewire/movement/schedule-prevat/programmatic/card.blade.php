<div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title fs-15">Visualização Conteúdo programático</h4>
                    {{--                    @can('add_professional')--}}
                    <div class="">
                        <button wire:click="downloadPDF({{$schedulePrevat['id']}})" class="fw-semibold btn btn-sm btn-primary"> <i class="fa fa-file-pdf"></i> Baixar PDF </button>
                        <button wire:click="printPDF({{$schedulePrevat['id']}})" class="fw-semibold btn btn-sm btn-warning"><i class="fa fa-print"></i> Imprimir </button>
                    </div>

                    {{--                    @endcan--}}
                </div>

                <div class="card-body" style="z-index: 5">
                    <div class="web-container" id="print-area">
                        <div class="header-programatic center">
                            CONTEÚDO PROGRAMÁTICO DE TREINAMENTO
                        </div>

                        <div class="content-programatic-title center">
                            {{$schedulePrevat['training']['name']}}
                        </div>

                        <div class="content-programatic">
                            <table style="font-size: 16px; line-height:1.5em; border-spacing: 30px; font-family: Arial;  ">
                                @if($schedulePrevat['training']['content02'])
                                    <tr>
                                        <th width="50%" style="text-align: left; vertical-align:top; margin-right: 50px">
                                            {!! nl2br(e($schedulePrevat['training']['content'])) !!}
                                        </th>
                                        <th width="50%" style="text-align: left; vertical-align:top;">
                                            {!! nl2br(e($schedulePrevat['training']['content02'])) !!}
                                        </th>
                                        @else
                                            <th width="50%" style="text-align: left; vertical-align:top; margin-right: 50px">
                                                {!! nl2br(e($schedulePrevat['training']['content'])) !!}
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
                                        @if($schedulePrevat['training']['technical'] && $schedulePrevat['training']['technical']['signature_image'] != null)
                                            <img  style="height: 240px; padding-bottom:50px;" src="{{ url('storage/'.$schedulePrevat['training']['technical']['signature_image'])}}" alt="assinatura">
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
