<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ImportsController;
use App\Http\Controllers\NFeController;
use App\Http\Controllers\SpedController;
use App\Http\Controllers\FornecedoresController;

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

// =====================================
// * Rotas padrão do sistema
// =====================================
Route::any('/', [HomeController::class, 'index']);
Route::any('/home', [HomeController::class, 'index']) -> name('home');

// Route::post('api/execute_sh', [ApiController::class, 'index']);

// =====================================
// * Importações de arquivos
// =====================================

// Importar Arquivo
Route::any('/imports', [ImportsController::class, 'index']) -> name('imports');
Route::post('/imports', [ImportsController::class, 'import']);

// =====================================
// * Relatórios
// =====================================

// NFe
Route::get('/reports/nfe', [NfeController::class, 'index']) -> name('reports.nfe');
Route::get('/reports/nfe/{chNFe?}', [NfeController::class, 'details_nfe']) -> name('reports.nfe.view');

// Fornecedores
Route::get('/reports/fornecedores', [FornecedoresController::class, 'index'])->name('reports.fornecedores');
Route::get('/reports/fornecedores/{cnpj}', [FornecedoresController::class, 'show'])->name('reports.fornecedores.cnpj');
Route::get('/reports/fornecedores/{cnpj}/{nfe}', [FornecedoresController::class, 'show_nfe'])->name('reports.fornecedores.nfe');
Route::get('/reports/fornecedores/xls/{cnpj}/{nfe}', [FornecedoresController::class, 'baixar_xls']) -> name('reports.fornecedores.baixar_xls');

// Sped Fiscal
Route::get('/reports/sped', [SpedController::class, 'index']) -> name('reports.sped');
Route::get('/reports/sped/{cnpj}/{data_inicio}-{data_fim}', [SpedController::class, 'fornecedores']) -> name('reports.sped.fornecedores');
Route::get('/reports/sped/{cnpj}/{data_inicio}-{data_fim}/{emitente}', [SpedController::class, 'nao_escrituradas']) -> name('reports.sped.fornecedores');

Route::get('/reports/sped/nao_escrituradas/{cnpj}/{data_inicio}-{data_fim}/{xml}', [SpedController::class, 'show_nfe']) -> name('reports.sped.nao_escrituradas');
Route::get('/reports/sped/nao_escrituradas/xls/{xml}', [SpedController::class, 'baixar_xls']) -> name('reports.sped.nao_escrituradas.baixar_xls');
Route::get('/reports/sped/nao_escrituradas/pdf/{xml}', [SpedController::class, 'baixar_pdf']) -> name('reports.sped.nao_escrituradas.pdf');

Route::get('/reports/sped/nao_escrituradas/{cnpj?}/{data_inicio?}-{data_fim?}', [SpedController::class, 'nao_escrituradas']) -> name('reports.sped.nao_escrituradas');


