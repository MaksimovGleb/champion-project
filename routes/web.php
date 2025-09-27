<?php

use App\Http\Controllers\JudgesController;
use App\Http\Controllers\TournamentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChampionsController;
use Illuminate\Support\Facades\Route;

// Авторизация/регистрация
Route::group(['namespace' => 'Auth'], function () {
    // Вход по Email
    Route::get('/login', 'LoginController@create')->name('user.login');
    Route::post('/login', 'LoginController@store')
        ->middleware(\App\Http\Middleware\HttpLogger::class)->name('user.login.store');
    // Регистрация через email
//    Route::get('/signup/{refUrl?}', 'RegisterEmailController@create')->name('user.register');
//    Route::post('/signup', 'RegisterEmailController@store')->name('user.register.store');
    // Забыл пароль
//    Route::get('/user/password/create', 'ResetPasswordController@create')->name('user.password.create');
//    Route::post('/user/password', 'ResetPasswordController@store')->name('user.password.store');
//    Route::get('/user/password/{phone}/edit', 'ResetPasswordController@edit')->name('user.password.edit');

//    Route::get('/password/{email}/{code}/{new?}', 'ResetPasswordController@reset')->name('user.password.reset');

    // Выход
    Route::get('/logout', 'AuthController@logout')->name('user.logout');
});

// Общее
Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('/', function () {
        return redirect()->intended(route('champions.index'));
    });

    // Работа с пользователем
    Route::resource('/user', UserController::class);

    Route::put('/user/change-password/{user}', [UserController::class,'changePassword'])->name('user.changePassword');
    Route::get('/user/switchRole/{role}', [UserController::class,'switchRole'])->name('user.switchRole');
    Route::get('/user/repeatSmsPassword/{user}', [UserController::class,'repeatSmsPassword'])->name('user.repeatSmsPassword');
    Route::get('/user/loginAs/{user}', [UserController::class,'loginAs'])->name('user.loginAs');

    // Работа с бойцами
    Route::resource('/champions', ChampionsController::class)->except(['create', 'show']);
    Route::get('/champions/delete-all', [ChampionsController::class,'deleteAll'])->name('champions.deleteAll');

    // Работа с судьями
    Route::resource('/judges', JudgesController::class)->except(['create', 'show']);
    Route::get('/judges/delete-all', [JudgesController::class,'deleteAll'])->name('judges.deleteAll');

    //Работа с турнирными таблицами
    Route::resource('/tournaments', TournamentsController::class)->except(['create']);
    Route::get('/tournaments/{tournament}/export-pdf', [TournamentsController::class, 'exportPdf'])->name('tournament.export.pdf');
    Route::post('/tournaments/{tournament}/change', [TournamentsController::class, 'change'])->name('tournament.change');
});
