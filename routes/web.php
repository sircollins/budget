<?php

Route::get('/', 'IndexController@index')->name('index');

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@store');

Route::get('/verify/{token}', 'VerifyController')->name('verify');

Route::get('/reset_password', 'ResetPasswordController@get')->name('reset_password');
Route::post('/reset_password', 'ResetPasswordController@post');

Route::get('/register', 'RegisterController@index')->name('register');
Route::post('/register', 'RegisterController@store');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController')->name('dashboard');

    Route::name('earnings.')->group(function () {
        Route::get('/earnings', 'EarningController@index')->name('index');
        Route::get('/earnings/create', 'EarningController@create')->name('create');
        Route::post('/earnings', 'EarningController@store');
        Route::get('/earnings/{earning}/edit', 'EarningController@edit')->name('edit');
        Route::patch('/earnings/{earning}', 'EarningController@update');
        Route::delete('/earnings/{earning}', 'EarningController@destroy');
        Route::post('/earnings/{id}/restore', 'EarningController@restore');
    });

    Route::name('spendings.')->group(function () {
        Route::get('/spendings', 'SpendingController@index')->name('index');
        Route::get('/spendings/create', 'SpendingController@create')->name('create');
        Route::post('/spendings', 'SpendingController@store');
        Route::delete('/spendings/{spending}', 'SpendingController@destroy');
        Route::post('/spendings/{id}/restore', 'SpendingController@restore');
    });

    Route::resource('/recurrings', 'RecurringController')->only([
        'index',
        'create',
        'store',
        'show'
    ]);

    Route::resource('/tags', 'TagController')->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ]);

    Route::get('/reports', 'ReportController@index')->name('reports.index');
    Route::get('/reports/{slug}', 'ReportController@show');

    Route::name('imports.')->group(function () {
        Route::get('/imports', 'ImportController@index')->name('index');
        Route::get('/imports/create', 'ImportController@create')->name('create');
        Route::post('/imports', 'ImportController@store')->name('store');
        Route::get('/imports/{import}/prepare', 'ImportController@getPrepare')->name('prepare');
        Route::post('/imports/{import}/prepare', 'ImportController@postPrepare');
        Route::get('/imports/{import}/complete', 'ImportController@getComplete')->name('complete');
        Route::post('/imports/{import}/complete', 'ImportController@postComplete');
        Route::delete('/imports/{import}', 'ImportController@destroy');
    });

    Route::name('settings.')->group(function () {
        Route::get('/settings', 'SettingsController@getIndex')->name('index');
        Route::post('/settings', 'SettingsController@postIndex');
        Route::get('/settings/profile', 'SettingsController@getProfile')->name('profile');
        Route::get('/settings/account', 'SettingsController@getAccount')->name('account');
        Route::get('/settings/preferences', 'SettingsController@getPreferences')->name('preferences');
        Route::get('/settings/spaces', 'SettingsController@getSpaces')->name('spaces.index');
    });

    Route::get('/spaces/{id}', 'SpaceController');

    Route::name('ideas.')->group(function () {
        Route::get('/ideas/create', 'IdeaController@create')->name('create');
        Route::post('/ideas', 'IdeaController@store');
    });
});

Route::get('/logout', 'LogoutController@index')->name('logout');
