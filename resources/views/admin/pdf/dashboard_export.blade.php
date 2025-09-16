<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exportação de Dados - Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; }
        h1, h2 { color: #2a4d8f; }
        .section { margin-bottom: 30px; }
        .counter {
            font-size: 2em;
            color: #fff;
            background: #2a4d8f;
            display: inline-block;
            padding: 10px 30px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 10px;
            font-size: 0.95em;
        }
        th {
            background: #e6eefa;
        }
        .small { font-size: 0.9em; color: #666; }
        .filters { 
            background: #f8f9fa; 
            padding: 10px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <h1>Exportação de Dados - Dashboard</h1>
    <p class="small">Período: {{ \Carbon\Carbon::parse($start)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($end)->format('d/m/Y') }}</p>
    
    @if(isset($training_filter))
    <div class="filters">
        <strong>Filtro aplicado:</strong> Treinamento: {{ $training_filter->name }}
    </div>
    @endif

    @if(isset($trainings))
    <div class="section">
        <h2>Treinamentos ministrados no período</h2>
        <div class="counter">{{ $trainings->count() }}</div>
        <span class="small">Ministrados</span>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Treinamento</th>
                    <th>Empresa</th>
                    <th>Participantes</th>
                </tr>
            </thead>
            <tbody>
            @foreach($trainings as $item)
                <tr>
                    <td>{{ optional($item->schedule)->date_event ? \Carbon\Carbon::parse($item->schedule->date_event)->format('d/m/Y') : '-' }}</td>
                    <td>{{ optional($item->schedule->training)->name ?? '-' }}</td>
                    <td>{{ optional($item->company)->fantasy_name ?? '-' }}</td>
                    <td>{{ $item->participants->count() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(isset($companies))
    <div class="section">
        <h2>Empresas atendidas no período</h2>
        <div class="counter">{{ $companies->count() }}</div>
        <span class="small">No período</span>
        <table>
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>CNPJ</th>
                    <th>Email</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{ $company->fantasy_name ?? '-' }}</td>
                    <td>{{ $company->employer_number ?? '-' }}</td>
                    <td>{{ $company->email ?? '-' }}</td>
                    <td>{{ $company->phone ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(isset($turmasExtras))
    <div class="section">
        <h2>Turmas no período</h2>
        <div class="counter">{{ $turmasExtras->count() }}</div>
        <span class="small">No período</span>
        
        @php
            $turmas1 = $turmasExtras->where('turma_type', '1ª TURMA');
            $turmas2 = $turmasExtras->where('turma_type', '2ª TURMA');
            $turmasExtra = $turmasExtras->where('turma_type', 'TURMA EXTRA');
        @endphp
        
        @if($turmas1->count() > 0)
        <h3 style="color: #2a4d8f; margin-top: 20px;">1ª TURMA ({{ $turmas1->count() }} turmas)</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Treinamento</th>
                    <th>Empresa Contratante</th>
                    <th>Equipe</th>
                </tr>
            </thead>
            <tbody>
            @foreach($turmas1 as $turma)
                <tr>
                    <td>{{ $turma->date_event ? \Carbon\Carbon::parse($turma->date_event)->format('d/m/Y') : '-' }}</td>
                    <td>{{ optional($turma->training)->name ?? '-' }}</td>
                    <td>{{ optional($turma->contractor)->fantasy_name ?? '-' }}</td>
                    <td>{{ $turma->turma_type ?? optional($turma->team)->name ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        
        @if($turmas2->count() > 0)
        <h3 style="color: #2a4d8f; margin-top: 20px;">2ª TURMA ({{ $turmas2->count() }} turmas)</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Treinamento</th>
                    <th>Empresa Contratante</th>
                    <th>Equipe</th>
                </tr>
            </thead>
            <tbody>
            @foreach($turmas2 as $turma)
                <tr>
                    <td>{{ $turma->date_event ? \Carbon\Carbon::parse($turma->date_event)->format('d/m/Y') : '-' }}</td>
                    <td>{{ optional($turma->training)->name ?? '-' }}</td>
                    <td>{{ optional($turma->contractor)->fantasy_name ?? '-' }}</td>
                    <td>{{ $turma->turma_type ?? optional($turma->team)->name ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        
        @if($turmasExtra->count() > 0)
        <h3 style="color: #2a4d8f; margin-top: 20px;">TURMA EXTRA ({{ $turmasExtra->count() }} turmas)</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Treinamento</th>
                    <th>Empresa Contratante</th>
                    <th>Equipe</th>
                </tr>
            </thead>
            <tbody>
            @foreach($turmasExtra as $turma)
                <tr>
                    <td>{{ $turma->date_event ? \Carbon\Carbon::parse($turma->date_event)->format('d/m/Y') : '-' }}</td>
                    <td>{{ optional($turma->training)->name ?? '-' }}</td>
                    <td>{{ optional($turma->contractor)->fantasy_name ?? '-' }}</td>
                    <td>{{ $turma->turma_type ?? optional($turma->team)->name ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
    @endif
</body>
</html> 