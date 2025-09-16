<?php

namespace Database\Seeders;

use App\Models\GroupPermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
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
    }

}
