<?php

namespace App\Listeners;

use App\Models\AuditLog;
use App\Models\UserSession;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserAuthenticationListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        if ($event instanceof Login) {
            $this->handleLogin($event);
        } elseif ($event instanceof Logout) {
            $this->handleLogout($event);
        } elseif ($event instanceof Failed) {
            $this->handleFailedLogin($event);
        }
    }

    /**
     * Registrar login bem-sucedido
     */
    private function handleLogin(Login $event): void
    {
        $user = $event->user;

        // Registrar no log de auditoria
        AuditLog::log(
            'login_success',
            "Usuário {$user->name} fez login no sistema",
            'User',
            $user->id
        );

        // Registrar sessão do usuário
        UserSession::recordLogin($user->id);
    }

    /**
     * Registrar logout
     */
    private function handleLogout(Logout $event): void
    {
        $user = $event->user;

        if ($user) {
            // Registrar no log de auditoria
            AuditLog::log(
                'logout',
                "Usuário {$user->name} fez logout do sistema",
                'User',
                $user->id
            );

            // Registrar logout na sessão
            UserSession::recordLogout($user->id);
        }
    }

    /**
     * Registrar tentativa de login falhada
     */
    private function handleFailedLogin(Failed $event): void
    {
        $email = isset($event->credentials['email']) ? $event->credentials['email'] : 'N/A';
        
        // Registrar no log de auditoria
        AuditLog::log(
            'login_failed',
            "Tentativa de login falhada para o email: {$email}",
            'Auth',
            null
        );
    }
}
