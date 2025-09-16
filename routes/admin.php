<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserVerifyController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\DashboardExportController;

//Route::view('/login', 'admin.auth.login')->middleware('guest')->name('login');
//Route::view('/', 'admin.auth.login')->middleware('guest');
//Route::view('/recuperar-senha', 'admin.auth.forgot-password')->middleware('guest')->name('password.request');
//Route::view('/resetar-senha', 'admin.auth.reset-password')->middleware('guest')->name('password.reset');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin'
])->group(function () {
    Route::view('dashboard/', 'dashboard.index')->name('dashboard');
    Route::get('dashboard/exportar-dados', [DashboardExportController::class, 'export'])->name('dashboard.exportar-dados');
    Route::view('agenda-semanal/', 'admin.schedule.index')->name('schedule');

    //Cadastros de Usuário
    Route::view('sistema/usuarios', 'admin.system.users.index')->name('users');
    Route::view('sistema/usuarios/novo', 'admin.system.users.create')->name('users.create');
    Route::view('sistema/usuarios/{id}/editar', 'admin.system.users.edit')->name('users.edit');


    //Cadastro de Permissões
    Route::view('sistema/permissoes', 'admin.system.permissions.index')->name('permissions');
    Route::view('sistema/permissoes/novo', 'admin.system.permissions.create')->name('permissions.create');
    Route::view('sistema/permissoes/{id}/editar', 'admin.system.permissions.edit')->name('permissions.edit');
    Route::view('sistema/permissoes/{id}/roles', 'admin.system.permissions.roles')->name('permissions.role');

    //Cadastros Empresa
    Route::view('cadastros/contratos', 'admin.registration.contractors.index')->name('registration.contractors');
    Route::view('cadastros/contratos/novo', 'admin.registration.contractors.create')->name('registration.contractors.create');
    Route::view('cadastros/contratos/{id}/editar', 'admin.registration.contractors.edit')->name('registration.contractors.edit');

    //Cadastros Empresa
    Route::view('cadastros/empresa', 'admin.registration.company.index')->name('registration.company');
    Route::view('cadastros/empresa/novo', 'admin.registration.company.create')->name('registration.company.create');
    Route::view('cadastros/empresa/{id}/editar', 'admin.registration.company.edit')->name('registration.company.edit');
    Route::view('cadastros/empresa/{id}/contratos', 'admin.registration.company.contracts.index')->name('registration.company.contract');

    //Cadastros do Participante
    Route::view('cadastros/participantes', 'admin.registration.participant.index')->name('registration.participant');
    Route::view('cadastros/participantes/novo', 'admin.registration.participant.create')->name('registration.participant.create');
    Route::view('cadastros/participantes/{id}/editar', 'admin.registration.participant.edit')->name('registration.participant.edit');
    Route::view('cadastros/participantes/{id}/historico', 'admin.registration.participant.historic')->name('registration.participant.historic');

    //Cadastros função do Participante
    Route::view('cadastros/funcao-do-participante', 'admin.registration.participant-role.index')->name('registration.participant-role');
    Route::view('cadastros/funcao-do-participante/novo', 'admin.registration.participant-role.create')->name('registration.participant-role.create');
    Route::view('cadastros/funcao-do-participante/{id}/editar', 'admin.registration.participant-role.edit')->name('registration.participant-role.edit');

    //Cadastros Formação Profissional
    Route::view('profissionais/formacao-profissional', 'admin.registration.professional-qualification.index')->name('registration.professional-qualification');
    Route::view('profissionais/formacao-profissional/novo', 'admin.registration.professional-qualification.create')->name('registration.professional-qualification.create');
    Route::view('profissionais/formacao-profissional/{id}/editar', 'admin.registration.professional-qualification.edit')->name('registration.professional-qualification.edit');

    //Cadastros Profissional
    Route::view('profissionais/profissional', 'admin.registration.professional.index')->name('registration.professional');
    Route::view('profissionais/profissional/novo', 'admin.registration.professional.create')->name('registration.professional.create');
    Route::view('profissionais/profissional/{id}/editar', 'admin.registration.professional.edit')->name('registration.professional.edit');

    //Cadastros Responsável Tecnico
    Route::view('profissionais/responsavel-tecnico', 'admin.registration.technical-manager.index')->name('registration.technical-manager');
    Route::view('profissionais/responsavel-tecnico/novo', 'admin.registration.technical-manager.create')->name('registration.technical-manager.create');
    Route::view('profissionais/responsavel-tecnico/{id}/editar', 'admin.registration.technical-manager.edit')->name('registration.technical-manager.edit');

    //Cadastros Salas de Treinamento
    Route::view('treinamentos/salas-treinamento', 'admin.registration.training-room.index')->name('registration.training-room');
    Route::view('treinamentos/salas-treinamento/novo', 'admin.registration.training-room.create')->name('registration.training-room.create');
    Route::view('treinamentos/salas-treinamento/{id}/editar', 'admin.registration.training-room.edit')->name('registration.training-room.edit');

    //Cadastros Categorias de Treinamento
    Route::view('treinamentos/categorias', 'admin.registration.training-category.index')->name('registration.training-category');
    Route::view('treinamentos/categorias/novo', 'admin.registration.training-category.create')->name('registration.training-category.create');
    Route::view('treinamentos/categorias/{id}/editar', 'admin.registration.training-category.edit')->name('registration.training-category.edit');


    //Cadastros Treinamento
    Route::view('treinamentos/treinamentos', 'admin.registration.training.index')->name('registration.training');
    Route::view('treinamentos/treinamentos/novo', 'admin.registration.training.create')->name('registration.training.create');
    Route::view('treinamentos/treinamentos/{id}/editar', 'admin.registration.training.edit')->name('registration.training.edit');

    //Cadastros Locais de Treinamento
    Route::view('treinamentos/locais-treinamento', 'admin.registration.training-location.index')->name('registration.training-location');
    Route::view('treinamentos/locais-treinamento/novo', 'admin.registration.training-location.create')->name('registration.training-location.create');
    Route::view('treinamentos/locais-treinamento/{id}/editar', 'admin.registration.training-location.edit')->name('registration.training-location.edit');

    //Cadastros Municipios
    Route::view('treinamentos/municipios', 'admin.registration.countries.index')->name('registration.countries');
    Route::view('treinamentos/municipios/novo', 'admin.registration.countries.create')->name('registration.countries.create');
    Route::view('treinamentos/municipios/{id}/editar', 'admin.registration.countries.edit')->name('registration.countries.edit');

    //Cadastros Carga-Horaria
    Route::view('treinamentos/carga-horaria', 'admin.registration.workload.index')->name('registration.workload');
    Route::view('treinamentos/carga-horaria/novo', 'admin.registration.workload.create')->name('registration.workload.create');
    Route::view('treinamentos/carga-horaria/{id}/editar', 'admin.registration.workload.edit')->name('registration.workload.edit');

    //Cadastros Horarios
    Route::view('treinamentos/horarios', 'admin.registration.time.index')->name('registration.time');
    Route::view('treinamentos/horarios/novo', 'admin.registration.time.create')->name('registration.time.create');
    Route::view('treinamentos/horarios/{id}/editar', 'admin.registration.time.edit')->name('registration.time.edit');

    //Cadastros Turmas
    Route::view('treinamentos/turmas', 'admin.registration.team.index')->name('registration.team');
    Route::view('treinamentos/turmas/novo', 'admin.registration.team.create')->name('registration.team.create');
    Route::view('treinamentos/turmas/{id}/editar', 'admin.registration.team.edit')->name('registration.team.edit');

    //Financeiro
    Route::view('financeiro/lancamentos', 'admin.financial.releases.index')->name('financial.releases');
    Route::view('financeiro/{reference}/lista', 'admin.financial.releases.list')->name('financial.releases.list');

    //Ordem de Serviço
    Route::view('financeiro/ordem-de-servico', 'admin.financial.service-order.index')->name('financial.service-order');
    Route::view('financeiro/ordem-de-servico/novo', 'admin.financial.service-order.create')->name('financial.service-order.create');
    Route::view('financeiro/ordem-de-servico/{id}/editar', 'admin.financial.service-order.edit')->name('financial.service-order.edit');
    Route::view('financeiro/ordem-de-servico/{id}/vizualizar', 'admin.financial.service-order.view.index')->name('financial.service-order.view');
    Route::view('financeiro/ordem-de-servico/{id}/pdf', 'admin.financial.service-order.pdf.index')->name('financial.service-order.pdf');

    //Tipo de Pagamentos
    Route::view('financeiro/tipos-de-pagamento', 'admin.financial.payment-method.index')->name('financial.payment-method');
    Route::view('financeiro/tipos-de-pagamento/novo', 'admin.financial.payment-method.create')->name('financial.payment-method.create');
    Route::view('financeiro/tipos-de-pagamento/{id}/editar', 'admin.financial.payment-method.edit')->name('financial.payment-method.edit');

    //Movimentos Evidencias
    Route::view('movimentacoes/evidencia', 'admin.movement.evidence.index')->name('movement.evidence');
    Route::view('movimentacoes/evidencia/novo', 'admin.movement.evidence.create')->name('movement.evidence.create');
    Route::view('movimentacoes/evidencia/{id}/editar', 'admin.movement.evidence.edit')->name('movement.evidence.edit');
    Route::view('movimentacoes/evidencia/{id}/participantes', 'admin.movement.evidence.participants')->name('movement.evidence.participants');
    Route::view('movimentacoes/evidencia/{id}/historicos', 'admin.movement.evidence.historic')->name('movement.evidence.historic');

    //Movimentos Agenda Prevat
    Route::view('movimentacoes/agenda-prevat', 'admin.movement.schedule-prevat.index')->name('movement.schedule-prevat');
    Route::view('movimentacoes/agenda-prevat/novo', 'admin.movement.schedule-prevat.create')->name('movement.schedule-prevat.create');
    Route::view('movimentacoes/agenda-prevat/{id}/editar', 'admin.movement.schedule-prevat.edit')->name('movement.schedule-prevat.edit');
    Route::view('movimentacoes/agenda-prevat/{id}/lista', 'admin.movement.schedule-prevat.participants')->name('movement.schedule-prevat.participants');
    Route::view('movimentacoes/agenda-prevat/{id}/impressao', 'admin.movement.schedule-prevat.printer')->name('movement.schedule-prevat.printer');

    //Movimentos Agenda Empresas
    Route::view('movimentacoes/agenda-empresa', 'admin.movement.schedule-company.index')->name('movement.schedule-company');
    Route::view('movimentacoes/agenda-empresa/novo/{schedule_prevat_id?}', 'admin.movement.schedule-company.create')->name('movement.schedule-company.create');
    Route::view('movimentacoes/agenda-empresa/{id}/editar', 'admin.movement.schedule-company.edit')->name('movement.schedule-company.edit');
    Route::view('movimentacoes/agenda-empresa/{id}/lista', 'admin.movement.schedule-company.participants')->name('movement.schedule-company.participants');

    //Protocolo de Retirada
    Route::view('movimentacoes/protocolo-retirada', 'admin.movement.withdrawal-protocol.index')->name('movement.withdrawal-protocol');
    Route::view('movimentacoes/protocolo-retirada/novo', 'admin.movement.withdrawal-protocol.create')->name('movement.withdrawal-protocol.create');
    Route::view('movimentacoes/protocolo-retirada/{id}/editar', 'admin.movement.withdrawal-protocol.edit')->name('movement.withdrawal-protocol.edit');

    //Treinamento do participante
    Route::view('movimentacoes/treinamento-participante', 'admin.movement.participant-training.index')->name('movement.participant-training');
    Route::view('movimentacoes/treinamento-participante/novo', 'admin.movement.participant-training.create')->name('movement.participant-training.create');
    Route::view('movimentacoes/treinamento-participante/privado/novo', 'admin.movement.participant-training.private.create')->name('movement.participant-training.private.create');
    Route::view('movimentacoes/treinamento-participante/{id}/editar', 'admin.movement.participant-training.edit')->name('movement.participant-training.edit');
    Route::view('movimentacoes/treinamento-participante/{id}/participants', 'admin.movement.participant-training.participants')->name('movement.participant-training.participants');
    Route::view('movimentacoes/treinamento-participante/{id}/profissionais', 'admin.movement.participant-training.professionals')->name('movement.participant-training.professionals');
    Route::view('movimentacoes/treinamento-participante/{id}/certificados', 'admin.movement.participant-training.certificates')->name('movement.participant-training.certificates');
    Route::view('movimentacoes/treinamento-participante/{id}/imprimir', 'admin.movement.participant-training.printer')->name('movement.participant-training.printer');
    Route::view('movimentacoes/treinamento-participante/{id}/conteudo', 'admin.movement.participant-training.programmatic')->name('movement.participant-training.programmatic');
    Route::view('movimentacoes/treinamento-participante/{id}/conteudo/imprimir', 'admin.movement.participant-training.programmatic-printer')->name('movement.participant-training.programmatic-printer');

    //Relatórios
    Route::view('relatorios/treinamentos-do-participante', 'admin.report.participant-training.index')->name('report.participant-training.index');
    Route::view('relatorios/empresas', 'admin.report.companies.index')->name('report.companies.index');
    Route::view('relatorios/treinamentos-empresas', 'admin.report.trainings.index')->name('report.trainings.index');
    Route::view('relatorios/relatorio-mensal', 'admin.reports.monthly-report.index')->name('report.monthly-report.index');

    //Auditoria
    Route::view('auditoria', 'admin.audit.index')->name('audit.index');

    //Segurança do Trabalho
    Route::view('seguranca-do-trabalho/inspecoes', 'admin.work-safety.inspection.index')->name('work-safety.inspection.index');
    Route::view('seguranca-do-trabalho/inspecoes/novo', 'admin.work-safety.inspection.create')->name('work-safety.inspection.create');
    Route::view('seguranca-do-trabalho/inspecoes/{id}/editar', 'admin.work-safety.inspection.edit')->name('work-safety.inspection.edit');
    Route::view('seguranca-do-trabalho/inspecoes/{id}/lista', 'admin.work-safety.inspection.list')->name('work-safety.inspection.list');

    //Historico
    Route::view('movimentacoes/historico', 'admin.movement.historic.index')->name('movement.historic');

    //Site Cadastro de Banners
    Route::view('site/banners', 'admin.manage.banners.index')->name('manage.banners');
    Route::view('site/banners/novo', 'admin.manage.banners.create')->name('manage.banners.create');
    Route::view('site/banners/{id}/editar', 'admin.manage.banners.edit')->name('manage.banners.edit');

    //Site Cadastro de Categorias de Blog
    Route::view('site/blog-categorias', 'admin.manage.blog-categories.index')->name('manage.blog-categories.blog');
    Route::view('site/blog-categorias/novo', 'admin.manage.blog-categories.create')->name('manage.blog-categories.create');
    Route::view('site/blog-categorias/{id}/editar', 'admin.manage.blog-categories.edit')->name('manage.blog-categories.edit');

    //Site Cadastro de Blog
    Route::view('site/blog', 'admin.manage.blog.index')->name('manage.blog');
    Route::view('site/blog/novo', 'admin.manage.blog.create')->name('manage.blog.create');
    Route::view('site/blog/{id}/editar', 'admin.manage.blog.edit')->name('manage.blog.edit');

    //Site Cadastro de Categorias de Produto
    Route::view('site/produto-categorias', 'admin.manage.product-categories.index')->name('manage.product-categories.index');
    Route::view('site/produto-categorias/novo', 'admin.manage.product-categories.create')->name('manage.product-categories.create');
    Route::view('site/produto-categorias/{id}/editar', 'admin.manage.product-categories.edit')->name('manage.product-categories.edit');

    //Site Cadastro de Produto
    Route::view('site/produtos', 'admin.manage.product.index')->name('manage.product.index');
    Route::view('site/produtos/novo', 'admin.manage.product.create')->name('manage.product.create');
    Route::view('site/produtos/{id}/editar', 'admin.manage.product.edit')->name('manage.product.edit');
    Route::view('site/produtos/{id}/imagens', 'admin.manage.product.images.index')->name('manage.product.images');

    //Site Cadastro de Consultorias
    Route::view('site/consultoria', 'admin.manage.consultancy.index')->name('manage.consultancy');
    Route::view('site/consultoria/novo', 'admin.manage.consultancy.create')->name('manage.consultancy.create');
    Route::view('site/consultoria/{id}/editar', 'admin.manage.consultancy.edit')->name('manage.consultancy.edit');

    //Site Cadastro de Consultorias
    Route::view('site/contatos', 'admin.manage.contact.index')->name('manage.contact');
    Route::view('site/contatos/novo', 'admin.manage.contact.create')->name('manage.contact.create');
    Route::view('site/contatos/{id}/editar', 'admin.manage.contact.edit')->name('manage.contact.edit');

    //Site Cadastro de Infomações Gerais
    Route::view('site/informacoes', 'admin.manage.information.index')->name('manage.information');
    Route::view('site/informacoes/novo', 'admin.manage.information.create')->name('manage.information.create');
    Route::view('site/informacoes/{id}/editar', 'admin.manage.information.edit')->name('manage.information.edit');

    //Perfil
    Route::view('meu-perfil', 'profile.index')->name('profile');

    //Empresa
    Route::view('empresa', 'client.company.index')->name('company');
});
