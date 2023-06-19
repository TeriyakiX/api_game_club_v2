<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsStoreRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {

        $news = News::paginate(15);

        NewsResource::collection($news);

        return response()->json([
            'data' => $news ->all(),
            'currentPage' => $news -> currentPage(),
            'lastPage' => $news -> lastPage(),
        ]);
    }


    public function store(NewsStoreRequest $request)
    {
        $created_news = News::create($request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]));
        return new NewsResource($created_news);
    }


    public function show(string $id)
    {
        return new NewsResource(News::find($id));
    }


    public function update(NewsStoreRequest $request, News $news)
    {
        $news->update($request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]));

        return new NewsResource($news);
    }

    public function destroy(News $news)
    {
        $news->delete();

        return response(null, status: 204);
    }
}
