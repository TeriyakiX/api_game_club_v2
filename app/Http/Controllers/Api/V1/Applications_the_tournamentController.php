<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Applications_the_tournamentResource;
use App\Models\Applications_the_tournament;
use App\Models\Tournament;
use Illuminate\Http\Request;

class Applications_the_tournamentController extends Controller
{

    public function index()
    {
        $applications_the_tournament = Applications_the_tournament::paginate(15);

        Applications_the_tournamentResource::collection($applications_the_tournament);

        return response()->json([
            'data' => $applications_the_tournament ->all(),
            'currentPage' => $applications_the_tournament -> currentPage(),
            'lastPage' => $applications_the_tournament -> lastPage(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_tournament' => 'required|integer',
            'id_user' => 'required|integer',
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|max:255',

        ]);

        $tournament = Tournament::findOrFail($request->input('id_tournament'));

        if ($tournament->users()->find($request->input('id_user'))) {
            return redirect()->route('tournaments.index')->with('error', 'Вы уже зарегистрированы на этот турнир');
        }

        $tournament->users()->attach($request->input('id_user'));

        return redirect()->route('tournaments.index')->with('success', 'Вы успешно зарегистрировались на турнир');
    }
    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
