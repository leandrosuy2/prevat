<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Mensal de Treinamentos - Prevat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #2c3e50;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
        }
        
        .page-container {
            background: white;
            margin: 20px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            min-height: calc(100vh - 40px);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .header-content {
            position: relative;
            z-index: 2;
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: -1px;
        }
        
        .header .subtitle {
            font-size: 16px;
            margin-top: 10px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .header .period {
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-top: 15px;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .section {
            margin-bottom: 50px;
            page-break-inside: avoid;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border: 1px solid #e8ecf0;
        }
        
        .section-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 25px;
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .section-title::before {
            content: '';
            width: 4px;
            height: 30px;
            background: rgba(255,255,255,0.3);
            margin-right: 15px;
            border-radius: 2px;
        }
        
        .section-content {
            padding: 30px 25px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-item {
            background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
            padding: 25px 20px;
            border-radius: 12px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .summary-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .summary-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
        }
        
        .summary-number {
            font-size: 36px;
            font-weight: 800;
            color: #667eea;
            display: block;
            margin-bottom: 8px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .summary-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        .table th {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }
        
        .table th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255,255,255,0.3);
        }
        
        .table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 11px;
            font-weight: 400;
        }
        
        .table tr:nth-child(even) {
            background-color: #fafbfc;
        }
        
        .table tr:hover {
            background-color: #f0f4ff;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 12px;
            font-size: 10px;
            font-weight: 600;
            border-radius: 20px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .badge-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }
        
        .badge-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .badge-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        .badge-info {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }
        
        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .highlight-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 5px solid #3b82f6;
            padding: 25px;
            margin: 25px 0;
            border-radius: 0 12px 12px 0;
            position: relative;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1);
        }
        
        .highlight-box::before {
            content: '💡';
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 20px;
        }
        
        .highlight-box h4 {
            margin: 0 0 15px 0;
            color: #1e40af;
            font-size: 14px;
            font-weight: 700;
        }
        
        .highlight-box p {
            margin: 0;
            color: #374151;
            line-height: 1.6;
        }
        
        .no-data {
            text-align: center;
            color: #64748b;
            font-style: italic;
            padding: 40px 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            border: 2px dashed #cbd5e1;
        }
        
        .no-data::before {
            content: '📊';
            display: block;
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .footer {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            text-align: center;
            padding: 25px;
            margin-top: 50px;
            border-radius: 12px 12px 0 0;
        }
        
        .footer p {
            margin: 5px 0;
            font-size: 10px;
            opacity: 0.8;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .stat-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .stat-number {
            font-size: 28px;
            font-weight: 800;
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 4px;
            transition: width 0.3s ease;
        }
        
        .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Cabeçalho -->
        <div class="header">
            <div class="header-content">
                <h1>📊 RELATÓRIO MENSAL DE TREINAMENTOS</h1>
                <div class="subtitle">Sistema de Gestão de Treinamentos em Segurança do Trabalho</div>
                <div class="period">
                    📅 {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                </div>
                <div class="subtitle" style="margin-top: 10px;">
                    🎯 {{ $trainingName }} • ⏰ Gerado em {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        <div class="content">

            <!-- Seção 1: Quantidade de Treinamentos ministrados no mês -->
            @if($sections['trainings'] ?? false)
                <div class="section">
                    <div class="section-title">
                        📊 QUANTIDADE DE TREINAMENTOS MINISTRADOS NO MÊS (CRONOGRAMA DO MÊS)
                    </div>
                    <div class="section-content">
                        <div class="summary-grid">
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['trainings']['total_trainings'] ?? 0 }}</span>
                                <span class="summary-label">Total de Treinamentos</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['trainings']['total_participants'] ?? 0 }}</span>
                                <span class="summary-label">Total de Participantes</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['trainings']['total_vacancies'] ?? 0 }}</span>
                                <span class="summary-label">Total de Vagas</span>
                            </div>
                        </div>

                        @if(!empty($data['trainings']['trainings']))
                            <div class="highlight-box">
                                <h4>📋 Detalhamento por Treinamento</h4>
                            </div>
                            
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Treinamento</th>
                                            <th class="text-center">Sigla</th>
                                            <th class="text-center">Quantidade de Turmas</th>
                                            <th class="text-center">Total de Vagas</th>
                                            <th class="text-center">Total de Participantes</th>
                                            <th class="text-center">Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['trainings']['trainings'] as $training)
                                            <tr>
                                                <td><strong>{{ $training['name'] }}</strong></td>
                                                <td class="text-center">{{ $training['acronym'] }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">{{ $training['total_schedules'] }}</span>
                                                </td>
                                                <td class="text-center">{{ $training['total_vacancies'] }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-success">{{ $training['total_participants'] }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-info">{{ $training['type'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="no-data">
                                Nenhum treinamento encontrado para o período selecionado.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Seção 2: Quantidade de Turmas Extras no mês -->
            @if($sections['extra_classes'] ?? false)
                <div class="section">
                    <div class="section-title">
                        ➕ QUANTIDADE DE TURMAS EXTRAS NO MÊS
                    </div>
                    <div class="section-content">
                        <div class="summary-grid">
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['extra_classes']['total_extra_classes'] ?? 0 }}</span>
                                <span class="summary-label">Total de Turmas Extras</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['extra_classes']['total_vacancies'] ?? 0 }}</span>
                                <span class="summary-label">Total de Vagas</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['extra_classes']['total_participants'] ?? 0 }}</span>
                                <span class="summary-label">Total de Participantes</span>
                            </div>
                        </div>

                        @if(($data['extra_classes']['total_extra_classes'] ?? 0) > 0)
                            <div class="highlight-box">
                                <h4>📈 Resumo das Turmas Extras</h4>
                                <p>Durante o período analisado, foram realizadas <strong>{{ $data['extra_classes']['total_extra_classes'] }}</strong> turmas extras, 
                                totalizando <strong>{{ $data['extra_classes']['total_vacancies'] }}</strong> vagas oferecidas e 
                                <strong>{{ $data['extra_classes']['total_participants'] }}</strong> participantes atendidos.</p>
                            </div>
                        @else
                            <div class="no-data">
                                Nenhuma turma extra foi realizada no período selecionado.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Seção 3: Quantidade de empresas atendidas no mês -->
            @if($sections['companies'] ?? false)
                <div class="section">
                    <div class="section-title">
                        🏢 QUANTIDADE DE EMPRESAS ATENDIDAS NO MÊS
                    </div>
                    <div class="section-content">
                        <div class="summary-grid">
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['companies']['total_companies'] ?? 0 }}</span>
                                <span class="summary-label">Total de Empresas</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['companies']['total_schedules'] ?? 0 }}</span>
                                <span class="summary-label">Total de Agendamentos</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['companies']['total_participants'] ?? 0 }}</span>
                                <span class="summary-label">Total de Participantes</span>
                            </div>
                        </div>

                        @if(!empty($data['companies']['companies']))
                            <div class="highlight-box">
                                <h4>🏭 Detalhamento por Empresa</h4>
                            </div>
                            
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Nome Fantasia</th>
                                            <th class="text-center">Agendamentos</th>
                                            <th class="text-center">Treinamentos</th>
                                            <th class="text-center">Participantes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['companies']['companies'] as $company)
                                            <tr>
                                                <td><strong>{{ $company->company_name }}</strong></td>
                                                <td>{{ $company->fantasy_name }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">{{ $company->total_schedules }}</span>
                                                </td>
                                                <td class="text-center">{{ $company->total_trainings }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-success">{{ $company->total_participants }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="no-data">
                                Nenhuma empresa foi atendida no período selecionado.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Seção 4: Cartões e Cartas entregues no mês -->
            @if($sections['cards_delivered'] ?? false)
                <div class="section">
                    <div class="section-title">
                        🎓 CARTÕES E CARTAS ENTREGUES NO MÊS
                    </div>
                    <div class="section-content">
                        <div class="summary-grid">
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['cards_delivered']['total_cards_delivered'] ?? 0 }}</span>
                                <span class="summary-label">Total de Cartões Entregues</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['cards_delivered']['unique_participants'] ?? 0 }}</span>
                                <span class="summary-label">Participantes Únicos</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">
                                    @if(($data['cards_delivered']['unique_participants'] ?? 0) > 0)
                                        {{ number_format((($data['cards_delivered']['total_cards_delivered'] ?? 0) / ($data['cards_delivered']['unique_participants'] ?? 1)) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </span>
                                <span class="summary-label">Taxa de Entrega</span>
                            </div>
                        </div>

                        @if(($data['cards_delivered']['total_cards_delivered'] ?? 0) > 0)
                            <div class="highlight-box">
                                <h4>📋 Resumo das Entregas</h4>
                                <p>Durante o período, foram entregues <strong>{{ $data['cards_delivered']['total_cards_delivered'] }}</strong> cartões/certificados 
                                para <strong>{{ $data['cards_delivered']['unique_participants'] }}</strong> participantes únicos.</p>
                            </div>
                        @else
                            <div class="no-data">
                                Nenhum cartão foi entregue no período selecionado.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Seção 5: Quantidade de melhorias do mês -->
            @if($sections['improvements'] ?? false)
                <div class="section">
                    <div class="section-title">
                        🔧 QUANTIDADE DE MELHORIAS DO MÊS (PROCESSO/INSTALAÇÃO)
                    </div>
                    <div class="section-content">
                        <div class="summary-grid">
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['improvements']['total_improvements'] ?? 0 }}</span>
                                <span class="summary-label">Total de Melhorias</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">{{ $data['improvements']['companies_with_improvements'] ?? 0 }}</span>
                                <span class="summary-label">Empresas com Melhorias</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-number">
                                    @if(($data['improvements']['companies_with_improvements'] ?? 0) > 0)
                                        {{ number_format((($data['improvements']['total_improvements'] ?? 0) / ($data['improvements']['companies_with_improvements'] ?? 1)), 1) }}
                                    @else
                                        0
                                    @endif
                                </span>
                                <span class="summary-label">Média por Empresa</span>
                            </div>
                        </div>

                        @if(!empty($data['improvements']['improvements_by_type']))
                            <div class="highlight-box">
                                <h4>📊 Melhorias por Categoria</h4>
                            </div>
                            
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Categoria</th>
                                            <th class="text-center">Quantidade</th>
                                            <th class="text-center">Percentual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalImprovements = $data['improvements']['total_improvements'] ?? 0;
                                        @endphp
                                        @foreach($data['improvements']['improvements_by_type'] as $improvement)
                                            <tr>
                                                <td><strong>{{ $improvement->category }}</strong></td>
                                                <td class="text-center">
                                                    <span class="badge badge-warning">{{ $improvement->count }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @if($totalImprovements > 0)
                                                        {{ number_format(($improvement->count / $totalImprovements) * 100, 1) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="no-data">
                                Nenhuma melhoria foi registrada no período selecionado.
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Rodapé -->
        <div class="footer">
            <p>📊 Relatório gerado automaticamente pelo Sistema Prevat Treinamentos em {{ now()->format('d/m/Y H:i') }}</p>
            <p>© {{ date('Y') }} Prevat Treinamentos - Todos os direitos reservados</p>
        </div>
    </div>
</body>
</html>
