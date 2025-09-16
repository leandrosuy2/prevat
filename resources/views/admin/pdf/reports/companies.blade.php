<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Relatórios</title>
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
                Relatorio empresas cadastradas
            </th>
        </tr>
    </table>

    <table class="line-items-container">
        <thead>
        <tr>
            <th class="text-left">RAZÃO SOCIAL </th>
            <th class="heading-description">TELEFONE</th>
            <th class="text-left">EMAIL</th>
            <th class="text-center">CNPJ</th>
            <th class="text-center">CEP</th>
            <th class="text-left">ENDEREÇO</th>
            <th class="text-center">NUM.</th>
            <th class="text-center">COMP.</th>
            <th class="text-center">BAIRRO</th>
            <th class="text-center">CIDADE</th>
            <th class="text-center">ESTADO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($companies as $itemCompany)
            <tr class="table"  >
                <td class="text-left " style="font-size: 6px;"> {{ $itemCompany['name'] }}</td>
                <td class="text-center" style="font-size: 6px;"> {{ $itemCompany['phone'] }}</td>
                <td style="font-size: 6px;"> {{ $itemCompany['email'] }}</td>
                <td class="text-center" style="font-size: 6px;"> {{ $itemCompany['employer_number'] }}</td>
                <td style="font-size: 6px;"> {{ $itemCompany['zip_code'] }}</td>
                <td class="text-left" style="font-size: 6px;"> {{ $itemCompany['address'] }}</td>
                <td class="text-center" style="font-size: 6px;"> {{ $itemCompany['number'] }}</td>
                <td class="text-left" style="font-size: 6px;"> {{ $itemCompany['complement'] }}</td>
                <td class="text-left" style="font-size: 6px;"> {{ $itemCompany['neighborhood'] }}</td>
                <td class="text-left" style="font-size: 6px;"> {{ $itemCompany['city'] }}</td>
                <td class="text-center" style="font-size: 6px;"> {{ $itemCompany['uf'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
