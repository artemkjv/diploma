<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Resources\Project\ViewResource;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::paginate(\request()->user());
        return inertia('Project/Index', compact('projects'));
    }

    public function create()
    {
        $statuses = ProjectStatus::all();
        return inertia('Project/Create', compact('statuses'));
    }

    public function destroy($id)
    {
        $project = Project::getByUserAndId(\request()->user(), $id);
        $project->delete();
        return back();
    }

    public function store(StoreRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = $request->user()->id;
        $payload['start_date'] = $payload['date'][0];
        $payload['end_date'] = $payload['date'][1];
        unset($payload['date']);
        DB::beginTransaction();
        try {
            $project = Project::create($payload);
            if ($request->has('files')) {
                $readyFiles = [];
                foreach ($request->file('files') as $file) {
                    $readyFiles[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $file->store('files')
                    ];
                }
                $project->files()->createMany($readyFiles);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return to_route('projects.index');
    }

    public function edit()
    {
        $project = Project::getByUserAndId(\request()->user(), \request()->route('project'));
        $project = (new ViewResource($project))->resolve();
        $statuses = ProjectStatus::all();
        return inertia('Project/Edit', compact('project', 'statuses'));
    }

    public function update(StoreRequest $request, $id)
    {
        $project = Project::getByUserAndId(\request()->user(), $id);
        $payload = $request->validated();
        $payload['start_date'] = $payload['date'][0];
        $payload['end_date'] = $payload['date'][1];
        unset($payload['date']);
        DB::beginTransaction();
        try {
            $project->update($payload);
            if ($request->has('files')) {
                $readyFiles = [];
                $filesNotToDelete = [];
                foreach ($payload['files'] as $file) {
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        $readyFiles[] = [
                            'name' => $file->getClientOriginalName(),
                            'path' => $file->store('files')
                        ];
                    } elseif(is_array($file)) {
                        $filesNotToDelete[] = $file['id'];
                    }
                }
                $project->files()->whereNotIn('files.id', $filesNotToDelete)->delete();
                $project->files()->createMany($readyFiles);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return to_route('projects.index');
    }

}
