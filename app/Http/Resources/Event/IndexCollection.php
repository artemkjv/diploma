<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->name,
                    'description' => $event->description,
                    'image' => $event->image,
                    'content' => $event->content,
                    'styles' => $event->styles,
                    'editor' => $event->user,
                    'page' => $event->page,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
