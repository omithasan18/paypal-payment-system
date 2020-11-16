<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/execute-payment','PaymentController@execute');
Route::post('/create-payment','PaymentController@create')->name('create-payment');
Route::get('/create-plan','SubscriptionController@create')->name('create-plan');
Route::get('/planlist','SubscriptionController@planlist')->name('planlist');
Route::get('/getId','SubscriptionController@getId')->name('getId');
Route::get('/activePlan/{id}/activate','SubscriptionController@activePlan')->name('activePlan');

