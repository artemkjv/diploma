<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index() {
        return inertia('Guest/News/Index');
    }

    public function show($id) {
        return inertia('Guest/News/Show', compact('id'));
    }

}
