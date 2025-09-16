<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Relatorios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ url('pdf/reports/web/modern-normalize.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/reports/web/web-base.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/reports/reports.css')}}" rel="stylesheet" />

    <script src="{{ url('pdf/web/scripts.js')}}"></script>

</head>
<style>
    .table:nth-child(odd) {
        background-color:#ffffff;
    }
    .table:nth-child(even) {
        background-color: #efefef;
    }
</style>
<body>

<div class="web-container">
    <table class="line-items-container">
        <thead>
        <tr>
            <th width="30px">
                <div class="logo-container">
                    <img  style="height: 20px" src="{{asset('build/assets/images/brand/prevat_logo.png')}}" class="w-18 h-18" alt="logo">
                </div>
            </th>
            <th class="text-left">
                Relatorio financeiro participantes
            </th>
        </tr>
    </table>

    <table class="line-items-container">
        <thead>
        <tr>
            <th class="text-left">DATAS</th>
            <th class="text-left">SERVICO</th>
            <th class="text-center">QUANTIDADE</th>
            <th class="text-center">VALOR</th>
            <th class="text-center">VALOR TOTAL</th>
            <th class="text-center">PARTICIPANTE</th>
        </tr>
        </thead>
        <tbody>
        @foreach($companies as $itemCompany)
{{--            @dd($itemCompany)--}}
            <tr class="table" >
                <td> {{ formatDate($itemCompany['schedule_company']['schedule']['date_event']) }}</td>
                <td> {{ $itemCompany['schedule_company']['schedule']['training']['name'] }}</td>
                <td class="text-center"> {{ $itemCompany['quantity'] }}</td>
                <td class="text-center"> {{ formatMoney($itemCompany['value']) }}</td>
                <td class="text-center"> {{ formatMoney($itemCompany['total_value']) }}</td>

                <td class="text-center"> {{ $itemCompany['participant']['name'] }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
