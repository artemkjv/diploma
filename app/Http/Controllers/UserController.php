<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index() {
        $users = User::paginate();
        return inertia('User/Index', compact('users'));
    }

    public function edit($id) {
        $user = User::getById($id);
        $roles = Role::values();
        return inertia('User/Edit', compact('user', 'roles'));
    }

    public function update(UpdateRequest $request, $id) {
        $user = User::getById($id);
        $payload = $request->validated();
        if(is_null($payload['password'])) {
            unset($payload['password']);
        }
        $user->update($payload);
        return to_route('users.index');
    }

    public function destroy($id) {
        $user = User::getById($id);
        $user->delete();
        return back();
    }

}
