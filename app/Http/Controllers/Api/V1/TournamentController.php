<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TournamentStoreRequest;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(TournamentStoreRequest $request)
    {
        $created_tournament = Tournament::create($request->validate([
            'name' => 'required|max:255',
            'prize' => 'required|max:255',
            'date' => 'required|max:255'
        ]));
        return new TournamentResource($created_tournament);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TournamentResource(Tournament::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
