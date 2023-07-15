<?php

use App\Models\Post;
use App\Models\User;
use App\Mail\NewPostCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Events\NotificationSent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $a = Mail::to('eeed@dsfsdf.com')->send(new NewPostCreatedMail(User::first(), Post::first()));

    Event::listen(function (NotificationSent $event) {
        dd($event);
    });
    dd($a);
});
