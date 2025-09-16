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
                    @foreach($professionals as $itemProfessional)
                        @if($itemProfessional['verse'] && $itemProfessional['professional']['signature_image'])
                            <img  style="height: 100px; padding-bottom:20px; padding-left: 20px; padding-right: 30px;" src="{{ url('storage/'.$itemProfessional['professional']['signature_image'])}}" alt="assinatura">
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


</body>
</html>
