<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use App\Http\Resources\PersonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function saveClients(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'clients' => 'required|array',
        'clients.*' => 'required|array|filled',
        'clients.*.title' => 'required|string',
        'clients.*.first_name' => 'nullable|string',
        'clients.*.initial' => 'nullable|string',
        'clients.*.last_name' => 'required|string',
        ]);

        if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try {
        $savedClients = $this->clientService->saveClients($request->input('clients'));
        return PersonResource::collection($savedClients);
        } catch (\Exception $e) {
        Log::error('Error saving clients: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to save clients'], 500);
        }
    }


    public function saveIndividual(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client' => 'required|array',
            'client.title' => 'required|string',
            'client.first_name' => 'nullable|string',
            'client.initial' => 'nullable|string',
            'client.last_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try {
            $clientData = $request->input('client');
            $createdClient = $this->clientService->saveIndividual($clientData);

            return new PersonResource($createdClient);
        } catch (\Exception $e) {
            Log::error('Error saving individual client: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save individual client'], 500);
        }
    }
}
