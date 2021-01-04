<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::post('posts', [PostController::class, 'create']);
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/all', [PostController::class, 'all']);
Route::delete('posts/{posts}', [PostController::class, 'delete']);
Route::put('posts/{posts}', [PostController::class, 'update']);

Route::post('categories', [CategoryController::class, 'create']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/all', [CategoryController::class, 'all']);
Route::delete('categories/{categories}', [CategoryController::class, 'delete']);
Route::put('categories/{categories}', [CategoryController::class, 'update']);

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/me', MeController::class);
  Route::delete('/logout', LogoutController::class);

  Route::get('/permissions', [PermissionController::class, 'index']);
  Route::get('/permissions/all', [PermissionController::class, 'all']);
  Route::post('/permissions', [PermissionController::class, 'store']);
  Route::put('/permissions/{permissions}', [PermissionController::class, 'update']);
  Route::delete('/permissions/{permissions}', [PermissionController::class, 'delete']);

  Route::get('/roles', [RoleController::class, 'index']);
  Route::get('/roles/all', [RoleController::class, 'all']);
  Route::post('/roles', [RoleController::class, 'store']);
  Route::put('/roles/{roles}', [RoleController::class, 'update']);
  Route::delete('/roles/{roles}', [RoleController::class, 'delete']);

  Route::get('/users', [UserController::class, 'index']);
  Route::put('/users/{users}', [UserController::class, 'update']);
});
