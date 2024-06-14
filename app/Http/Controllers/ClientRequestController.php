<?php

namespace App\Http\Controllers;

use App\Models\ClientRequest;
use App\Models\ClientRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClientRequestController extends Controller
{

    public function index() {
        $clientRequests = ClientRequest::paginate();
        $statuses = ClientRequestStatus::all();
        return inertia('ClientRequest/Index', compact('clientRequests', 'statuses'));
    }

    public function show(ClientRequest $clientRequest) {
        return inertia('ClientRequest/Show', compact('clientRequest'));
    }

    public function destroy(ClientRequest $clientRequest) {
        Gate::authorize('destroy', $clientRequest);
        $clientRequest->delete();
        return back();
    }

    public function updateStatus(Request $request, $id) {
        $payload = $request->validate([
            'client_request_status_id' => 'required|int|exists:client_request_statuses,id'
        ]);
        $clientRequest = ClientRequest::findOrFail($id);
        $clientRequest->update([
            'client_request_status_id' => $payload['client_request_status_id']
        ]);
        return back();
    }

}
