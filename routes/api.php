<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;

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

Route::post('/save-individual', [CsvController::class, 'saveIndividual']);

Route::post('/save-clients', [CsvController::class, 'saveClients']);
