<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('contents.home');
});
Route::get('/klasifikasi', function () {
    return view('contents.klasifikasi');
});

Route::get('/tweet','TweetController@index');
Route::get('/tweet/preprocessing','TweetController@preprocessing');
Route::get('/tweet/unduh', function () {
    return view('contents.unduh_tweet');
});


Route::get('/training/add', function () {
    return view('contents.form_training');
});
Route::get('/training','TweetController@showTraining');
Route::post('/training/store','TweetController@storeTraining');

Route::get('/preprocessing', function () {
    return view('contents.preprocessing_form');
});
Route::post('/klasifikasi/store','KlasifikasiController@klasifikasi');
Route::post('/preprocessing','KlasifikasiController@preprocessing');
Route::post('/unduh','TweetController@unduh');
