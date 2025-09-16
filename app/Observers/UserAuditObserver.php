<?php

namespace App\Observers;

use App\Models\User;
use App\Models\AuditLog;
use App\Models\UserSession;

class UserAuditObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        AuditLog::log(
            'user_created',
            "Usuário {$user->name} foi criado",
            'User',
            $user->id,
            null,
            $user->toArray()
        );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $changes = $user->getChanges();
        $original = $user->getOriginal();

        // Filtrar apenas mudanças relevantes
        $relevantChanges = array_intersect_key($changes, array_flip([
            'name', 'email', 'status', 'role_id', 'company_id', 'contract_id'
        ]));

        if (!empty($relevantChanges)) {
            $oldValues = array_intersect_key($original, $relevantChanges);
            
            AuditLog::log(
                'user_updated',
                "Usuário {$user->name} foi atualizado",
                'User',
                $user->id,
                $oldValues,
                $relevantChanges
            );
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        AuditLog::log(
            'user_deleted',
            "Usuário {$user->name} foi excluído",
            'User',
            $user->id,
            $user->toArray(),
            null
        );
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        AuditLog::log(
            'user_restored',
            "Usuário {$user->name} foi restaurado",
            'User',
            $user->id
        );
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        AuditLog::log(
            'user_force_deleted',
            "Usuário {$user->name} foi excluído permanentemente",
            'User',
            $user->id,
            $user->toArray(),
            null
        );
    }
}
