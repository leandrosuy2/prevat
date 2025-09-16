<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserVerifyController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'contract_default'

])->group(function () {
    //Dashboard
    Route::view('dashboard/', 'dashboard.index')->name('dashboard');

    Route::view('agenda-semanal/', 'admin.schedule.index')->name('schedule');

    //Cadastros de Usuário
    Route::view('sistema/usuarios', 'contractor.system.users.index')->name('users');
    Route::view('sistema/usuarios/novo', 'contractor.system.users.create')->name('users.create');
    Route::view('sistema/usuarios/{id}/editar', 'contractor.system.users.edit')->name('users.edit');

    //Movimentos Agenda Empresas
    Route::view('agenda-empresas', 'contractor.schedule-company.index')->name('contractor.schedule-company');
    Route::view('agenda-empresas/{reference}/lista', 'contractor.schedule-company.participants')->name('contractor.schedule-company.participants');
    Route::view('agenda-empresas/{reference}/vizualizar', 'contractor.schedule-company.view')->name('contractor.schedule-company.view');

    //Relatórios
    Route::view('relatorios/participantes', 'contractor.report.participants.index')->name('contractor.participant-training.index');

    //Perfil
    Route::view('meu-perfil', 'profile.index')->name('profile');

    //Empresa
    Route::view('empresa', 'client.company.index')->name('company');

    // Rotas de cadastros liberadas para todos os contratantes
    Route::view('cadastros/contratos', 'admin.registration.contractors.index')->name('registration.contractors');
    Route::view('cadastros/contratos/novo', 'admin.registration.contractors.create')->name('registration.contractors.create');
    Route::view('cadastros/contratos/{id}/editar', 'admin.registration.contractors.edit')->name('registration.contractors.edit');
    Route::view('cadastros/empresa', 'admin.registration.company.index')->name('registration.company');
    Route::view('cadastros/empresa/novo', 'admin.registration.company.create')->name('registration.company.create');
    Route::view('cadastros/empresa/{id}/editar', 'admin.registration.company.edit')->name('registration.company.edit');
    Route::view('cadastros/empresa/{id}/contratos', 'admin.registration.company.contracts.index')->name('registration.company.contract');
    // Adicione outras rotas de cadastro que quiser liberar

    // Rotas de movimentações/evidência liberadas para todos os contratantes
    Route::view('movimentacoes/evidencia', 'admin.movement.evidence.index')->name('movement.evidence');
    Route::view('movimentacoes/evidencia/novo', 'admin.movement.evidence.create')->name('movement.evidence.create');
    Route::view('movimentacoes/evidencia/{id}/editar', 'admin.movement.evidence.edit')->name('movement.evidence.edit');
    Route::view('movimentacoes/evidencia/{id}/participantes', 'admin.movement.evidence.participants')->name('movement.evidence.participants');
    Route::view('movimentacoes/evidencia/{id}/historicos', 'admin.movement.evidence.historic')->name('movement.evidence.historic');
});

