<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index() {
        return News::query()
            ->orderByDesc('id')
            ->with(['user', 'category'])
            ->jsonPaginate();
    }

    public function show($id) {
        return response()->json(
            News::query()
                ->with(['user', 'category'])
                ->findOrFail($id)
        );
    }

}
