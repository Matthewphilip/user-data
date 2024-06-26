<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CsvController extends Controller
{
    public function processCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv' => 'required|file|mimes:csv',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        if ($request->hasFile('csv')) {
            $file = $request->file('csv');

            Log::info('Received file:', ['name' => $file->getClientOriginalName()]);

            $data = array_map('str_getcsv', file($file->getPathname()));

            $people = [];

            foreach ($data as $row) {
                foreach ($row as $name) {
                    $personData = $this->splitName($name);

                    Log::info('personData:', ['personData' =>  $personData]);

                    if (!empty($personData)) {
                        foreach ($personData as $person) {
                            $people[] = $person;
                        }
                    }
                }
            }

            return response()->json($people);
        }

        return response()->json(['error' => 'No CSV file uploaded'], 400);
    }

    public function splitName($name)
    {
        $titles = ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr', 'Prof', 'Mister'];
        $parts = explode(' ', $name);
        Log::info('parts:', ['parts' =>  $parts]);

        if (!in_array($parts[0], $titles)) {
            return [];
        }

        $parts = array_filter($parts, function ($part) {
            return strtolower($part) !== 'and' && $part !== '&';
        });

        $people = [];
        $person = [];

        foreach ($parts as $part) {
            if (in_array($part, $titles)) {
                if (!empty($person)) {
                    if(count($parts) === 3 || count($parts) === 4){
                        $person['last_name'] = end($parts);
                    } 
                    $people[] = $person;
                }
                $person = ['title' => $part, 'first_name' => null, 'initial' => null, 'last_name' => null];
            } else {
                if (strlen($part) === 1 || (strlen($part) === 2 && $part[1] === '.')) {
                    $person['initial'] = str_replace('.', '', $part);
                } else {
                    Log::info('parts test:', ['parts test' =>  $parts]);
                    if ($person['first_name'] === null && $person['initial'] === null && $part !== end($parts)) {
                        $person['first_name'] = $part;
                    } elseif ($person['last_name'] === null) {
                        $person['last_name'] = $part;
                    } 
                }
            }
        }

        if (!empty($person)) {
            $people[] = $person;
        }

        return $people;
   
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
            $clients = $request->input('clients');
            $savedClients = [];

            foreach ($clients as $client) {
                try {
                    $savedClients[] = Person::create($client);
                } catch (\Exception $e) {
                    Log::error('Error saving client: ' . $e->getMessage());
                }
            }

            return response()->json($savedClients);
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
            $client = $request->input('client');
    
            $createdClient = Person::create($client);
    
            return response()->json($createdClient);
        } catch (\Exception $e) {
            Log::error('Error saving individual client: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save individual client'], 500);
        }
    }
    
}
