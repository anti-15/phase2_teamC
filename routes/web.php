<?php

use App\Http\Controllers\Group_create_join_Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ScheduleController;
use App\Models\Member;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/group/join', [Group_create_join_Controller::class, 'join'])->name('group.join');
    Route::resource('group', Group_create_join_Controller::class);
    Route::get('/group/join/result', [SearchController::class, 'store'])->name('search.result');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('calendar');
});


Route::get('/dashboard', function () {
    $user_id = Auth::id();
    $groups = Member::where('member_id', $user_id)->get();
    return view('dashboard', compact('groups'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('schedule', ScheduleController::class);
});




require __DIR__ . '/auth.php';
