@extends('layouts.app')

@section('title', 'Auditoria')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Painel de Auditoria</h1>
    </div>
    <div class="ms-auto pageheader-btn">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Auditoria</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- Estatísticas Principais -->
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="avatar avatar-lg bg-primary rounded-circle me-3">
                                <i class="fe fe-users text-white fs-2"></i>
                            </div>
                        </div>
                        <h4 class="text-muted mb-2">Total de Usuários</h4>
                        <h2 class="text-primary mb-0 fw-bold">
                            @if(class_exists('\App\Models\User'))
                                {{ \App\Models\User::count() }}
                            @else
                                0
                            @endif
                        </h2>
                        <small class="text-muted">Cadastrados no sistema</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="avatar avatar-lg bg-success rounded-circle me-3">
                                <i class="fe fe-user-check text-white fs-2"></i>
                            </div>
                        </div>
                        <h4 class="text-muted mb-2">Usuários Ativos</h4>
                        <h2 class="text-success mb-0 fw-bold">
                            @if(class_exists('\App\Models\UserSession') && method_exists('\App\Models\UserSession', 'getActiveUsers'))
                                {{ \App\Models\UserSession::getActiveUsers()->count() }}
                            @else
                                0
                            @endif
                        </h2>
                        <small class="text-muted">Logados agora</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="avatar avatar-lg bg-warning rounded-circle me-3">
                                <i class="fe fe-alert-triangle text-white fs-2"></i>
                            </div>
                        </div>
                        <h4 class="text-muted mb-2">Acessos Suspeitos</h4>
                        <h2 class="text-warning mb-0 fw-bold">
                            @if(class_exists('\App\Models\UserSession') && method_exists('\App\Models\UserSession', 'getSuspiciousSessions'))
                                {{ \App\Models\UserSession::getSuspiciousSessions()->count() }}
                            @else
                                0
                            @endif
                        </h2>
                        <small class="text-muted">Requerem atenção</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="avatar avatar-lg bg-info rounded-circle me-3">
                                <i class="fe fe-file-text text-white fs-2"></i>
                            </div>
                        </div>
                        <h4 class="text-muted mb-2">Segundas Vias</h4>
                        <h2 class="text-info mb-0 fw-bold">
                            @if(class_exists('\App\Models\CertificateReissue'))
                                {{ \App\Models\CertificateReissue::count() }}
                            @else
                                0
                            @endif
                        </h2>
                        <small class="text-muted">Certificados reemitidos</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas de Segurança -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-shield text-warning"></i>
                            Alertas de Segurança
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(class_exists('\App\Repositories\AuditRepository'))
                            @php
                                try {
                                    $auditRepo = new \App\Repositories\AuditRepository();
                                    $securityAlerts = $auditRepo->getSecurityAlerts();
                                } catch (\Exception $e) {
                                    $securityAlerts = collect([]);
                                }
                            @endphp

                            @if($securityAlerts->count() > 0)
                                @foreach($securityAlerts->take(5) as $alert)
                                    <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show" role="alert">
                                        <strong>{{ $alert['title'] }}:</strong> {{ $alert['message'] }}
                                        <small class="d-block text-muted mt-1">
                                            {{ \Carbon\Carbon::parse($alert['created_at'])->diffForHumans() }}
                                        </small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-success">
                                    <i class="fe fe-check-circle"></i>
                                    Nenhum alerta de segurança no momento. Sistema operando normalmente.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <i class="fe fe-info"></i>
                                Sistema de auditoria em configuração. Execute as migrations para ativar.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Atividades Recentes e Usuários por Nível de Acesso -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-activity text-primary"></i>
                            Atividades Recentes do Sistema
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(class_exists('\App\Repositories\AuditRepository'))
                            @php
                                try {
                                    $recentActivities = $auditRepo->getRecentActivities(10);
                                } catch (\Exception $e) {
                                    $recentActivities = collect([]);
                                }
                            @endphp

                            @if($recentActivities->count() > 0)
                                <div class="activity">
                                    @foreach($recentActivities as $activity)
                                        <div class="activity-item">
                                            <div class="activity-badge bg-primary"></div>
                                            <div class="activity-content">
                                                <h6 class="mb-1">
                                                    @if(class_exists('\App\Helpers\AuditTranslator'))
                                                        {{ \App\Helpers\AuditTranslator::translateAction($activity->action ?? 'Ação') }}
                                                    @else
                                                        {{ $activity->action ?? 'Ação' }}
                                                    @endif
                                                </h6>
                                                <p class="text-muted">
                                                    @if($activity->user)
                                                        <strong>{{ $activity->user->name ?? 'Usuário' }}</strong>
                                                    @endif
                                                    @if($activity->description)
                                                        - 
                                                        @if(class_exists('\App\Helpers\AuditTranslator'))
                                                            {{ \App\Helpers\AuditTranslator::translateDescription($activity->description) }}
                                                        @else
                                                            {{ $activity->description }}
                                                        @endif
                                                    @endif
                                                </p>
                                                <small class="text-muted">
                                                    <i class="fe fe-map-pin"></i> {{ $activity->ip_address ?? 'N/A' }}
                                                    @if($activity->location)
                                                        ({{ $activity->location }})
                                                    @endif
                                                    - {{ $activity->created_at ? $activity->created_at->diffForHumans() : 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Nenhuma atividade registrada no momento.</p>
                            @endif
                        @else
                            <p class="text-muted">Sistema de auditoria não configurado. Execute as migrations.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-users text-success"></i>
                            Usuários por Nível de Acesso
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(class_exists('\App\Repositories\AuditRepository'))
                            @php
                                try {
                                    $usersByAccessLevel = $auditRepo->getUsersByAccessLevel();
                                } catch (\Exception $e) {
                                    $usersByAccessLevel = collect([]);
                                }
                            @endphp

                            @if($usersByAccessLevel->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Usuário</th>
                                                <th>Nível</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usersByAccessLevel->take(8) as $user)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm me-2">
                                                                <span class="avatar-initial rounded-circle bg-primary">
                                                                    {{ substr($user->name ?? 'U', 0, 1) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-medium">{{ $user->name ?? 'Nome não disponível' }}</div>
                                                                <div class="text-muted small">{{ $user->email ?? 'Email não disponível' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $user->role_name ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        @if(($user->status ?? '') === 'Ativo')
                                                            <span class="badge bg-success">{{ $user->status }}</span>
                                                        @else
                                                            <span class="badge bg-warning">{{ $user->status ?? 'N/A' }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Nenhum usuário encontrado.</p>
                            @endif
                        @else
                            <p class="text-muted">Sistema de auditoria não configurado.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Padrões de Acesso e Ações Mais Comuns -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-bar-chart text-warning"></i>
                            Padrões de Acesso (Últimas 24h)
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(class_exists('\App\Repositories\AuditRepository'))
                            @php
                                try {
                                    $accessPatterns = $auditRepo->getAccessPatterns();
                                } catch (\Exception $e) {
                                    $accessPatterns = collect([]);
                                }
                            @endphp

                            @if($accessPatterns->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Horário</th>
                                                <th>Total Acessos</th>
                                                <th>Suspeitos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($accessPatterns->take(12) as $pattern)
                                                <tr>
                                                    <td>{{ $pattern->hour ?? 'N/A' }}:00</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $pattern->total_accesses ?? 0 }}</span>
                                                    </td>
                                                    <td>
                                                        @if(($pattern->suspicious_accesses ?? 0) > 0)
                                                            <span class="badge bg-warning">{{ $pattern->suspicious_accesses }}</span>
                                                        @else
                                                            <span class="badge bg-success">0</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Nenhum padrão de acesso registrado.</p>
                            @endif
                        @else
                            <p class="text-muted">Sistema de auditoria não configurado.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-list text-info"></i>
                            Ações Mais Comuns
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(class_exists('\App\Repositories\AuditRepository'))
                            @php
                                try {
                                    $topActions = $auditRepo->getTopActions();
                                } catch (\Exception $e) {
                                    $topActions = collect([]);
                                }
                            @endphp

                            @if($topActions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Ação</th>
                                                <th>Total</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalActions = $topActions->sum('total');
                                            @endphp
                                            @foreach($topActions->take(8) as $action)
                                                <tr>
                                                    <td>
                                                        @if(class_exists('\App\Helpers\AuditTranslator'))
                                                            {{ \App\Helpers\AuditTranslator::translateAction($action->action ?? 'N/A') }}
                                                        @else
                                                            {{ $action->action ?? 'N/A' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $action->total ?? 0 }}</td>
                                                    <td>
                                                        @php
                                                            $percentage = $totalActions > 0 ? round((($action->total ?? 0) / $totalActions) * 100, 1) : 0;
                                                        @endphp
                                                        <div class="progress" style="height: 6px;">
                                                            <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                        <small class="text-muted">{{ $percentage }}%</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Nenhuma ação registrada.</p>
                            @endif
                        @else
                            <p class="text-muted">Sistema de auditoria não configurado.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Sistema -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-info text-secondary"></i>
                            Informações do Sistema
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p><strong>Versão:</strong> 1.0.0</p>
                                <p><strong>Ambiente:</strong> {{ config('app.env') }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Última Atualização:</strong> {{ now()->format('d/m/Y') }}</p>
                                <p><strong>Status:</strong> <span class="badge bg-success">Ativo</span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Total de Empresas:</strong> 
                                    @if(class_exists('\App\Models\Company'))
                                        {{ \App\Models\Company::count() }}
                                    @else
                                        0
                                    @endif
                                </p>
                                <p><strong>Total de Certificados:</strong> 
                                    @if(class_exists('\App\Models\TrainingCertificates'))
                                        {{ \App\Models\TrainingCertificates::count() }}
                                    @else
                                        0
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Logs Hoje:</strong> 
                                    @if(class_exists('\App\Models\AuditLog'))
                                        {{ \App\Models\AuditLog::whereDate('created_at', now()->toDateString())->count() }}
                                    @else
                                        0
                                    @endif
                                </p>
                                <p><strong>Logs Mês:</strong> 
                                    @if(class_exists('\App\Models\AuditLog'))
                                        {{ \App\Models\AuditLog::where('created_at', '>=', now()->subMonth())->count() }}
                                    @else
                                        0
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instruções de Configuração -->
        @if(!class_exists('\App\Models\AuditLog'))
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="card-title">
                            <i class="fe fe-alert-triangle"></i>
                            Configuração Necessária
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <h5><i class="fe fe-info"></i> Sistema de Auditoria não configurado</h5>
                            <p>Para ativar o sistema de auditoria completo, execute os seguintes comandos:</p>
                            <div class="bg-light p-3 rounded">
                                <code>
                                    # Executar migrations<br>
                                    php artisan migrate<br><br>
                                    
                                    # Popular com dados de exemplo<br>
                                    php artisan db:seed --class=AuditSeeder
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Atualizar dados a cada 5 minutos apenas se o sistema estiver configurado
    @if(class_exists('\App\Models\AuditLog'))
    setInterval(function() {
        location.reload();
    }, 300000);
    @endif
});
</script>
@endpush

@push('styles')
<style>
    .card.border-primary:hover {
        box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.15);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .card.border-success:hover {
        box-shadow: 0 0.5rem 1rem rgba(25, 135, 84, 0.15);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .card.border-warning:hover {
        box-shadow: 0 0.5rem 1rem rgba(255, 193, 7, 0.15);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .card.border-info:hover {
        box-shadow: 0 0.5rem 1rem rgba(13, 202, 240, 0.15);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .avatar-lg {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .fw-bold {
        font-weight: 700 !important;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
    
    .card {
        border-radius: 12px;
        border-width: 2px;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    h2 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    
    h4 {
        font-size: 1rem;
        font-weight: 500;
    }
    
    small {
        font-size: 0.875rem;
    }
</style>
@endpush
