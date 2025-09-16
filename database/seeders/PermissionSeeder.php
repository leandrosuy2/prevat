<?php

namespace Database\Seeders;

use App\Models\GroupPermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = GroupPermissions::create(['name' => 'Sistema - Cadastro de Funçoes']);

        $permissions = [
            ['name' => 'add_role', 'label' => 'Adicionar Função'],
            ['name' => 'edit_role', 'label' => 'Editar Função'],
            ['name' => 'view_role', 'label' => 'Visualizar Função'],
            ['name' => 'delete_role', 'label' => 'Deletar Função'],
            ['name' => 'change_permissions', 'label' => 'Modificar Permissões']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }
        $group = GroupPermissions::create(['name' => 'Sistema - Cadastro de Usuários']);

        $permissions = [
            ['name' => 'add_user', 'label' => 'Adicionar Usuário', 'scope' => 'Admin'],
            ['name' => 'edit_user', 'label' => 'Editar Usuário', 'scope' => 'Admin'],
            ['name' => 'view_user', 'label' => 'Visualizar Usuário', 'scope' => 'Admin'],
            ['name' => 'delete_user', 'label' => 'Deletar Usuário', 'scope' => 'Admin']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Cadastro de Empresas']);

        $permissions = [
            ['name' => 'add_company', 'label' => 'Adicionar Empresa'],
            ['name' => 'edit_company', 'label' => 'Editar Empresa'],
            ['name' => 'view_company', 'label' => 'Visualizar Empresa'],
            ['name' => 'delete_company', 'label' => 'Deletar Empresa']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Cadastro de Formação Profissional']);

        $permissions = [
            ['name' => 'add_professional_qualification', 'label' => 'Adicionar Formação Profissional'],
            ['name' => 'edit_professional_qualification', 'label' => 'Editar Formação Profissional'],
            ['name' => 'view_professional_qualification', 'label' => 'Visualizar Formação Profissional'],
            ['name' => 'delete_professional_qualification', 'label' => 'Deletar Formação Profissional']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Profissional']);

        $permissions = [
            ['name' => 'add_professional', 'label' => 'Adicionar Profissional'],
            ['name' => 'edit_professional', 'label' => 'Editar Profissional'],
            ['name' => 'view_professional', 'label' => 'Visualizar Profissional'],
            ['name' => 'delete_professional', 'label' => 'Deletar Profissional']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Salas de Treinamento']);

        $permissions = [
            ['name' => 'add_training_room', 'label' => 'Adicionar Sala de Treinamento'],
            ['name' => 'edit_training_room', 'label' => 'Editar Sala de Treinamento'],
            ['name' => 'view_training_room', 'label' => 'Visualizar Sala de Treinamento'],
            ['name' => 'delete_training_room', 'label' => 'Deletar Sala de Treinamento']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Treinamento']);

        $permissions = [
            ['name' => 'add_training', 'label' => 'Adicionar Treinamento'],
            ['name' => 'edit_training', 'label' => 'Editar Treinamento'],
            ['name' => 'view_training', 'label' => 'Visualizar Treinamento'],
            ['name' => 'delete_training', 'label' => 'Deletar Treinamento']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Local de Treinamento']);

        $permissions = [
            ['name' => 'add_training_location', 'label' => 'Adicionar Local de Treinamento'],
            ['name' => 'edit_training_location', 'label' => 'Editar Local de Treinamento'],
            ['name' => 'view_training_location', 'label' => 'Visualizar Local de Treinamento'],
            ['name' => 'delete_training_location', 'label' => 'Deletar Local de Treinamento']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Municípios']);

        $permissions = [
            ['name' => 'add_country', 'label' => 'Adicionar Município'],
            ['name' => 'edit_country', 'label' => 'Editar Município'],
            ['name' => 'view_country', 'label' => 'Visualizar Município'],
            ['name' => 'delete_country', 'label' => 'Deletar Município']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Carga Horária']);

        $permissions = [
            ['name' => 'add_workload', 'label' => 'Adicionar Carga Horária'],
            ['name' => 'edit_workload', 'label' => 'Editar Carga Horária'],
            ['name' => 'view_workload', 'label' => 'Visualizar Carga Horária'],
            ['name' => 'delete_workload', 'label' => 'Deletar Carga Horária']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Horários']);

        $permissions = [
            ['name' => 'add_time', 'label' => 'Adicionar Horários'],
            ['name' => 'edit_time', 'label' => 'Editar Horários'],
            ['name' => 'view_time', 'label' => 'Visualizar Horários'],
            ['name' => 'delete_time', 'label' => 'Deletar Horários']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Cadastros - Função do Participante']);

        $permissions = [
            ['name' => 'add_participant_role', 'label' => 'Adicionar Função do Participante'],
            ['name' => 'edit_participant_role', 'label' => 'Editar Função do Participante'],
            ['name' => 'view_participant_role', 'label' => 'Visualizar Função do Participante'],
            ['name' => 'delete_participant_role', 'label' => 'Deletar Função do Participante']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }


        $group = GroupPermissions::create(['name' => 'Cadastros - ParticipanteS']);

        $permissions = [
            ['name' => 'add_participant', 'label' => 'Adicionar Participante'],
            ['name' => 'edit_participant', 'label' => 'Editar Participante'],
            ['name' => 'view_participant', 'label' => 'Visualizar Participante'],
            ['name' => 'delete_participant', 'label' => 'Deletar Participante']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }
    }
}
