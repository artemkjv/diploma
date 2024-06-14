<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\StoreRequest;
use App\Http\Requests\News\UpdateRequest;
use App\Models\Event;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{

    public function index() {
        $news = News::paginate(\request()->user());
        return inertia('News/Index', compact('news'));
    }

    public function create() {
        $projectId = Str::uuid();
        $newsCategories = NewsCategory::all();
        return inertia('News/Create', compact('projectId', 'newsCategories'));
    }

    public function store(StoreRequest $request) {
        $payload = $request->validated();
        $page = Page::getByUuid($payload['page_id']);
        $payload['page_id'] = $page->id;
        $payload['user_id'] = \request()->user()->id;
        $payload['image'] = $request->file('image')->store('news', 'public');
        News::create($payload);
        return to_route('news.index');
    }

    public function edit($id) {
        $news = News::getByUserAndId(\request()->user(), $id);
        $newsCategories = NewsCategory::all();
        return inertia('News/Edit', compact('news', 'newsCategories'));
    }

    public function update(UpdateRequest $request, $id) {
        $payload = $request->validated();
        $news = News::getByUserAndId(\request()->user(), $id);
        if($request->hasFile('image')) {
            $payload['image'] = $request->file('image')->store('events', 'public');
        } else {
            unset($payload['image']);
        }
        $news->update($payload);
        return to_route('news.index');
    }

    public function destroy($id) {
        $news = News::getByUserAndId(\request()->user(), $id);
        $news->delete();
        return back();
    }

}
