<?php

namespace App\Http\Resources\Project;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'start_date' => Carbon::create($this->start_date)->format('Y-m-d'),
            'end_date' => Carbon::create($this->end_date)->format('Y-m-d'),
            'files' => $this->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'path' => $file->path,
                ];
            }),
        ];
    }
}
