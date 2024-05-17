<?php

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;

test('test if status relationship works', function () {
    $projectStatus = ProjectStatus::factory()->create();
    $project = Project::factory()->create([
        'project_status_id' => $projectStatus->id,
    ]);
    $this->assertInstanceOf(ProjectStatus::class, $project->status);
});

test('test if user relationship works', function () {
    $project = Project::factory()->create();
    $this->assertInstanceOf(User::class, $project->user);
});
