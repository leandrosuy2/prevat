<?php

namespace Database\Seeders;

use App\Models\GroupPermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SitePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Cadastros Categoria do Blog
        $group = GroupPermissions::create(['name' => 'Site - Cadastro de Categorias do Blog']);

        $permissions = [
            ['name' => 'add_category_blog', 'label' => 'Adicionar Categoria', 'scope' => 'Admin'],
            ['name' => 'edit_category_blog', 'label' => 'Editar Categoria', 'scope' => 'Admin'],
            ['name' => 'view_category_blog', 'label' => 'Visualizar Categoria', 'scope' => 'Admin'],
            ['name' => 'delete_category_blog', 'label' => 'Deletar Categoria', 'scope' => 'Admin']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        //Cadastros do Blog
        $group = GroupPermissions::create(['name' => 'Site - Cadastro do Blog']);

        $permissions = [
            ['name' => 'add_blog', 'label' => 'Adicionar Blog', 'scope' => 'Admin'],
            ['name' => 'edit_blog', 'label' => 'Editar Blog', 'scope' => 'Admin'],
            ['name' => 'view_blog', 'label' => 'Visualizar Blog', 'scope' => 'Admin'],
            ['name' => 'delete_blog', 'label' => 'Deletar Blog', 'scope' => 'Admin']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        //Cadastros Categoria de Produtos
        $group = GroupPermissions::create(['name' => 'Site - Cadastro de Categorias de Produto']);

        $permissions = [
            ['name' => 'add_category_product', 'label' => 'Adicionar Categoria', 'scope' => 'Admin'],
            ['name' => 'edit_category_product', 'label' => 'Editar Categoria', 'scope' => 'Admin'],
            ['name' => 'view_category_product', 'label' => 'Visualizar Categoria', 'scope' => 'Admin'],
            ['name' => 'delete_category_product', 'label' => 'Deletar Categoria', 'scope' => 'Admin']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        //Cadastros do Produto
        $group = GroupPermissions::create(['name' => 'Site - Cadastro de Produtos']);

        $permissions = [
            ['name' => 'add_product', 'label' => 'Adicionar Produto', 'scope' => 'Admin'],
            ['name' => 'edit_product', 'label' => 'Editar Produto', 'scope' => 'Admin'],
            ['name' => 'view_product', 'label' => 'Visualizar Produto', 'scope' => 'Admin'],
            ['name' => 'delete_product', 'label' => 'Deletar Produto', 'scope' => 'Admin']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        //Cadastros dos Contatos Site
        $group = GroupPermissions::create(['name' => 'Site - Cadastro de Contatos']);

        $permissions = [
            ['name' => 'add_contact', 'label' => 'Adicionar Contatos', 'scope' => 'Admin'],
            ['name' => 'edit_contact', 'label' => 'Editar Contatos', 'scope' => 'Admin'],
            ['name' => 'view_contact', 'label' => 'Visualizar Contatos', 'scope' => 'Admin'],
            ['name' => 'delete_contact', 'label' => 'Deletar Contatos', 'scope' => 'Admin']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        //Cadastros de Consultorias
        $group = GroupPermissions::create(['name' => 'Site - Cadastro de Consultorias']);

        $permissions = [
            ['name' => 'add_consultancy', 'label' => 'Adicionar Consultoria', 'scope' => 'Admin'],
            ['name' => 'edit_consultancy', 'label' => 'Editar Consultoria', 'scope' => 'Admin'],
            ['name' => 'view_consultancy', 'label' => 'Visualizar Consultoria', 'scope' => 'Admin'],
            ['name' => 'delete_consultancy', 'label' => 'Deletar Consultoria', 'scope' => 'Admin']
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        //Cadastros de Consultorias
        $group = GroupPermissions::create(['name' => 'Site - Informações Gerais']);

        $permissions = [
            ['name' => 'add_information', 'label' => 'Adicionar Informações', 'scope' => 'Admin'],
            ['name' => 'edit_information', 'label' => 'Editar Informações', 'scope' => 'Admin'],
            ['name' => 'view_information', 'label' => 'Visualizar Informações', 'scope' => 'Admin'],
            ['name' => 'delete_information', 'label' => 'Deletar Informações', 'scope' => 'Admin']
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
