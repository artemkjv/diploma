<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreRequest;
use App\Http\Requests\Event\UpdateRequest;
use App\Http\Resources\Event\IndexCollection;
use App\Models\Event;
use App\Models\Page;
use Illuminate\Support\Str;

class EventController extends Controller
{

    public function index() {
        $events = Event::paginate(\request()->user());
        return inertia('Event/Index', compact('events'));
    }

    public function create() {
        $projectId = Str::uuid();
        return inertia('Event/Create', compact('projectId'));
    }

    public function store(StoreRequest $request) {
        $payload = $request->validated();
        $page = Page::getByUuid($payload['page_id']);
        $payload['page_id'] = $page->id;
        $payload['user_id'] = \request()->user()->id;
        $payload['image'] = $request->file('image')->store('events', 'public');
        Event::create($payload);
        return to_route('events.index');
    }

    public function edit($id) {
        $event = Event::getByUserAndId(\request()->user(), $id);
        if(!$event) abort(403, 'Unauthorized');
        return inertia('Event/Edit', compact('event'));
    }

    public function update(UpdateRequest $request, $id) {
        $event = Event::getByUserAndId(\request()->user(), $id);
        if(!$event) abort(403, 'Unauthorized');
        $payload = $request->validated();
        if($request->hasFile('image')) {
            $payload['image'] = $request->file('image')->store('events', 'public');
        } else {
            unset($payload['image']);
        }
        $event->update($payload);
        return to_route('events.index');
    }

    public function destroy($id) {
        $event = Event::getByUserAndId(\request()->user(), $id);
        if(!$event) abort(403, 'Unauthorized');
        $event->delete();
        return back();
    }

}
