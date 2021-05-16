<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\BookController@index');

Route::get('/Шинэ', function ($home_name='Шинэ') {
    return view('category.category_single',compact('home_name'));
});

Route::get('/Bestseller', function ($home_name='Bestseller') {
    return view('category.category_single',compact('home_name'));
});

Route::get('/search',function(){
    return view('search');
});

Route::get('/book/{book_name}',function ($book_name) {
    return view('book.book_single',compact('book_name'));
});

Route::get('/book',function () {
    return view('book.book');
});

Route::get('/category',function () {
    return view('category.category');
});

Route::get('/category/{category_name}',function ($category_name) {
    return view('category.category_single',compact('category_name'));
});

Route::get('/login',function () {
    return view('login.login');
});
Route::get('/log_out',function () {
    return view('login.log_out');
});
Route::get('/user',function () {
    return view('user.users');
});

Route::get('/user/{user_id}',function ($user_id) {
    return view('user.user_single',compact('user_id'));
});
Route::get('/user/{user_id}/order',function ($user_id) {
    return view('user.user_single_order',compact('user_id'));
});
Route::get('/user/{user_id}/rent',function ($user_id) {
    return view('user.user_single_rent',compact('user_id'));
});
Route::get('/help',function () {
    return view('help.help');
});
Route::get('/helps',function () {
    return view('help.help_staff');
});

Route::get('verify/{email}','App\Http\Controllers\MailController@index');