<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterQuizController;

Route::get('/', function () {
    return view('welcome');
});

// Master Quiz TTS Routes
Route::prefix('master-quiz')->name('master-quiz.')->group(function () {
    Route::get('/', [MasterQuizController::class, 'index'])->name('index');
    Route::post('/generate', [MasterQuizController::class, 'generate'])->name('generate');
    Route::get('/download', [MasterQuizController::class, 'download'])->name('download');
});
