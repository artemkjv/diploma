<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientRequest\StoreRequest;
use App\Models\ClientRequest;
use Illuminate\Http\Request;

class ClientRequestController extends Controller
{

    public function store(StoreRequest $request) {
        $payload = $request->validated();
        ClientRequest::create($payload);
        return response()->json([
            'status' => 'success'
        ]);
    }

}
