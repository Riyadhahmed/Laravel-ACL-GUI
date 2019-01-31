<?php


Route::resource('users', 'UserController');
Route::get('/allUser', 'UserController@allUser')->name('allUser.users');

Route::resource('permissions', 'PermissionController');
Route::get('/allPermission', 'PermissionController@allPermission')->name('allPermission.permissions');

Route::resource('roles', 'RoleController');
Route::get('/allRole', 'RoleController@allRole')->name('allRole.roles');


Route::resource('divisions', 'DivisionController');
Route::get('/getall', 'DivisionController@getAll')->name('getall.divisions');
Route::get('/permison', 'DivisionController@permison');

