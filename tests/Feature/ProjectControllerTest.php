<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('a user can view projects', function () {
    $user = User::factory()->create([
        'role' => \App\Enums\Role::EDITOR->value
    ]);
    $projects = Project::factory(10)
        ->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->get(route('projects.index'));

    $response->assertInertia(function (Assert $page) use ($projects) {
        $page->component('Project/Index')
            ->has('projects.data', $projects->count())
            ->has('projects.data.9', function (Assert $page) use ($projects) {
                $page->whereAll([
                    'id' => $projects->first()->id,
                    'name' => $projects->first()->name,
                    'description' => $projects->first()->description,
                    'status' => $projects->first()->status,
                    'user' => $projects->first()->user,
                ])->etc();
            });
    });
});

test('a user can create a project', function () {
    $user = User::factory()->create([
        'role' => \App\Enums\Role::EDITOR->value
    ]);

    \App\Models\ProjectStatus::factory(3)->create();

    $statuses = \App\Models\ProjectStatus::all();

    $response = $this->actingAs($user)
        ->get(route('projects.create'));

    $response->assertInertia(function (Assert $page) use ($statuses) {
        $page->component('Project/Create')
            ->has('statuses', $statuses->count())
            ->has('statuses.0', function (Assert $page) use ($statuses) {
                $page->whereAll([
                    'id' => $statuses->first()->id,
                    'name' => $statuses->first()->name,
                ])->etc();
            });
    });
});

test('a user can delete a project', function () {
    $user = User::factory()->create([
        'role' => \App\Enums\Role::EDITOR->value
    ]);
    $project = Project::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->delete(route('projects.destroy', $project->id));

    $response->assertRedirect();
    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
});

test('a user can store a project', function () {
    $user = User::factory()->create([
        'role' => \App\Enums\Role::EDITOR->value
    ]);

    $payload = [
        'name' => 'Project Name',
        'project_status_id' => \App\Models\ProjectStatus::factory()->create()->id,
        'description' => 'Project Description',
        'date' => ['2021-01-01', '2021-01-02'],
    ];

    $response = $this->actingAs($user)
        ->post(route('projects.store'), $payload);

    $response->assertRedirect(route('projects.index'));
    $this->assertDatabaseHas('projects', [
        'name' => $payload['name'],
        'user_id' => $user->id,
        'project_status_id' => $payload['project_status_id'],
        'description' => $payload['description'],
        'start_date' => $payload['date'][0],
        'end_date' => $payload['date'][1],
    ]);
});

test('a user can edit a project', function () {
    $user = User::factory()->create([
        'role' => \App\Enums\Role::EDITOR->value
    ]);
    $project = Project::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->get(route('projects.edit', $project->id));

    $response->assertInertia(function (Assert $page) use ($project) {
        $page->component('Project/Edit')
            ->has('project', function (Assert $page) use ($project) {
                $page->whereAll([
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,
                    'status' => $project->status,
                ])->etc();
            });
    });
});

test('a user can update a project', function () {
    $user = User::factory()->create([
        'role' => \App\Enums\Role::EDITOR->value
    ]);
    $project = Project::factory()->create(['user_id' => $user->id]);

    $payload = [
        'name' => 'Project Name',
        'project_status_id' => \App\Models\ProjectStatus::factory()->create()->id,
        'description' => 'Project Description',
        'date' => ['2021-01-01', '2021-01-02'],
    ];

    $response = $this->actingAs($user)
        ->post(route('projects.update', $project->id), $payload);

    $response->assertRedirect(route('projects.index'));
    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'name' => $payload['name'],
        'user_id' => $user->id,
        'project_status_id' => $payload['project_status_id'],
        'description' => $payload['description'],
        'start_date' => $payload['date'][0],
        'end_date' => $payload['date'][1],
    ]);
});
