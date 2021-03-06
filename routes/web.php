<?php

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

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
    return view('home');
})->name('home');

Route::get('u/{username}', function () {
    $user = User::where(['username' => request('username')])->first();
    throw_if($user === null, new ModelNotFoundException());

    // I AM 99.9% SURE THAT THIS IS UNNECESSARY BUT I DO NOT WANT TO REMOVE IT AT THE LAST MINUTES OF A HACKATHON.
    $title = $user->currentLiveStream()?->title ? $user->currentLiveStream()->title : 'Live Stream Of: '.$user->username;

    return view('stream.show', [
        'title' => $title,
    ]);
})->name('stream.watch');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
