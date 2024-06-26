<?php

use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\API\{AnswerController, AssessmentController, AuthController, OptionController, QuestionController};
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
    Route::prefix('user')->group(function () {
        Route::get('', function (Request $request) {
            return new UserResource($request->user());
        });
        Route::post('/create', [AuthController::class, 'store']);
    });
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('assessments')->controller(AssessmentController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('', 'index');
        Route::get('/{assessment:id}', 'view')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::get('/{assessment:id}/result', 'getResult')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::put('/{assessment:id}', 'update')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::delete('/{assessment:id}', 'delete')->missing(function () {
            throw new ResourceNotFoundException();
        });
    });

    Route::prefix('questions')->controller(QuestionController::class)->group(function () {
        Route::post('/{assessment:id}', 'store')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::get('/{assessment:id}', 'index')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::get('/question/{question:id}', 'view')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::put('/question/{question:id}', 'update')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::delete('/question/{question:id}', 'delete')->missing(function () {
            throw new ResourceNotFoundException();
        });
    });

    Route::prefix('options')->controller(OptionController::class)->group(function () {
        Route::get('/{question:id}', 'index')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::post('/{question:id}', 'store')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::get('/option/{option:id}', 'view')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::put('/option/{option:id}', 'update')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::delete('/option/{option:id}', 'delete')->missing(function () {
            throw new ResourceNotFoundException();
        });
    });

    Route::prefix('answers')->controller(AnswerController::class)->group(function () {
        Route::get('/{question:id}', 'index')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::get('/user/{question:id}', 'userAnswers')->missing(function () {
            throw new ResourceNotFoundException();
        });
        Route::post('/{question:id}', 'store')->missing(function () {
            throw new ResourceNotFoundException();
        });
    });
});

Route::middleware('json.response')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
    });
});
