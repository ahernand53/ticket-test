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

Route::get('/users', function () {

    $users = App\User::all();

    return $users;

});

Route::resource('tickets', 'TicketController')->except(['edit', 'create']);
Route::post('tickets/{ticket}/close', 'TicketController@close');
