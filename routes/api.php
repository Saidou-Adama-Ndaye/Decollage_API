<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ActiviteController;
use App\Http\Controllers\API\ElementActiviteController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get_acivites', [ActiviteController::class, 'index']);
    Route::get('get_activite/{id}', [ActiviteController::class, 'show']);
    Route::post('add_activite', [ActiviteController::class, 'store']);
    Route::put('update_activite/{id}', [ActiviteController::class, 'update']);
    Route::delete('delete_activite/{id}', [ActiviteController::class, 'destroy']);

    Route::get('get_elements_activite', [ElementActiviteController::class, 'index']);
    Route::post('add_element_activite', [ElementActiviteController::class, 'store']);
    Route::put('update_element_activite/{id}', [ElementActiviteController::class, 'update']);
    Route::delete('delete_element_activite/{id}', [ElementActiviteController::class, 'destroy']);


    Route::get('get_utilisateurs', [UserController::class, 'index']);
    Route::post('add_utilisateur', [UserController::class, 'store']);
    Route::put('update_utilisateur/{id}', [UserController::class, 'update']);
    Route::delete('delete_utilisateur/{id}', [UserController::class, 'destroy']);
});

// Authentication routes
Route::post('inscrire', [AuthController::class, 'inscrire']);
Route::post('connecter', [AuthController::class, 'connecter']);
