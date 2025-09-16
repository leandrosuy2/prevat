<html>
<head>
    <style>
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
        .tg .tg-0pk5{border-color:inherit;text-align:center;vertical-align:center; padding-left:15px; padding-top: 20px; font-size: 10px;}
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
                <th class="tg-0pkb" colspan="8">TREINAMENTO : {{$training['schedule']['training']['description']}}</th>
                <th class="tg-0pk5" colspan="2" >
                    @if($training['schedule']['contractor_id'] == 1052)
                        <div style="background-color: green; width: 20px; height: 20px;"></div>
                        @elseif($training['schedule']['contractor_id'] == 1053)
                            <div style="background-color: yellow; width: 20px; height: 20px;"></div>
                        @elseif($training['schedule']['contractor_id'] == 1054)
                            <div style="background-color: blue; width: 20px; height: 20px;"></div>
                        @elseif($training['schedule']['contractor_id'] == 1055)
                            <div style="background-color: red; width: 20px; height: 20px;"></div>
                        @else
                            <div style="background-color: black; width: 20px; height: 20px;"></div>
                    @endif

                </th>
            </tr>
            <tr>
                <th class="tg-0pkk" colspan="3">PERÍODO : {{ formatDate($training['schedule']['start_event']) }} - {{ formatDate($training['schedule']['end_event']) ?? ' ' }}</th>
                <th class="tg-0pkk" colspan="7">CARGA HORARIA : {{$training['schedule']['workload']['name']}}</th>
            </tr>
            <tr>
                @if($training['schedule']['training']['content02'] != null)
                    <th class="tg-0pkz" colspan="4">{!! nl2br(e($training['schedule']['training']['content'])) !!}<br></th>
                    <th class="tg-0pkz" colspan="8">{!! nl2br(e($training['schedule']['training']['content02'])) !!}<br></th>
                @else
                    <th class="tg-0pkz" colspan="12">{!! nl2br(e($training['schedule']['training']['content'])) !!}<br></th>
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
        @php
            $number = 1;
        @endphp

            @foreach($participants as $key => $itemParticipant)

            <tr class="table" style="border-width: 1px; text-transform: uppercase;">
                <td class="tg-0pky" style="border-width: 1px"> {{ $number ++ }}</td>
                <td class="tg-9o1m" style="border-width: 1px">{{ mb_strimwidth($itemParticipant['participant']['company']['name'], 0, 25, "...") ?? $itemParticipant['participant']['company']['fantasy_name']}}</td>
                <td class="tg-9o1m" style="border-width: 1px">{{$itemParticipant['participant']['name']}}</td>
                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['contract']['contract'] ?? ''}}</td>
                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['role']['name']}}</td>
                <td class="tg-9wq8" style="border-width: 1px">{{$itemParticipant['participant']['taxpayer_registration']}}</td>
                <td class="tg-9wq8" style="border-width: 1px"></td>
                <td class="tg-9wq8" style="border-width: 1px"></td>
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
