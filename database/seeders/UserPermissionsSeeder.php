<?php

namespace Database\Seeders;

use App\Models\GroupPermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
