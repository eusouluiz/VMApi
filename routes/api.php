<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\StatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [ApiController::class, 'getApi'])->name('get.api.ui');
Route::get('/api/documentation', [ApiController::class, 'getApiDocumentation'])->name('get.api.documentation');

Route::get('/status', [StatusController::class, 'getStatus']);

// Auth routes
Route::post('/auth/login', [Auth\PublicController::class, 'postLogin']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Maintenance routes
    Route::post('/maintenance/up', [MaintenanceController::class, 'postUp']);
    Route::post('/maintenance/down', [MaintenanceController::class, 'postDown']);

    // Auth routes
    Route::get('/auth/user', [Auth\PrivateController::class, 'getUser']);
    Route::post('/auth/logout', [Auth\PrivateController::class, 'postLogout']);

    // Resources routes
    Route::Resource('user', 'App\Http\Controllers\Api\UserController')->missing(function () {
        return response()->json(['message' => 'Registro não encontrado!'], 404);
    });
    Route::Resource('aluno', 'App\Http\Controllers\Api\AlunoController');
    Route::Resource('turma', 'App\Http\Controllers\Api\TurmaController');
    Route::Resource('responsavel', 'App\Http\Controllers\Api\ResponsavelController')->missing(function () {
        return response()->json(['message' => 'Registro não encontrado!'], 404);
    });
    Route::Resource('cargo', 'App\Http\Controllers\Api\CargoController');
    Route::Resource('funcionario', 'App\Http\Controllers\Api\FuncionarioController')->missing(function () {
        return response()->json(['message' => 'Registro não encontrado!'], 404);
    });
    Route::resource('funcionalidade', 'App\Http\Controllers\Api\FuncionalidadeController');
    Route::Resource('canal', 'App\Http\Controllers\Api\CanalController');
    Route::Resource('aviso', 'App\Http\Controllers\Api\AvisoController');
    Route::Resource('mensagem', 'App\Http\Controllers\Api\MensagemController');
    Route::Resource('lembrete', 'App\Http\Controllers\Api\LembreteController');

    Route::resource('aluno-responsavel', 'App\Http\Controllers\Api\AlunoResponsavelController');
    Route::delete('aluno-responsavel/{alunoId}/{responsavelId}', 'App\Http\Controllers\Api\AlunoResponsavelController@destroy');
    Route::resource('cargo-funcionalidade', 'App\Http\Controllers\Api\CargoFuncionalidadeController');
    Route::delete('cargo-funcionalidade/{cargoId}/{funcionalidadeId}', 'App\Http\Controllers\Api\CargoFuncionalidadeController@destroy');
    Route::resource('canal-cargo', 'App\Http\Controllers\Api\CanalCargoController');
    Route::delete('canal-cargo/{canalId}/{cargoId}', 'App\Http\Controllers\Api\CanalCargoController@destroy');
    Route::resource('aviso-responsavel', 'App\Http\Controllers\Api\AvisoResponsavelController');
    Route::resource('aviso-turma', 'App\Http\Controllers\Api\AvisoTurmaController');
    Route::resource('canal-responsavel', 'App\Http\Controllers\Api\CanalResponsavelController');
});
