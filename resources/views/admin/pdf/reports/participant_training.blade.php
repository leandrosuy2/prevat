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
                Relatorio treinamento do participante
            </th>
        </tr>
    </table>

    <table class="line-items-container">
        <thead>
        <tr>
            <th class="text-left">Participante</th>
            <th class="heading-description">Documento</th>
            <th class="text-left">Treinamento</th>
            <th>Data</th>
            <th class="text-left">Empresa</th>
            <th class="text-center">CTO</th>
            <th class="text-center">Presença</th>
            <th class="text-center">Nota</th>
        </tr>
        </thead>
        <tbody>
        @foreach($participantTraining as $itemParticipant)
            <tr class="table" >
                <td> {{ $itemParticipant['participant']['name'] }}</td>
                <td class="text-center"> {{ $itemParticipant['participant']['taxpayer_registration'] }}</td>
                <td> {{ $itemParticipant['training_participation']['schedule_prevat']['training']['name'] }}</td>
                <td class="text-center"> {{ formatDate($itemParticipant['training_participation']['schedule_prevat']['date_event']) }}</td>
                <td> {{mb_strimwidth($itemParticipant['participant']['company']['name'], 0, 20, "...")}}</td>
                <td> {{ $itemParticipant['participant']['contract']['contract'] }}</td>
                <td class="text-center"> {{ $itemParticipant['presence'] ? 'Sim' : 'Não' }}</td>
                <td class="text-left"> {{ $itemParticipant['note'] ?? 'S/N' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
