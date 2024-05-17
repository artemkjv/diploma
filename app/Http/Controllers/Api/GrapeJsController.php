<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class GrapeJsController extends Controller
{

    public function load($id) {
        $page = Page::query()
            ->where('uuid', $id)
            ->firstOr(function () {
                $fakePage = new \stdClass();
                $fakePage->data = [];
                return $fakePage;
            });
        return response()->json($page?->data);
    }

    public function store($id) {
        Page::query()
            ->updateOrCreate([
                'uuid' => $id
            ], [
                'data' => \request()->post()
            ]);
    }

}
