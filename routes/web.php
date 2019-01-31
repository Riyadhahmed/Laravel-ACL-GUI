<?php


Route::get('/', function () {
   return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
  'namespace' => 'Backend',
  'prefix' => 'admin',
  'as' => 'admin.',
  'middleware' => 'auth'],
  function () {
     require base_path('routes/backend/admin.php');
  });
