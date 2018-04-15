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

Route::get('/next5', array('uses' => 'RaceController@next5', 'as' => 'race.next5'));
Route::get('/show/{race_id}', array('uses' => 'RaceController@show', 'as' => 'race.show'));
