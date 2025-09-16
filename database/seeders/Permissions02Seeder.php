<?php

namespace Database\Seeders;

use App\Models\GroupPermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Permissions02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = GroupPermissions::create(['name' => 'Movimentações - Gestão Agenda Prevat']);

        $permissions = [
            ['name' => 'add_schedule_prevat', 'label' => 'Adicionar Agenda Prevat'],
            ['name' => 'edit_schedule_prevat', 'label' => 'Editar Agenda Prevat'],
            ['name' => 'view_schedule_prevat', 'label' => 'Visualizar Agenda Prevat'],
            ['name' => 'delete_schedule_prevat', 'label' => 'Deletar Agenda Prevat'],
            ['name' => 'add_schedule_company_schedule_prevat', 'label' => 'Cadastrar Agenda Empresa'],
            ['name' => 'view_participants_schedule_prevat', 'label' => 'Vizualizar participantes'],
            ['name' => 'delete_participants_schedule_prevat', 'label' => 'Deletar participante'],
            ['name' => 'download_pdf_schedule_prevat', 'label' => 'Baixar conteúdo programático'],
            ['name' => 'print_pdf_schedule_prevat', 'label' => 'Imprimir conteúdo programático'],
            ['name' => 'change_status_schedule_prevat', 'label' => 'Alterar Status'],
            ['name' => 'change_event_schedule_prevat', 'label' => 'Alterar tipo de evento'],

        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Movimentações - Gestão Agenda Empresa']);

        $permissions = [
            ['name' => 'add_schedule_company', 'label' => 'Adicionar Agenda Empresa'],
            ['name' => 'edit_schedule_company', 'label' => 'Editar Agenda Empresa'],
            ['name' => 'view_schedule_company', 'label' => 'Visualizar Agenda Empresa'],
            ['name' => 'delete_schedule_company', 'label' => 'Deletar Agenda Empresa'],
            ['name' => 'view_participants_schedule_company', 'label' => 'Vizualizar Participantes da Agenda'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Movimentações - Gestão Agenda Treinamento do Participante']);

        $permissions = [
            ['name' => 'add_training_participant', 'label' => 'Adicionar Treinamento do Participante'],
            ['name' => 'add_training_participant_private', 'label' => 'Adicionar Treinamento do Participante Privado'],
            ['name' => 'edit_training_participant', 'label' => 'Editar Treinamento do Participante'],
            ['name' => 'view_training_participant', 'label' => 'Visualizar Treinamento do Participante'],
            ['name' => 'delete_training_participant', 'label' => 'Deletar Treinamento do Participante'],
            ['name' => 'view_participants_training', 'label' => 'Vizualizar Participantes do Treinamento'],
            ['name' => 'view_training_certificates', 'label' => 'Vizualizar Certificados do Treinamento'],
            ['name' => 'view_training_professionals', 'label' => 'Vizualizar Profissionais do Treinamento'],
            ['name' => 'change_status_training_participant', 'label' => 'Vizualizar Profissionais do Treinamento'],
            ['name' => 'download_certificate_pdf', 'label' => 'Baixar PDF Certificado'],
            ['name' => 'print_certificate_pdf', 'label' => 'Imprimir PDF Certificado'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'group_permissions_id' => $group->id,
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        $group = GroupPermissions::create(['name' => 'Movimentações - Gestão de Evidências']);

        $permissions = [
            ['name' => 'add_evidence', 'label' => 'Adicionar Evidência'],
            ['name' => 'edit_evidence', 'label' => 'Editar Evidência'],
            ['name' => 'view_evidence', 'label' => 'Visualizar Evidência'],
            ['name' => 'delete_evidence', 'label' => 'Deletar Evidência'],
            ['name' => 'view_participants_evidence', 'label' => 'Vizualizar Participantes'],
            ['name' => 'download_evidence', 'label' => 'Baixar Arquivo'],
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
