<?php

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

use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get(
    '/',
    function () {
        return redirect()->route('groups.index');
    }
);
Route::get('/social-auth/{provider}',
           ['as' => 'social_auth', 'uses' => 'Auth\LoginController@redirectToProvider']);
Route::get(
    '/social-auth/{provider}/callback',
    ['as' => 'social_callback', 'uses' => 'Auth\LoginController@handleProviderCallback']
);
Route::post('report-bug', 'ReportController@create')->name('report_bug');
Route::get('lk', 'LkController@index')->name('lk')->middleware('auth');
Route::group(
    ['prefix' => 'groups', 'middleware' => 'auth'],
    function () {
        Route::get('/', 'GroupsController@index')->name('groups.index');
        Route::get('/{group_id}/tasks', 'TaskController@index')->name('groups.tasks');
        Route::get('/tasks/{id}', 'TaskController@show')->name('tasks.show');
        Route::get('/tasks/next/{id}', 'TaskController@nextTask')->name('tasks.next');
        Route::post('/tasks/{id}/check_answer', 'TaskController@checkAnswer')->name(
            'tasks.check_answers'
        );
    }
);
Route::get(
    '/test',
    function () {
        $matrix = [
            [0, 0, 1, 1, 0],
            [0, 0, 1, 1, 0],
            [1, 1, 0, 0, 0],
            [1, 1, 0, 0, 1],
            [0, 0, 0, 1, 0],
        ];
        $alpha = getAlpha();
        return \App\Http\Controllers\Tasks\GD_Task::generateGraphImg($matrix, $alpha);
    }
);