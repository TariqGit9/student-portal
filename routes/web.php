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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => 'checkAdmin'], function () {
        Route::get('/', 'AdminController@admin')->name('home');
        Route::get('classes', 'AdminController@classes')->name('classes');
        Route::post('add-class', 'AdminController@addClass')->name('add-class');
        Route::get('/get-classes', 'AdminController@getClasses')->name('get-classes');
        Route::post('del-class', 'AdminController@deleteClass')->name('del-class');
        //subjects
        Route::get('subjects', 'AdminController@subjects')->name('subjects');
        Route::post('add-subject', 'AdminController@addSubject')->name('add-subject');
        Route::get('/get-subject', 'AdminController@getSubjects')->name('get-subject');
        Route::post('edit-subject', 'AdminController@editSubject')->name('edit-subject');
        Route::post('del-subject', 'AdminController@deleteSubject')->name('del-subject');
    });

        Route::group(['namespace' => 'Student', 'prefix' => 'student','middleware' => 'checkStudent'], function () {
            Route::get('/', 'StudentController@student')->name('home');
           
        });


            Route::group(['namespace' => 'Teacher', 'prefix' => 'teacher','middleware' => 'checkTeacher'], function () {
                Route::get('/', 'TeacherController@teacher')->name('home');

            });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
