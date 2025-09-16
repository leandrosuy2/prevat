<html>
<head>
    <style>
        /*@page { margin: 50px 80px; }*/
        @page { margin-top: 50px; margin-bottom: 100px; }
        #header { position: fixed; left: 0px; top: -140px; right: 0px; height: 0px; background-color: transparent; text-align: center; }
        #footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 40px; background-color: transparent; }
        #footer .page:after { content: counter(page, upper-roman); }

        .tg  {border-collapse:collapse;border-spacing:0; width: 100%}
        .tg td{border-color:black;border-style:solid;border-width:0px;font-family:Arial, sans-serif;font-size:14px;
            overflow:hidden;padding:3px 5px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
            font-weight:normal;overflow:hidden;padding:2px 2px;word-break:normal;}
        .tg .tg-lboi{border-color:inherit;text-align:left;vertical-align:middle}
        .tg .tg-9wq8{border-color:inherit;font-size:7px;text-align:center;vertical-align:middle;width: 12px;white-space: nowrap;}
        .tg .tg-c3ow{border-color:inherit;text-align:left;vertical-align:middle; width:50%; height: 2px}
        .tg .tg-u6id{border-color:inherit;font-size:10px;font-weight:bold;text-align:center;vertical-align:middle}
        .tg .tg-u6if{border-color:inherit;font-size:10px;font-weight:bold;text-align:center;vertical-align:middle;width: 180px}
        .tg .tg-g7sd{border-color:inherit;font-weight:bold;text-align:center;vertical-align:middle; height: 30px}
        .tg .tg-0pky{border-color:inherit;font-size:10px;text-align:center;vertical-align:top; width:8px}
        .tg .tg-0pkb{border-color:inherit;text-align:left;vertical-align:middle; font-size: 10px; height: 60px}
        .tg .tg-0pkk{border-color:inherit;font-size:10px;text-align:left;vertical-align:middle; width:50%; height: 1px}
        .tg .tg-0pkz{border-color:inherit;font-size:12px;text-align:left;vertical-align:top; width: 50%}
        .tg .tg-fymr{border-color:inherit;font-weight:bold;text-align:center;vertical-align:top}
        .tg .tg-9o1m{border-color:inherit;font-size:7px;text-align:left;vertical-align:middle;white-space: nowrap;}
        .tg .tg-uzvj{border-color:inherit;font-weight:bold;text-align:center;vertical-align:middle}
        .tg-uzvg{border-color:white;font-size:12px;font-weight:bold;text-align:center;vertical-align:bottom}

        .table:nth-child(odd) {
            background-color:#ffffff;
        }
        .table:nth-child(even) {
            background-color: #efefef;
        }
    </style>
<body>
{{--<div id="header">--}}
{{--    teste--}}

{{--</div>--}}
<div id="footer">
    <table style="border-width:0px; width: 100%">
        <tr>
            <td class="tg-uzvg" style="text-align:center;vertical-align:bottom; ">
                ___________________________________<br><br>
                1° Instrutor<br><br><br>
            </td>
            <td class="tg-uzvg" width="10%"></td>
            <td class="tg-uzvg" style="text-align:center;vertical-align:bottom;">
                ___________________________________<br><br>
                2° Instrutor<br><br><br>
            </td>
            <td class="tg-uzvg" width="10%"></td>
            <td class="tg-uzvg" style="text-align:center;vertical-align:bottom;">
                ___________________________________<br><br>
                3° Instrutor<br><br><br>
            </td>
        </tr>
    </table>
</div>

<div id="content">
    <table class="tg">
        <thead>
        <tr>
            <th class="tg-g7sd" rowspan="2" colspan="2"><img  style="height: 40px" src="{{ url('pdf/images/prevat_logo_pdf.png')}}" alt="logo"></th>
            <th class="tg-0pkb" colspan="10">TREINAMENTO : {{$training['training']['description']}}</th>
        </tr>
        <tr>
            <th class="tg-0pkk" colspan="3">PERÍODO : {{ formatDate($training['start_event']) }} - {{ formatDate($training['end_event']) ?? ' ' }}</th>
            <th class="tg-0pkk" colspan="7">CARGA HORARIA : {{$training['workload']['name']}}</th>
        </tr>
        <tr>
            @if($training['training']['content02'] != null)
                <th class="tg-0pkz" colspan="4">{!! nl2br(e($training['training']['content'])) !!}<br></th>
                <th class="tg-0pkz" colspan="6">{!! nl2br(e($training['training']['content02'])) !!}<br></th>
            @else
                <th class="tg-0pkz" colspan="12">{!! nl2br(e($training['training']['content'])) !!}<br></th>
            @endif
        </tr>

        <tr style="border-width: 1px">
            <th class="tg-fymr"  style="border-width: 1px" colspan="1" width="8px">N</th>
            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">EMPRESA</th>
            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">NOME</th>
            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">CONTRATO</th>
            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">FUNÇÃO</th>
            <th class="tg-u6id" style="border-width: 1px"  colspan="1">CPF</th>
            <th class="tg-u6if" style="border-width: 1px"  colspan="1">ASSINATURA</th>
            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>
            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>
            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>
            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>
            <th class="tg-u6id" style="border-width: 1px"  colspan="1" width="30px">NOTA</th>
        </tr>
        </thead>

        @foreach($participants as $key => $itemParticipant)
            <tr class="table " style="border-width: 1px">
                <td class="tg-0pky" style="border-width: 1px"> {{ $key +1 }}</td>
                <td class="tg-9o1m" style="border-width: 1px">{{$itemParticipant['participant']['company']['name'] ?? $itemParticipant['participant']['company']['fantasy_name']}}</td>
                <td class="tg-9o1m" style="border-width: 1px">{{$itemParticipant['participant']['name']}}</td>
                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['contract']}}</td>
                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['role']['name']}}</td>
                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['taxpayer_registration']}}</td>
                <td class="tg-9wq8" style="border-width: 1px"></td>
                <td class="tg-9wq8" style="border-width: 1px">F</td>
                <td class="tg-uzvj" style="border-width: 1px"></td>
                <td class="tg-uzvj" style="border-width: 1px"></td>
                <td class="tg-uzvj" style="border-width: 1px"></td>
                <td class="tg-uzvj" style="border-width: 1px"></td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>

{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">--}}
{{--    <title>Lista dos participantes</title>--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}

{{--    <link href="{{ url('pdf/web/modern-normalize.css')}}" rel="stylesheet" />--}}
{{--    <link href="{{ url('pdf/web/web-base.css')}}" rel="stylesheet" />--}}
{{--    <link href="{{ url('pdf/invoice.css')}}" rel="stylesheet" />--}}

{{--    <style>--}}
{{--        @font-face {--}}
{{--            font-family: Arial;--}}
{{--            font-style: normal;--}}
{{--        }--}}


{{--        header { position: fixed; top: -10px; left: 0px; right: 0px; background-color: lightblue; }--}}
{{--        #footer { position: fixed; left: 0px; bottom: -130px; right: 0px; height: 50px; background-color: lightblue; }--}}
{{--        #footer .page:after { content: counter(page, upper-roman); }--}}


{{--        .tg  {border-collapse:collapse;border-spacing:0; width: 100%}--}}
{{--        .tg td{border-color:black;border-style:solid;border-width:0px;font-family:Arial, sans-serif;font-size:14px;--}}
{{--            overflow:hidden;padding:3px 5px;word-break:normal;}--}}
{{--        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;--}}
{{--            font-weight:normal;overflow:hidden;padding:2px 2px;word-break:normal;}--}}
{{--        .tg .tg-lboi{border-color:inherit;text-align:left;vertical-align:middle}--}}
{{--        .tg .tg-9wq8{border-color:inherit;font-size:7px;text-align:center;vertical-align:middle;width: 12px;white-space: nowrap;}--}}
{{--        .tg .tg-c3ow{border-color:inherit;text-align:left;vertical-align:middle; width:50%; height: 2px}--}}
{{--        .tg .tg-u6id{border-color:inherit;font-size:10px;font-weight:bold;text-align:center;vertical-align:middle}--}}
{{--        .tg .tg-u6if{border-color:inherit;font-size:10px;font-weight:bold;text-align:center;vertical-align:middle;width: 180px}--}}
{{--        .tg .tg-g7sd{border-color:inherit;font-weight:bold;text-align:center;vertical-align:middle; height: 30px}--}}
{{--        .tg .tg-0pky{border-color:inherit;font-size:10px;text-align:center;vertical-align:top; width:8px}--}}
{{--        .tg .tg-0pkb{border-color:inherit;text-align:left;vertical-align:middle; font-size: 10px; height: 60px}--}}
{{--        .tg .tg-0pkk{border-color:inherit;font-size:10px;text-align:left;vertical-align:middle; width:50%; height: 1px}--}}
{{--        .tg .tg-0pkz{border-color:inherit;font-size:12px;text-align:left;vertical-align:top; width: 50%}--}}
{{--        .tg .tg-fymr{border-color:inherit;font-weight:bold;text-align:center;vertical-align:top}--}}
{{--        .tg .tg-9o1m{border-color:inherit;font-size:7px;text-align:left;vertical-align:middle;white-space: nowrap;}--}}
{{--        .tg .tg-uzvj{border-color:inherit;font-weight:bold;text-align:center;vertical-align:middle}--}}
{{--        .tg-uzvg{border-color:white;font-size:12px;font-weight:bold;text-align:center;vertical-align:bottom}--}}

{{--        .table:nth-child(odd) {--}}
{{--            background-color:#ffffff;--}}
{{--        }--}}
{{--        .table:nth-child(even) {--}}
{{--            background-color: #efefef;--}}
{{--        }--}}

{{--        .page-break {--}}
{{--            page-break-after: always;--}}
{{--        }--}}

{{--        .table:nth-child(4n) {--}}
{{--            page-break-after: always;--}}
{{--        }--}}

{{--        @media print { tfoot { display: table-footer-group;--}}
{{--            position: absolute;--}}
{{--            bottom: 0; }}--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div id="footer">--}}
{{--    <table style="border-width:0px; height: 140px; width: 100%">--}}
{{--        <tr>--}}
{{--            <td class="tg-uzvg" style="text-align:center;vertical-align:bottom; ">--}}
{{--                ___________________________________<br><br>--}}
{{--                1° Instrutor<br><br><br>--}}
{{--            </td>--}}
{{--            <td class="tg-uzvg" width="10%"></td>--}}
{{--            <td class="tg-uzvg" style="text-align:center;vertical-align:bottom;">--}}
{{--                ___________________________________<br><br>--}}
{{--                2° Instrutor<br><br><br>--}}
{{--            </td>--}}
{{--            <td class="tg-uzvg" width="10%"></td>--}}
{{--            <td class="tg-uzvg" style="text-align:center;vertical-align:bottom;">--}}
{{--                ___________________________________<br><br>--}}
{{--                3° Instrutor<br><br><br>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--</div>--}}
{{--    <table class="tg">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th class="tg-g7sd" rowspan="2" colspan="2"><img  style="height: 40px" src="{{ url('pdf/images/prevat_logo_pdf.png')}}" alt="logo"></th>--}}
{{--            <th class="tg-0pkb" colspan="10">TREINAMENTO : {{$training['training']['description']}}</th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th class="tg-0pkk" colspan="3">PERÍODO : {{ formatDate($training['start_event']) }} - {{ formatDate($training['end_event']) ?? ' ' }}</th>--}}
{{--            <th class="tg-0pkk" colspan="7">CARGA HORARIA : {{$training['workload']['name']}}</th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            @if($training['training']['content02'] != null)--}}
{{--                <th class="tg-0pkz" colspan="4">{!! nl2br(e($training['training']['content'])) !!}<br></th>--}}
{{--                <th class="tg-0pkz" colspan="6">{!! nl2br(e($training['training']['content02'])) !!}<br></th>--}}
{{--            @else--}}
{{--                <th class="tg-0pkz" colspan="12">{!! nl2br(e($training['training']['content'])) !!}<br></th>--}}
{{--            @endif--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <th class="tg-fymr"  style="border-width: 1px" colspan="1" width="8px">N</th>--}}
{{--            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">EMPRESA</th>--}}
{{--            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">NOME</th>--}}
{{--            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">CONTRATO</th>--}}
{{--            <th class="tg-u6id"  style="border-width: 1px"  colspan="1">FUNÇÃO</th>--}}
{{--            <th class="tg-u6id" style="border-width: 1px"  colspan="1">CPF</th>--}}
{{--            <th class="tg-u6if" style="border-width: 1px"  colspan="1">ASSINATURA</th>--}}
{{--            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>--}}
{{--            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>--}}
{{--            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>--}}
{{--            <th class="tg-9wq8" style="border-width: 1px"  colspan="1"></th>--}}
{{--            <th class="tg-u6id" style="border-width: 1px"  colspan="1" width="30px">NOTA</th>--}}
{{--        </tr>--}}
{{--    </thead>--}}


{{--        @php--}}
{{--            $rowIndex = 0;--}}
{{--//            $priceunit = $tr_style = '';--}}
{{--        @endphp--}}

{{--        @foreach($participants as $key => $itemParticipant)--}}
{{--            <tr class="table " style="border-width: 1px">--}}
{{--                <td class="tg-0pky" style="border-width: 1px"> {{ $key +1 }}</td>--}}
{{--                <td class="tg-9o1m" style="border-width: 1px">{{$itemParticipant['participant']['company']['name'] ?? $itemParticipant['participant']['company']['fantasy_name']}}</td>--}}
{{--                <td class="tg-9o1m" style="border-width: 1px">{{$itemParticipant['participant']['name']}}</td>--}}
{{--                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['contract']}}</td>--}}
{{--                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['role']['name']}}</td>--}}
{{--                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['taxpayer_registration']}}</td>--}}
{{--                <td class="tg-9wq8" style="border-width: 1px"></td>--}}
{{--                <td class="tg-9wq8" style="border-width: 1px">F</td>--}}
{{--                <td class="tg-uzvj" style="border-width: 1px"></td>--}}
{{--                <td class="tg-uzvj" style="border-width: 1px"></td>--}}
{{--                <td class="tg-uzvj" style="border-width: 1px"></td>--}}
{{--                <td class="tg-uzvj" style="border-width: 1px"></td>--}}
{{--                       </tr>--}}

{{--        @if($loop->index === 5 )--}}

{{--            @endif--}}
{{--            @php--}}
{{--                $rowIndex++;--}}
{{--                if ($rowIndex % 5 === 0) {--}}
{{--                    echo '--}}
{{--                    </main>--}}
{{--                    <div class="page-break"></div>--}}
{{--                    <main>';--}}
{{--                }--}}
{{--            @endphp--}}
{{--                        @if($key == 9)--}}

{{--                            @include('pdf.lista_signature')--}}
{{--            <div class="page-break"></div>--}}
{{--                        @endif--}}

{{--                        @if($key == 19)--}}
{{--                            @include('pdf.lista_signature')--}}
{{--                        @endif--}}
{{--                        <div class="page-break"></div>--}}
{{--                        @if($key == 29)--}}
{{--                            @include('pdf.lista_signature')--}}
{{--                        @endif--}}
{{--                        @if($key == 39)--}}
{{--                            @include('pdf.lista_signature')--}}
{{--                        @endif--}}
{{--                        @if($key == 49)--}}
{{--                            @include('pdf.lista_signature')--}}
{{--                        @endif--}}
{{--                        @if($key == 59)--}}
{{--                            @include('pdf.lista_signature')--}}
{{--                        @endif--}}
{{--                        @if($key == 69)--}}
{{--                            @include('pdf.lista_signature')--}}
{{--                        @endif--}}
{{--        @endforeach--}}


{{--    </table>--}}

{{--<div class="web-container">--}}

{{--<footer>footer on each page</footer>--}}


{{--</div>--}}
{{--<div class="footer-list">--}}
{{--    <span class="">PREVAT - Treinamento</span>--}}
{{--    <div class="">--}}
{{--        Amparo Legal: Art. 1 do Decreto 5154/04, a Educação Profissional prevista no Art. 39 da Lei 9394/96 Lei de Diretrizes e Bases da Educação--}}
{{--    </div>--}}
{{--</div>--}}

{{--</body>--}}
{{--</html>--}}
