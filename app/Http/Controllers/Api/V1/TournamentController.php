<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TournamentStoreRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Applications_the_tournament;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{

    public function index()
    {
        $tournament = Tournament::paginate(5);

        TournamentResource::collection($tournament);

        return response()->json([
            'data' => $tournament ->all(),
            'currentPage' => $tournament -> currentPage(),
            'lastPage' => $tournament -> lastPage(),
        ]);
    }


    public function store(TournamentStoreRequest $request)
    {
        $created_tournament = Tournament::create($request->validate([
            'game' => 'required|max:255',
            'Short_description' => 'required|max:255',
            'description' => 'required|max:255',
            'date_start' => 'required|max:255',
            'date_end' => 'required|max:255',
            'prize' => 'required|max:255',
            'type_id' => 'required|max:255',
            'status_id' => 'required|max:255'
        ]));
        return new TournamentResource($created_tournament);

    }

    public function createApplication(Request $request, $id)
    {
        // Получение данных из формы
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');

        // Получение идентификатора текущего пользователя
        $user_id = Auth::id();

        // Создание записи участия в турнире
        $application = new Applications_the_tournament();
        $application->id_tournament = $id;
        $application->name = $name;
        $application->email = $email;
        $application->phone = $phone;
        $application->id_user = $user_id; // Связывание заявки с пользователем
        $application->save();

        // Другой код

        return redirect()->back()->with('status', 'Заявка на участие в турнире была успешно создана!');
    }


    public function show(string $id)
    {
        return new TournamentResource(Tournament::find($id));
    }


    public function update(TournamentStoreRequest $request, Tournament $tournament)
    {
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

        return new TournamentResource($tournament);
    }
    public function update_status(Request $request, $id , Tournament $tournament)
    {
        $tournament = Tournament::find($id);

        $tournament->update($request->validate([
            'status_id' => 'required|max:255'
        ]));

        return new TournamentResource($tournament);
    }


    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return response(null, status: 204);
    }
}
