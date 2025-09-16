<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserVerifyController;
use Illuminate\Support\Facades\Artisan;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'client',
    'contract_default'

])->group(function () {
    //Dashboard
    Route::view('dashboard/', 'dashboard.index')->name('dashboard');

    Route::view('agenda-semanal/', 'admin.schedule.index')->name('schedule');

    //Cadastros de Usuário
    Route::view('sistema/usuarios', 'client.system.users.index')->name('users');
    Route::view('sistema/usuarios/novo', 'client.system.users.create')->name('users.create');
    Route::view('sistema/usuarios/{id}/editar', 'client.system.users.edit')->name('users.edit');

    Route::view('sistema/usuarios/{id}/contratos', 'client.system.users.contracts.index')->name('users.contracts');

//    //Cadastros do Participante
    Route::view('participantes', 'client.participant.index')->name('client.registration.participant');
    Route::view('participantes/novo', 'client.participant.create')->name('client.registration.participant.create');
    Route::view('participantes/{id}/editar', 'client.participant.edit')->name('client.registration.participant.edit');
    Route::view('participantes/{id}/historico', 'client.participant.historic')->name('client.registration.participant.historic');

    //Movimentos Agenda Empresas
    Route::view('agenda-empresa', 'client.schedule-company.index')->name('client.movement.schedule-company');
    Route::view('agenda-empresa/novo/{schedule_prevat_id?}', 'client.schedule-company.create')->name('client.movement.schedule-company.create');
    Route::view('agenda-empresa/{id}/editar', 'client.schedule-company.edit')->name('client.movement.schedule-company.edit');
    Route::view('agenda-empresa/{id?}/lista', 'client.schedule-company.participants')->name('client.movement.schedule-company.participants');
    Route::view('agenda-empresa/{reference}/vizualizar', 'client.schedule-company.view')->name('client.movement.schedule-company.view');

    //Certificados Clientes
    Route::view('certificados', 'client.certificates.index')->name('client.certificates');
    Route::view('certificados/{id}/participantes', 'client.certificates.participants')->name('client.certificates.participants');

    //Relatórios
    Route::view('relatorios/treinamento-do-participante', 'client.report.participants.index')->name('client.report.participant-training.index');

    //Perfil
    Route::view('meu-perfil', 'profile.index')->name('profile');

    //Empresa
    Route::view('empresa', 'client.company.index')->name('company');

    //Movimentos Evidencias
    // Route::view('movimentacoes/evidencia', 'client.movement.evidence.index')->name('evidence.client');
    // Route::view('movimentacoes/evidencia/novo', 'client.movement.evidence.create')->name('movement.evidence.create');
    // Route::view('movimentacoes/evidencia/{id}/editar', 'client.movement.evidence.edit')->name('movement.evidence.edit');
    // Route::view('movimentacoes/evidencia/{id}/participantes', 'client.movement.evidence.participants')->name('movement.evidence.participants');
    // Route::view('movimentacoes/evidencia/{id}/historicos', 'client.movement.evidence.historic')->name('movement.evidence.historic');

   
});

Route::view('sem-contrato', 'client.alerts.no-contracts')->name('client.alert.no-contracts');
Route::view('escolher-contrato', 'client.alerts.change-contract')->name('client.alert.change-contract');
