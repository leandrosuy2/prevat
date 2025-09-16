<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>IMPRESSÃO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ url('pdf/service-order/web/modern-normalize.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/service-order/web/web-base.css')}}" rel="stylesheet" />
    <link href="{{ url('pdf/service-order/invoice.css')}}" rel="stylesheet" />

    <script src="{{ url('pdf/service-order/web/scripts.js')}}"></script>
</head>
<body>

<div class="web-container">

{{--    <div class="logo-container">--}}
{{--            <img  style="height: 30px" src="{{ url('pdf/images/prevat_logo_pdf.png')}}" alt="logo">--}}
{{--    </div>--}}

    <table class="invoice-info-container" style="border-top: 1px solid #999;">
        <thead>
        <tr>
            <td rowspan="5" colspan="3">
                <img  style="height: 40px; margin-right: 10px;" src="{{ url('pdf/images/prevat_logo_pdf.png')}}" alt="logo">
            </td>
            <td class=""></td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="client-name">
                PREVAT TREINAMENTOS
            </td>
            <td class="bold">
                (91)3754-0691 - 91 996311026
            </td>
        </tr>
        <tr>
            <td>
                CNPJ: 20.827.565/0001-54
            </td>
            <td class="bold">
                financeiro@prevat.com.br
            </td>
        </tr>
        <tr>
            <td>
                TRAV. RAIMUNDO JOSÉ COUTINHO, 21 (QD 246 LT 21) - NÚCLEO URBANO
            </td>
            <td class="bold">
                https://prevat.com.br
            </td>
        </tr>
        <tr>
            <td>
                Barcarena/PA - CEP: 68445-000
            </td>
            <td style="white-space: nowrap; padding-bottom: 10px;">
                Responsável: <span class="bold">ARNALDO LOBATO</span>
            </td>
        </tr>
        </thead>

    </table>

    <table class="line-order-number">
        <thead>
            <tr>
                <th class="st">Ordem de Servico Nº {{$order['id']}}</th>
                <th style="text-align: right;" width="10%"> {{formatDate($order['created_at'])}}</th>
            </tr>
        </thead>
    </table>

    <table class="line-items-container">
        <thead>
    <tr class="line-order-services">
        <th  colspan="4">Dados do cliente</th>
    </tr>
        </thead>
        <tbody>
            <tr>
                @if($order['contact']['type'] === 'CNPJ')
                    <td class="heading-quantity bold"> Razão social: </td>
                    <td style="text-align: left"> {{ $order['contact']['name'] }} </td>
                    <td class="heading-quantity bold"> Nome fantasia: </td>
                    <td style="text-align: left">{{ $order['contact']['fantasy_name'] }} </td>
                @elseif($order['contact']['type'] === 'CPF')
                    <td class="heading-quantity bold"> Nome: </td>
                    <td style="text-align: left" colspan="3"> {{ $order['contact']['contact_name'] }} </td>
                @endif
            </tr>
            <tr>
                @if($order['contact']['type'] === 'CNPJ')
                    <td class="heading-quantity bold"> CNPJ : </td>
                    <td style="text-align: left"> {{ $order['contact']['employer_number'] }} </td>
                @elseif($order['contact']['type'] === 'CPF')
                    <td class="heading-quantity bold"> CPF : </td>
                    <td style="text-align: left"> {{ $order['contact']['taxpayer_registration'] }} </td>
                @endif
                <td class="heading-quantity bold"> Endereço : </td>
                <td style="text-align: left"> {{ $order['contact']['address'] }}, {{ $order['contact']['number'] }}  {{'-' .$order['contact']['complement'] ?? '' }} - {{ $order['contact']['neighborhood'] }}  </td>
            </tr>
            <tr>
                <td class="heading-quantity bold"> CEP : </td>
                <td style="text-align: left"> {{ $order['contact']['zip_code'] }} </td>
                <td class="heading-quantity bold"> Cidade/UF : </td>
                <td style="text-align: left"> {{ $order['contact']['city'] }}/{{ $order['contact']['uf'] }} </td>
            </tr>
            <tr>
                <td class="heading-quantity bold"> Telefone : </td>
                <td style="text-align: left"> {{ $order['contact']['phone'] }} </td>
                <td class="heading-quantity bold"> E-mail:  : </td>
                <td style="text-align: left"> {{ $order['contact']['email'] }} </td>
            </tr>
        </tbody>
    </table>

    <table class="line-items-container">
        <thead>
        <tr class="line-order-services">
            <th  colspan="5">Serviços</th>
        </tr>
        <tr>
            <th class="heading-quantity">Item</th>
            <th class="heading-description">Nome</th>
            <th class="heading-quantity">QTD.</th>
            <th class="heading-price">VR. UNIT</th>
            <th style="text-align: right">SUBTOTAL</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order['releases'] as $key => $itemRelease)
            <tr>
                <td class="heading-quantity"> {{ $key + 1 }} </td>
                <td> {{ $itemRelease['schedule_company']['schedule']['training']['name'] }} </td>
                <td class="heading-quantity"> {{ $itemRelease['schedule_company']['participantsPresent']->sum('quantity') }} </td>
                <td class="right"> {{formatMoney($itemRelease['schedule_company']['price'])}} </td>
                <td class="bold"> {{formatMoney($itemRelease['schedule_company']['price_total'])}} </td>
            </tr>
        @endforeach
        </tbody>

        <tfoot class="tfoot">
        <tr>
            <td colspan="2">Total</td>
            <td style="text-align: center;">{{$participants->sum('quantity')}}</td>
            <td colspan="2">{{formatMoney($order['total_releases'])}}</td>
        </tr>
        </tfoot>
    </table>

    <table class="line-order-values">
        <thead>
            <tr>
                <th style="text-align: right">Treinamentos : {{ formatMoney($order['total_releases'])}}</th>
            </tr>
        </thead>
    </table>

    <table class="line-order-values">
        <thead>
        <tr>
            <th style="text-align: right">Desconto : {{ formatMoney($order['total_discounts'])}}</th>
        </tr>
        </thead>
    </table>

    <table class="line-order-values">
        <thead>
            <tr>
                <th style="text-align: right">Total : {{ formatMoney($order['total_value'])}}</th>
            </tr>
        </thead>
    </table>

    <div class="atach">
        ANEXO : <a href="{{ url('storage/'.$order['participants_path'])}}" class="">LISTA PARTICIPANTES</a>
    </div>


    <table class="line-items-container has-bottom-border">
        <thead>
        <tr class="line-order-services">
            <th  colspan="4">Dados do Pagamento</th>
        </tr>
        <tr>
            <th>Vencimento</th>
            <th>Valor</th>
            <th>Forma de Pagamento</th>
            <th>Observação</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="payment-info">{{ formatDate($order['due_date'])}} </td>
            <td class="large"> {{ formatMoney($order['total_value'])}}</td>
            <td class="large">{{ $order['payment']['name'] }}</td>
            <td class="large total"></td>
        </tr>
        </tbody>
    </table>

    <table class="line-items-container">
        <thead>
        <tr class="line-order-services">
            <th  colspan="3">Relação dos Participantes</th>
        </tr>
        <tr>
            <th class="heading-quantity">Data</th>
            <th class="heading-description">Treinamento</th>
            <th class="heading-description">Participante</th>
        </tr>
        </thead>
        <tbody>
        @foreach($participants as $key => $itemParticipant)
            <tr>
                <td class="heading-quantity"> {{ formatDate($itemParticipant['schedule_company']['schedule']['date_event']) }} </td>
                <td> {{ $itemParticipant['schedule_company']['schedule']['training']['name'] }} </td>
                <td style="text-align: left;"> {{($itemParticipant['participant']['name'])}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <table class="invoice-info-container" style="margin-top: 30px;">
        <tbody style="text-align: center">
            <tr>
                <td class="" width="50%" height="60px;" style="text-align: center">Entrada {{ formatDateAndTime($order['created_at'])}} </td>
                <td class="" width="50%" height="60px;" style="text-align: center"> Saída _____/_____/______ = ______:_____ </td>

            </tr>
            <tr>
                <td style="text-align: center">_______________________________________________</td>
                <td style="text-align: center">_______________________________________________</td>
            </tr>
            <tr style="">
                <td style="text-align: center;padding-bottom: 20px;">Assinatura do cliente</td>
                <td style="text-align: center;padding-bottom: 20px;">Assinatura do técnico</td>
            </tr>
        </tbody>
    </table>




</div>

</body>
</html>
