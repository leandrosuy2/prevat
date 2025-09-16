<?php

namespace App\Helpers;

class AuditTranslator
{
    /**
     * Traduz ações de auditoria para português
     */
    public static function translateAction($action): string
    {
        $translations = [
            // Autenticação
            'login_success' => 'Login realizado com sucesso',
            'login_failed' => 'Tentativa de login falhou',
            'logout' => 'Logout realizado',
            'password_reset' => 'Senha redefinida',
            'password_change' => 'Senha alterada',
            
            // Usuários
            'user_created' => 'Usuário criado',
            'user_updated' => 'Usuário atualizado',
            'user_deleted' => 'Usuário excluído',
            'user_restored' => 'Usuário restaurado',
            'role_changed' => 'Permissão alterada',
            
            // Certificados
            'certificate_generated' => 'Certificado gerado',
            'certificate_downloaded' => 'Certificado baixado',
            'certificate_reissued' => 'Segunda via emitida',
            'certificate_validated' => 'Certificado validado',
            
            // Treinamentos
            'training_scheduled' => 'Treinamento agendado',
            'training_cancelled' => 'Treinamento cancelado',
            'training_completed' => 'Treinamento concluído',
            'training_started' => 'Treinamento iniciado',
            
            // Participantes
            'participant_registered' => 'Participante registrado',
            'participant_removed' => 'Participante removido',
            'participant_updated' => 'Participante atualizado',
            'participant_approved' => 'Participante aprovado',
            
            // Empresas
            'company_created' => 'Empresa criada',
            'company_updated' => 'Empresa atualizada',
            'company_deleted' => 'Empresa excluída',
            'company_activated' => 'Empresa ativada',
            'company_deactivated' => 'Empresa desativada',
            
            // Contratos
            'contract_created' => 'Contrato criado',
            'contract_updated' => 'Contrato atualizado',
            'contract_renewed' => 'Contrato renovado',
            'contract_cancelled' => 'Contrato cancelado',
            
            // Financeiro
            'payment_received' => 'Pagamento recebido',
            'invoice_generated' => 'Fatura gerada',
            'refund_processed' => 'Reembolso processado',
            'payment_failed' => 'Pagamento falhou',
            
            // Sistema
            'backup_created' => 'Backup criado',
            'maintenance_mode' => 'Modo de manutenção',
            'config_changed' => 'Configuração alterada',
            'system_updated' => 'Sistema atualizado',
            
            // Arquivos
            'file_uploaded' => 'Arquivo enviado',
            'file_downloaded' => 'Arquivo baixado',
            'file_deleted' => 'Arquivo excluído',
            'file_shared' => 'Arquivo compartilhado',
            
            // Relatórios
            'report_generated' => 'Relatório gerado',
            'report_exported' => 'Relatório exportado',
            'report_scheduled' => 'Relatório agendado',
            
            // Notificações
            'notification_sent' => 'Notificação enviada',
            'email_sent' => 'E-mail enviado',
            'sms_sent' => 'SMS enviado',
            
            // Auditoria
            'audit_log_created' => 'Log de auditoria criado',
            'audit_report_generated' => 'Relatório de auditoria gerado',
            
            // Segurança
            'access_denied' => 'Acesso negado',
            'suspicious_activity' => 'Atividade suspeita detectada',
            'security_alert' => 'Alerta de segurança',
            
            // Padrões genéricos
            'create' => 'Registro criado',
            'update' => 'Registro atualizado',
            'delete' => 'Registro excluído',
            'view' => 'Registro visualizado',
            'export' => 'Dados exportados',
            'import' => 'Dados importados',
            'download' => 'Arquivo baixado',
            'upload' => 'Arquivo enviado',
        ];

        return $translations[$action] ?? self::formatActionName($action);
    }

    /**
     * Formata nomes de ações que não estão no dicionário
     */
    private static function formatActionName($action): string
    {
        // Converter snake_case para texto legível
        $formatted = str_replace('_', ' ', $action);
        $formatted = ucwords($formatted);
        
        // Traduções específicas para palavras comuns
        $formatted = str_replace('User', 'Usuário', $formatted);
        $formatted = str_replace('Company', 'Empresa', $formatted);
        $formatted = str_replace('Training', 'Treinamento', $formatted);
        $formatted = str_replace('Certificate', 'Certificado', $formatted);
        $formatted = str_replace('Participant', 'Participante', $formatted);
        $formatted = str_replace('Contract', 'Contrato', $formatted);
        $formatted = str_replace('Payment', 'Pagamento', $formatted);
        $formatted = str_replace('Invoice', 'Fatura', $formatted);
        $formatted = str_replace('Report', 'Relatório', $formatted);
        $formatted = str_replace('File', 'Arquivo', $formatted);
        $formatted = str_replace('System', 'Sistema', $formatted);
        $formatted = str_replace('Config', 'Configuração', $formatted);
        $formatted = str_replace('Backup', 'Backup', $formatted);
        $formatted = str_replace('Maintenance', 'Manutenção', $formatted);
        $formatted = str_replace('Notification', 'Notificação', $formatted);
        $formatted = str_replace('Email', 'E-mail', $formatted);
        $formatted = str_replace('Sms', 'SMS', $formatted);
        $formatted = str_replace('Audit', 'Auditoria', $formatted);
        $formatted = str_replace('Security', 'Segurança', $formatted);
        $formatted = str_replace('Access', 'Acesso', $formatted);
        $formatted = str_replace('Activity', 'Atividade', $formatted);
        $formatted = str_replace('Alert', 'Alerta', $formatted);
        $formatted = str_replace('Suspicious', 'Suspeita', $formatted);
        $formatted = str_replace('Detected', 'Detectada', $formatted);
        $formatted = str_replace('Denied', 'Negado', $formatted);
        $formatted = str_replace('Failed', 'Falhou', $formatted);
        $formatted = str_replace('Processed', 'Processado', $formatted);
        $formatted = str_replace('Scheduled', 'Agendado', $formatted);
        $formatted = str_replace('Cancelled', 'Cancelado', $formatted);
        $formatted = str_replace('Completed', 'Concluído', $formatted);
        $formatted = str_replace('Started', 'Iniciado', $formatted);
        $formatted = str_replace('Removed', 'Removido', $formatted);
        $formatted = str_replace('Approved', 'Aprovado', $formatted);
        $formatted = str_replace('Activated', 'Ativado', $formatted);
        $formatted = str_replace('Deactivated', 'Desativado', $formatted);
        $formatted = str_replace('Renewed', 'Renovado', $formatted);
        $formatted = str_replace('Received', 'Recebido', $formatted);
        $formatted = str_replace('Generated', 'Gerado', $formatted);
        $formatted = str_replace('Exported', 'Exportado', $formatted);
        $formatted = str_replace('Imported', 'Importado', $formatted);
        $formatted = str_replace('Downloaded', 'Baixado', $formatted);
        $formatted = str_replace('Uploaded', 'Enviado', $formatted);
        $formatted = str_replace('Shared', 'Compartilhado', $formatted);
        $formatted = str_replace('Sent', 'Enviado', $formatted);
        $formatted = str_replace('Changed', 'Alterado', $formatted);
        $formatted = str_replace('Updated', 'Atualizado', $formatted);
        $formatted = str_replace('Created', 'Criado', $formatted);
        $formatted = str_replace('Deleted', 'Excluído', $formatted);
        $formatted = str_replace('Viewed', 'Visualizado', $formatted);
        
        return $formatted;
    }

    /**
     * Traduz tipos de alvo para português
     */
    public static function translateTargetType($targetType): string
    {
        $translations = [
            'User' => 'Usuário',
            'Company' => 'Empresa',
            'Training' => 'Treinamento',
            'TrainingCertificate' => 'Certificado de Treinamento',
            'Participant' => 'Participante',
            'Contract' => 'Contrato',
            'Payment' => 'Pagamento',
            'Invoice' => 'Fatura',
            'Report' => 'Relatório',
            'File' => 'Arquivo',
            'System' => 'Sistema',
            'Config' => 'Configuração',
            'Backup' => 'Backup',
            'Maintenance' => 'Manutenção',
            'Notification' => 'Notificação',
            'Email' => 'E-mail',
            'SMS' => 'SMS',
            'Audit' => 'Auditoria',
            'Security' => 'Segurança',
            'Access' => 'Acesso',
            'Activity' => 'Atividade',
            'Alert' => 'Alerta',
            'Auth' => 'Autenticação',
        ];

        return $translations[$targetType] ?? $targetType;
    }

    /**
     * Traduz descrições de auditoria para português
     */
    public static function translateDescription($description): string
    {
        if (!$description) return '';
        
        // Traduções específicas para descrições comuns
        $translations = [
            'Login no sistema' => 'Acesso ao sistema realizado',
            'Logout do sistema' => 'Saída do sistema realizada',
            'Usuário criado' => 'Novo usuário foi cadastrado',
            'Usuário atualizado' => 'Dados do usuário foram modificados',
            'Usuário excluído' => 'Usuário foi removido do sistema',
            'Usuário restaurado' => 'Usuário foi reativado',
            'Permissão alterada' => 'Nível de acesso foi modificado',
            'Certificado gerado' => 'Novo certificado foi criado',
            'Certificado baixado' => 'Certificado foi transferido',
            'Segunda via emitida' => 'Nova cópia do certificado foi gerada',
            'Certificado validado' => 'Certificado foi verificado',
            'Treinamento agendado' => 'Nova data de treinamento foi definida',
            'Treinamento cancelado' => 'Treinamento foi cancelado',
            'Treinamento concluído' => 'Treinamento foi finalizado',
            'Treinamento iniciado' => 'Treinamento começou',
            'Participante registrado' => 'Nova pessoa foi inscrita',
            'Participante removido' => 'Inscrição foi cancelada',
            'Participante atualizado' => 'Dados do participante foram modificados',
            'Participante aprovado' => 'Participante foi aprovado',
            'Empresa criada' => 'Nova empresa foi cadastrada',
            'Empresa atualizada' => 'Dados da empresa foram modificados',
            'Empresa excluída' => 'Empresa foi removida',
            'Empresa ativada' => 'Empresa foi reativada',
            'Empresa desativada' => 'Empresa foi desativada',
            'Contrato criado' => 'Novo contrato foi estabelecido',
            'Contrato atualizado' => 'Termos do contrato foram modificados',
            'Contrato renovado' => 'Contrato foi estendido',
            'Contrato cancelado' => 'Contrato foi encerrado',
            'Pagamento recebido' => 'Valor foi pago',
            'Fatura gerada' => 'Nova fatura foi criada',
            'Reembolso processado' => 'Devolução foi processada',
            'Pagamento falhou' => 'Tentativa de pagamento não foi concluída',
            'Backup criado' => 'Cópia de segurança foi gerada',
            'Modo de manutenção' => 'Sistema entrou em manutenção',
            'Configuração alterada' => 'Configurações foram modificadas',
            'Sistema atualizado' => 'Sistema foi atualizado',
            'Arquivo enviado' => 'Novo arquivo foi carregado',
            'Arquivo baixado' => 'Arquivo foi transferido',
            'Arquivo excluído' => 'Arquivo foi removido',
            'Arquivo compartilhado' => 'Arquivo foi compartilhado',
            'Relatório gerado' => 'Novo relatório foi criado',
            'Relatório exportado' => 'Relatório foi transferido',
            'Relatório agendado' => 'Relatório foi programado',
            'Notificação enviada' => 'Aviso foi enviado',
            'E-mail enviado' => 'Mensagem foi enviada',
            'SMS enviado' => 'Texto foi enviado',
            'Log de auditoria criado' => 'Registro de atividade foi criado',
            'Relatório de auditoria gerado' => 'Relatório de auditoria foi criado',
            'Acesso negado' => 'Tentativa de acesso foi bloqueada',
            'Atividade suspeita detectada' => 'Comportamento anômalo foi identificado',
            'Alerta de segurança' => 'Aviso de segurança foi emitido',
        ];

        return $translations[$description] ?? $description;
    }
}
