<?php

use Illuminate\Support\Facades\Auth;
use App\Events\MessagePosted;
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

Route::get('/chat', function (){
    return view('chat');
})->middleware('auth');
Auth::routes();

Route::get('/messages', function (){
    return \App\Message::with('user')->get();
})->middleware('auth');

Route::post('/messages', function (){
    $user = Auth::user();

    $message = $user->messages()->create([
        'message' => request()->get('message'),
        'user_id' => $user['id']
    ]);
    //announce that a new message sent
    broadcast(new MessagePosted($message, $user))->toOthers();

    return ['status' => 'Ok'];
})->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth_user', function (){
    return Auth::user()['name'];
})->middleware('auth');