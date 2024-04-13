<?php

use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\API\{AssessmentController, AuthController};
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'json.response'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::prefix('assessments')->controller(AssessmentController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('/{assessment:id}', 'view')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::put('/{assessment:id}', 'update')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::delete('/{assessment:id}', 'delete')->missing(function () {
            throw new ResourceNotFoundException();
        });
    });
});

Route::middleware('json.response')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
    });
});
