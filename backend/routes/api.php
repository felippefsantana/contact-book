<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactsController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/contacts', [ContactsController::class, 'index']);
Route::prefix('contacts')->group(function() {
  Route::get('/{id}', [ContactsController::class, 'show']);
  Route::post('/create', [ContactsController::class, 'store']);
  Route::patch('/update/{id}', [ContactsController::class, 'update']);
  Route::delete('/delete/{id}', [ContactsController::class, 'destroy']);
});