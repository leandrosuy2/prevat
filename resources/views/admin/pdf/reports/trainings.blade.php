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
                Relatorio treinamentos
            </th>
        </tr>
    </table>

    <table class="line-items-container">
        <thead>
        <tr>
            <th class="text-left">EMPRESA</th>
            <th class="text-left">TREINAMENTO</th>
            <th class="text-center">DATA</th>
            <th class="text-center">PARTICIPANTES</th>
            <th class="text-center">STATUS</th>
        </tr>
        </thead>
        <tbody>
        @foreach($trainings as $itemTraining)
            <tr class="table" >
                <td> {{ $itemTraining['company']['name'] }}</td>
                <td> {{ $itemTraining['schedule']['training']['name'] }}</td>
                <td class="text-center"> {{ formatDate($itemTraining['schedule']['date_event']) }}</td>
                <td class="text-center"> {{ $itemTraining['participants']->count() }}</td>
                <td> {{ $itemTraining['schedule']['status']  }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
