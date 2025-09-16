<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserVerifyController;
use Illuminate\Support\Facades\Artisan;

Route::view('/', 'site.home.index')->name('home');
Route::view('sobre', 'site.about.index')->name('about');

Route::view('/cursos/', 'site.courses.index')->name('courses.list');
Route::view('/nossos-cursos/lista/{id?}', 'site.courses.list')->name('courses');
Route::view('/nossos-cursos/{id}/vizualizar', 'site.courses.view')->name('courses.view');

Route::view('/consultoria', 'site.consultancy.index')->name('consultancy');
Route::view('/consultoria/detalhes', 'site.consultancy.view')->name('consultancy.view');
Route::view('/blog', 'site.blog.index')->name('blog');
Route::view('/blog/{id}/vizualizar', 'site.blog.view')->name('blog.view');
Route::view('/contato', 'site.contact.index')->name('contact');
Route::view('/cadastro', 'site.register.index')->name('register');
Route::view('/obrigado', 'site.thanks.index')->name('thanks');

Route::view('/termos-de-adesao', 'site.terms.index')->name('terms');
Route::view('/politica-de-privacidade', 'site.policy.index')->name('policy');
Route::view('/perguntas-frequentes', 'site.questions.index')->name('questions');

Route::view('/consulta-certificado/{reference}', 'site.check_certificate.index')->name('check_certificate');

Route::view('/resetar-senha', 'auth.reset-password')->middleware('guest')->name('password.reset');
Route::get('/verificar-conta/{token}', [UserVerifyController::class, 'verifyAccount'])->name('user.verify');

Route::view('meu-perfil', 'profile.index')->name('profile');


//Route::get('importar-clientes', [\App\Http\Controllers\ImportController::class, 'importCompanies']);
//Route::get('importar-enderecos', [\App\Http\Controllers\ImportController::class, 'importAddress']);
//Route::get('importar-usuarios', [\App\Http\Controllers\ImportController::class, 'addUsers']);
//Route::get('importar-agempresa', [\App\Http\Controllers\ImportController::class, 'addScheduleCompany']);
//Route::get('importar-participantes', [\App\Http\Controllers\ImportController::class, 'addParticipantsBySchedule']);
//Route::get('importar-treinamento', [\App\Http\Controllers\ImportController::class, 'trainingParticipants']);
//Route::get('separar-nome', [\App\Http\Controllers\ImportController::class, 'separatecontractParticipants']);
//Route::get('colocar-nome', [\App\Http\Controllers\ImportController::class, 'addNameCompany']);
//Route::get('adicionar-categoria', [\App\Http\Controllers\ImportController::class, 'addCategories']);
//Route::get('adicionar-treinamento', [\App\Http\Controllers\ImportController::class, 'addCategoryTraining']);
//Route::get('adicionar-referencia-prevat', [\App\Http\Controllers\ImportController::class, 'addReferencesSchedulePrevat']);
//Route::get('adicionar-referencia-company', [\App\Http\Controllers\ImportController::class, 'addReferencesScheduleCompany']);
//Route::get('adicionar-referencia-evidencia', [\App\Http\Controllers\ImportController::class, 'addReferencesScheduleCompany']);
//Route::get('changeVacancies', [\App\Http\Controllers\ImportController::class, 'changeVacancies']);
//Route::get('change-contracts', [\App\Http\Controllers\ImportController::class, 'changeContractsDefault']);
//Route::get('add-contracts', [\App\Http\Controllers\ImportController::class, 'addContrats']);
//Route::get('change-vacancies', [\App\Http\Controllers\ImportController::class, 'changeVacanciesNew']);
Route::get('add-prices', [\App\Http\Controllers\ImportController::class, 'addPrices']);

//Route::

//Route::middleware(['route_admin'])->group(base_path('routes/admin.php'));
//Route::middleware(['route_client'])->group(base_path('routes/client.php'));
