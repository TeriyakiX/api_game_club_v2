<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TournamentStoreRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Applications_the_tournament;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{

    public function index()
    {
        $tournament = Tournament::paginate(15);

        if ($tournament->count() === 0) {
            return response()->json(['message' => 'Турниры не найдены'], 404);
        }

        TournamentResource::collection($tournament);

        return response()->json([
            'data' => $tournament->all(),
            'currentPage' => $tournament->currentPage(),
            'lastPage' => $tournament->lastPage(),
        ]);
    }
    public function viewApplications($id) {

        if (auth()->check() && !auth()->user()) {
            return response()->json([
                'message' => 'У вас нет прав на просмотр заявок турнира'
            ], 403);
        }
        $tournament = \App\Models\Tournament::findOrFail($id);
        if (!$tournament) {
            return response()->json(['message' => 'турнир с данным ID не действителен'], 404);
        }else
            $applications = $tournament->applications()->get();
            return response()->json($applications);
    }



    public function store(Request $request)
    {
        // Проверяем права доступа на создание турниров
        if (auth()->check() && !auth()->user()->can('create-tournament')) {
            return response()->json([
                'message' => 'У вас нет прав на создание турниров'
            ], 403);
        }

        // Валидация входных данных и создание турнира
        $validator = Validator($request->all(), [
            'game' => 'required|max:255',
            'Short_description' => 'required|max:255',
            'description' => 'required|max:255',
            'date_start' => 'required|max:255',
            'date_end' => 'required|max:255',
            'prize' => 'required|max:255',
            'type_id' => 'required|max:255',
            'status_id' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422);
        }

        $created_tournament = Tournament::create($validator->validated());

        return response()->json([
            'message' => 'Турнир успешно создан',
            'data' => $created_tournament
        ], 201);
    }

    public function createApplication(Request $request, $id)
    {
        if (!auth()->user()->can('update-tournament')) {
            return response()->json([
                'message' => 'У вас нет прав на создание заявки'
            ], 403);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');

        $tournament = Tournament::findOrFail($id);

        if (!$tournament) {
            return response()->json(['message' => 'Турнир не действителен'],404);
        }

        $application = new \App\Models\Applications_the_tournament();
        $application->tournament_id = $id;
        $application->user_id = auth()->id();
        $application->name = $name;
        $application->email = $email;
        $application->phone = $phone;

        $tournament->applications()->save($application);

        return redirect()->back()->with('status', 'Заявка на участие в турнире была успешно создана!');
    }



    public function show(string $id)
    {
        $tournament = Tournament::find($id);

        if (!$tournament) {
            return response()->json(['message' => 'Турнира с заданным id не существует'], 404);
        }

        return new TournamentResource(Tournament::find($id));

    }


    public function update(TournamentStoreRequest $request, Tournament $tournament)

    {
        if (auth()->check() && !auth()->user()->can('create-tournament')) {
            return response()->json([
                'message' => 'У вас нет прав на создание турниров'
            ], 403);
        }

        $tournament->update($request->validate([
            'game' => 'required|max:255',
            'Short_description' => 'required|max:255',
            'description' => 'required|max:255',
            'date_start' => 'required|max:255',
            'date_end' => 'required|max:255',
            'prize' => 'required|max:255',
            'type_id' => 'required|max:255',
            'status_id' => 'required|max:255'
        ]));

        return response()->json([
            'message' => 'Турнир успешно обновлен',
            'data' => $tournament
        ], 200);
    }

    public function changeTournamentStatus(Request $request, $id, $newStatus)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Пользователь не авторизован'
            ], 401);
        }


        if (!auth()->user()->can('update-tournament')) {
            return response()->json([
                'message' => 'У вас нет прав на смену статуса турниров'
            ], 403);
        }

        $tournament = Tournament::find($id);

        $tournament->update($request->validate([
            'status_id' => 'required|max:255'
        ]));

        if (!$tournament) {
            return response()->json(['message' => 'Турнир не найден'], 404);
        }

        $tournament->status_id = $newStatus;

        if (!$tournament->save()) {
            return response()->json(['message' => 'Не удалось сохранить изменения'], 500);
        }

        return response()->json([
            'message' => 'Статус турнира изменен успешно',
            'data' => $tournament
        ], 200);
    }



    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return response(null, status: 204);
    }
}
