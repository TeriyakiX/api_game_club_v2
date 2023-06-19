<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TournamentStoreRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;
use Illuminate\Http\Request;

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
            'name' => 'required|max:255',
            'prize' => 'required|max:255',
            'date' => 'required|max:255'
        ]));
        return new TournamentResource($created_tournament);

    }


    public function show(string $id)
    {
        return new TournamentResource(Tournament::find($id));
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
