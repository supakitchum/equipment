<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('equipment/{code}', function ($code){
    return response()->json([
        'code' => 0,
        'result' => \App\Equipment::where('code',$code)->first()
    ]);
});

Route::name('dataTable.')->prefix('dataTable')->group(function () {
    Route::get('reserved', 'API\DataTable@reserved_equipment')->name('dashboard.reserved');
    Route::get('reserving', 'API\DataTable@reserving_equipment')->name('dashboard.reserving');
});
