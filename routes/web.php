<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportsController;
use App\Http\Controllers\NFeController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\SpedController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::any('/', function(){
	return redirect() -> route('dashboard');
});

Route::any('/dashboard', [HomeController::class, 'index']) -> name('dashboard');
Route::any('/home', [HomeController::class, 'index']) -> name('home');

Route::post('/api/shell', [HomeController::class, 'shell']);
Route::post('/api/log', [HomeController::class, 'log']);

// Imports
Route::any('/imports', [ImportsController::class, 'index']) -> name('imports');
Route::post('/imports', [ImportsController::class, 'import']);

// NFe
Route::get('/reports/nfe', [NFeController::class, 'index']) -> name('reports.nfe');
Route::get('/reports/nfe/{chave_nfe}', [NFeController::class, 'danfe']) -> name('reports.nfe.danfe');
Route::get('/reports/nfe/pdf/{xml}', [NFeController::class, 'danfe']) -> name('reports.sped.nao_escrituradas.baixar_pdf');
Route::get('/reports/nfe/xls/{xml}', [NFeController::class, 'danfe']) -> name('reports.sped.nao_escrituradas.baixar_xls');

// Fonecedores
Route::get('/reports/fornecedores', [FornecedoresController::class, 'index'])->name('reports.fornecedores');
Route::get('/reports/fornecedores/{emitente}', [FornecedoresController::class, 'notas_fiscais']) -> name('reports.fornecedores.notas_fiscais');
Route::get('/reports/fornecedores/{emitente}/{chave_nfe}', [FornecedoresController::class, 'danfe']) -> name('reports.fornecedores.nfe');

// Sped Fiscal
Route::get('/reports/spedfiscal', [SpedController::class, 'index']) -> name('reports.sped');
Route::get('/reports/spedfiscal/nfe/{escriturada}/{cnpj}/{data_inicio}/{data_fim}', [NFeController::class, 'sped_fiscal']) -> name('reports.sped.notas.nao-escrituradas');
