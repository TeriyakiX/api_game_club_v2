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

Route::apiResources([
    'news' => NewsController::class,
    'tournaments' => TournamentController::class,
    'application_the_tournament' => Applications_the_tournamentController::class,
]);


Route::post('/tournaments/{id}/applications', function (Request $request, $id) {
    $name = $request->input('name');
    $email = $request->input('email');
    $phone = $request->input('phone');

    $tournament = \App\Models\Tournament::findOrFail($id);

    $application = new \App\Models\Applications_the_tournament();
    $application->tournament_id = $id;
    $application->user_id = auth()->id();
    $application->name = $name;
    $application->email = $email;
    $application->phone = $phone;

    $tournament->applications()->save($application);

    return response()->json(['status' => 'success', 'message' => 'Заявка на участие в турнире была успешно создана']);
});

