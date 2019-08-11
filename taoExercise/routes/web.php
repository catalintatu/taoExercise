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

Route::get('/', function () {
    return view('welcome');
});

Route::get("/questions", "questions@getQuestions");

Route::get("questions/{lang}", "questions@getQuestions");

Route::get('/addQuestion', function () {
    return view('addQuestion');});

Route::post('/addQuestion','questions@addQuestion');


