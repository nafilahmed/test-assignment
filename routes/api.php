<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CandidateController;
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

Route::get('candidates', [CandidateController::class, 'getCandidate']);
Route::post('candidates-contact/{id}', [CandidateController::class, 'contact']);
Route::post('candidates-hire/{id}', [CandidateController::class, 'hire']);
