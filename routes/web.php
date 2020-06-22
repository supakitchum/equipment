<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::resource('home', 'HomeController');

Route::resource('notifications', 'NotificationController');
Route::get('profile', 'ProfileController@index')->name('profile.index');
Route::put('profile/password', 'ProfileController@changePassword')->name('profile.changePassword');
Route::put('profile/detail', 'ProfileController@changeProfile')->name('profile.changeProfile');
Route::get('notification/{message_id}', 'NotificationController@read');
Route::get('notification/restore/{reserving_id}', 'NotificationController@restore')->name('notification.restore');

Route::name('admin.')->prefix('admin')->group(function () {
    Route::resource('equipments', 'Admin\EquipmentController');
    Route::get('dataTable/equipments', 'Admin\EquipmentController@dataTable')->name('equipments.dataTable');
    Route::get('equipment/reserved/{id}', 'Admin\EquipmentController@reserved')->name('equipments.reserved');
    Route::post('equipment/restore', 'Admin\EquipmentController@restore')->name('equipments.restore');
    Route::post('equipment/return', 'Admin\EquipmentController@return')->name('equipments.return');
    Route::resource('histories', 'Admin\HistoryController');
    Route::resource('members', 'Admin\MemberController');
    Route::resource('reserving', 'Admin\ReservingController');
    Route::get('dataTable/reserving', 'Admin\ReservingController@dataTable')->name('reserving.dataTable');
});

Route::name('user.')->group(function () {
    Route::resource('reserving', 'User\ReservingController');
    Route::resource('equipments', 'User\EquipmentController');
    Route::resource('transfers', 'User\TransferController');
    Route::resource('histories', 'User\HistoryController');
    Route::get('dataTable/equipments', 'User\EquipmentController@dataTable')->name('equipments.dataTable');
});

Route::name('engineer.')->prefix('engineer')->group(function () {
    Route::resource('tasks', 'Engineer\TaskController');
    Route::resource('histories', 'Engineer\HistoryController');
});
Route::auth();
Route::get('/logout', function (){
   \Illuminate\Support\Facades\Auth::logout();
   return redirect(route('login'));
})->name('logout');
