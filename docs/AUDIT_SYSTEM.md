# Sistema de Auditoria - Prevat

## Visão Geral

O Sistema de Auditoria do Prevat é uma solução completa e integrada para monitorar, rastrear e analisar todas as atividades do sistema, proporcionando transparência, segurança e conformidade regulatória.

## Funcionalidades Principais

### 🔍 **Rastreamento de Atividades**
- **Login/Logout**: Registra todos os acessos ao sistema
- **Ações do Usuário**: Monitora criação, edição e exclusão de registros
- **Segundas Vias**: Rastreia emissão de segundas vias de certificados
- **Mudanças de Sistema**: Registra alterações em configurações e permissões

### 🚨 **Detecção de Acessos Suspeitos**
- **Horário Comercial**: Identifica acessos fora do horário normal (8h-18h)
- **Fins de Semana**: Detecta acessos em sábados e domingos
- **IPs Externos**: Monitora acessos de redes externas
- **Padrões Anômalos**: Identifica comportamentos suspeitos

### 📊 **Dashboard de Auditoria**
- **Estatísticas em Tempo Real**: Total de usuários, acessos ativos, etc.
- **Alertas de Segurança**: Notificações sobre atividades suspeitas
- **Atividades Recentes**: Histórico das últimas ações do sistema
- **Padrões de Acesso**: Análise de horários e frequência de uso

### 🗂️ **Relatórios e Exportação**
- **Logs de Auditoria**: Histórico completo de todas as atividades
- **Segundas Vias**: Relatório detalhado de certificados reemitidos
- **Acessos Suspeitos**: Lista de acessos que requerem atenção
- **Exportação**: Suporte para CSV, Excel e PDF

## Estrutura do Sistema

### Modelos Principais

#### 1. **AuditLog**
Registra todas as atividades do sistema:
```php
- user_id: ID do usuário que realizou a ação
- action: Tipo de ação (create, update, delete, etc.)
- description: Descrição detalhada da ação
- ip_address: Endereço IP do usuário
- user_agent: Navegador/dispositivo utilizado
- target_type: Tipo do objeto afetado
- target_id: ID do objeto afetado
- old_values: Valores anteriores (para updates)
- new_values: Novos valores (para creates/updates)
- location: Localização geográfica do IP
- session_id: ID da sessão do usuário
```

#### 2. **UserSession**
Rastreia sessões de usuários:
```php
- user_id: ID do usuário
- session_id: ID da sessão
- ip_address: IP de acesso
- location: Localização do IP
- login_at: Horário de login
- logout_at: Horário de logout
- last_activity: Última atividade
- is_suspicious: Se o acesso é suspeito
- suspicious_reason: Razão para ser suspeito
```

#### 3. **CertificateReissue**
Monitora segundas vias de certificados:
```php
- original_certificate_id: ID do certificado original
- reissued_by_user_id: Usuário que emitiu a segunda via
- reason: Motivo da segunda via
- ip_address: IP de onde foi solicitado
- status: Status da solicitação
```

### Repositórios

#### **AuditRepository**
Gerencia todas as operações de auditoria:
- `getDashboardStats()`: Estatísticas do dashboard
- `getRecentActivities()`: Atividades recentes
- `getCertificateReissues()`: Segundas vias
- `getSuspiciousAccesses()`: Acessos suspeitos
- `getSecurityAlerts()`: Alertas de segurança

### Middleware e Observers

#### **AuditMiddleware**
Registra automaticamente todas as atividades HTTP:
- Intercepta todas as requisições
- Identifica ações automaticamente
- Registra logs em tempo real

#### **UserAuditObserver**
Monitora mudanças no modelo User:
- Criação de usuários
- Atualizações de dados
- Exclusões e restaurações
- Mudanças de permissões

### Listeners de Eventos

#### **UserAuthenticationListener**
Rastreia eventos de autenticação:
- Login bem-sucedido
- Logout
- Tentativas de login falhadas
- Reset de senha

## Configuração

### Variáveis de Ambiente

```env
# Habilitar sistema de auditoria
AUDIT_ENABLED=true

# Retenção de logs (dias)
AUDIT_RETENTION_LOGS=90
AUDIT_RETENTION_SESSIONS=60
AUDIT_RETENTION_REISSUES=365

# Configurações de segurança
AUDIT_BUSINESS_HOURS_START=8
AUDIT_BUSINESS_HOURS_END=18
AUDIT_SUSPICIOUS_LIMIT=3

# Notificações
AUDIT_NOTIFICATIONS_ENABLED=true
AUDIT_NOTIFY_EMAIL=true

# Geolocalização
AUDIT_GEOLOCATION_ENABLED=true
AUDIT_GEOLOCATION_PROVIDER=ip-api
```

### Configuração do AppServiceProvider

```php
use App\Models\User;
use App\Observers\UserAuditObserver;

public function boot()
{
    User::observe(UserAuditObserver::class);
}
```

### Configuração de Eventos

```php
// config/event.php
'listeners' => [
    \Illuminate\Auth\Events\Login::class => [
        \App\Listeners\UserAuthenticationListener::class,
    ],
    \Illuminate\Auth\Events\Logout::class => [
        \App\Listeners\UserAuthenticationListener::class,
    ],
    \Illuminate\Auth\Events\Failed::class => [
        \App\Listeners\UserAuthenticationListener::class,
    ],
],
```

## Uso

### Acessando o Dashboard

1. Faça login como usuário `financeiro@prevat.com.br`
2. Acesse o menu "Auditoria" no sidebar
3. Visualize as estatísticas e alertas em tempo real

### Comandos Artisan

#### Limpeza de Logs Antigos
```bash
# Manter logs dos últimos 90 dias (padrão)
php artisan audit:clean

# Manter logs dos últimos 30 dias
php artisan audit:clean --days=30

# Manter logs dos últimos 180 dias
php artisan audit:clean --days=180
```

#### População de Dados de Exemplo
```bash
php artisan db:seed --class=AuditSeeder
```

### API de Auditoria

#### Registrar Ação Manualmente
```php
use App\Models\AuditLog;

AuditLog::log(
    'custom_action',
    'Descrição da ação personalizada',
    'ModelType',
    $modelId
);
```

#### Verificar Acesso Suspeito
```php
use App\Models\UserSession;

$isSuspicious = UserSession::isSuspiciousAccess($userId);
```

## Monitoramento e Alertas

### Tipos de Alertas

1. **Warning**: Múltiplos acessos suspeitos
2. **Info**: Acesso fora do horário comercial
3. **Danger**: Acesso de IP externo

### Configuração de Notificações

O sistema pode enviar notificações para:
- Email
- Slack
- Webhooks personalizados

## Manutenção

### Limpeza Automática

Configure um cron job para limpeza automática:
```bash
# Adicionar ao crontab
0 2 * * * cd /path/to/project && php artisan audit:clean
```

### Backup dos Logs

Recomenda-se fazer backup regular das tabelas de auditoria:
- `audit_logs`
- `user_sessions`
- `certificate_reissues`

### Monitoramento de Performance

- As tabelas possuem índices otimizados
- Logs antigos são limpos automaticamente
- Queries são otimizadas para grandes volumes de dados

## Segurança

### Proteção de Dados

- IPs são mascarados para usuários não-admin
- Dados sensíveis são criptografados
- Acesso restrito apenas para usuários autorizados

### Conformidade

- Atende requisitos de auditoria corporativa
- Mantém histórico completo de atividades
- Suporte para auditorias externas

## Suporte

Para dúvidas ou problemas com o sistema de auditoria:

1. Verifique os logs do sistema
2. Consulte a documentação
3. Entre em contato com a equipe de desenvolvimento

---

**Versão**: 1.0.0  
**Última Atualização**: Janeiro 2025  
**Desenvolvido por**: Equipe Prevat
