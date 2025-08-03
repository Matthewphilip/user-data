<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/upload-csv', [CsvController::class, 'processCSV']);

Route::post('/save-individual', [ClientController::class, 'saveIndividual']);

Route::post('/save-clients', [ClientController::class, 'saveClients']);
