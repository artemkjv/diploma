<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sponsor\StoreRequest;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Gate;

class SponsorController extends Controller
{

    public function index() {
        $sponsors = Sponsor::paginate();
        return inertia('Sponsor/Index', compact('sponsors'));
    }

    public function create() {
        Gate::authorize('create', Sponsor::class);
        return inertia('Sponsor/Create');
    }

    public function store(StoreRequest $request) {
        Gate::authorize('create', Sponsor::class);
        $payload = $request->validated();
        Sponsor::create($payload);
        return to_route('sponsors.index');
    }

    public function edit($id) {
        $sponsor = Sponsor::findOrFail($id);
        Gate::authorize('edit', $sponsor);
        return inertia('Sponsor/Edit', compact('sponsor'));
    }

    public function update(StoreRequest $request, $id) {
        $payload = $request->validated();
        $sponsor = Sponsor::findOrFail($id);
        Gate::authorize('edit', $sponsor);
        $sponsor->update($payload);
        return to_route('sponsors.index');
    }

    public function destroy($id) {
        $sponsor = Sponsor::findOrFail($id);
        Gate::authorize('destroy', $sponsor);
        $sponsor->delete();
        return back();
    }

}
