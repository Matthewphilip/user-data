<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CsvService;
use App\Http\Resources\PersonResource;
use Illuminate\Support\Facades\Validator;

class CsvController extends Controller
{
    protected $csvService;

    public function __construct(CsvService $csvService)
    {
        $this->csvService = $csvService;
    }

    public function processCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $people = $this->csvService->processCSV($request->file('csv'));

        return PersonResource::collection(collect($people));
    }
    
}
