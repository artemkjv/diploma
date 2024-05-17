<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectStatusesData = [
            ['name' => 'New', 'color' => 'blue'],
            ['name' => 'In Progress', 'color' => 'yellow'],
            ['name' => 'Completed', 'color' => 'green'],
        ];

        $projectStatuses = [];
        foreach ($projectStatusesData as $projectStatus) {
            $projectStatuses[] = ProjectStatus::create($projectStatus);
        }

        Project::factory(10)->create([
            'project_status_id' => $projectStatuses[0]->id,
        ]);
    }
}
