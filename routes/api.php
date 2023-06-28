<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\TournamentController;
use \App\Http\Controllers\Api\V1\Applications_the_tournamentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', 'AuthController@register');
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);
Route::post('/tournament/{id}/application', 'Api/V1/TournamentController@createApplication')->middleware('auth:api');
Route::post('/tournament', 'Api/V1/TournamentController@store')->middleware('auth:api');
Route::put('/tournaments/{id}/status/{newStatus}', 'TournamentController@changeTournamentStatus')->middleware('auth:api');
Route::get('/tournament/{id}/applications', 'TournamentController@viewApplications')->middleware('auth:api');
Route::apiResources([
    'news' => NewsController::class,
    'tournaments' => TournamentController::class,
    'application_the_tournament' => Applications_the_tournamentController::class,
]);

