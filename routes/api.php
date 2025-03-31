<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\Categoria_EmprendimientoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InteraccionController;

//Rutas usuario
Route::get('/user',[UsuarioController::class, 'index']);
Route::post('/user',[UsuarioController::class, 'store']);
Route::get('/user/{id}',[UsuarioController::class, 'show']);
Route::delete('/user/{id}',[UsuarioController::class, 'destroy']);
Route::put('/user/{id}',[UsuarioController::class, 'update']);
Route::patch('/user/{id}',[UsuarioController::class, 'updatePartial']);

//Rutas publicaciones
Route::get('/publicaciones',[PublicacionesController::class, 'index']);
Route::post('/publicaciones',[PublicacionesController::class, 'store']);
Route::get('/publicaciones/{id}',[PublicacionesController::class, 'show']);
Route::delete('/publicaciones/{id}',[PublicacionesController::class, 'destroy']);
Route::put('/publicaciones/{id}',[PublicacionesController::class, 'update']);
Route::patch('/publicaciones/{id}',[PublicacionesController::class, 'updatePartial']);

//Rutas categoria emprendimiento
Route::get('/categoria_emprendimiento',[Categoria_EmprendimientoController::class, 'index']);
Route::post('/categoria_emprendimiento',[Categoria_EmprendimientoController::class, 'store']);
Route::get('/categoria_emprendimiento/{id}',[Categoria_EmprendimientoController::class, 'show']);
Route::delete('/categoria_emprendimiento/{id}',[Categoria_EmprendimientoController::class, 'destroy']);
Route::put('/categoria_emprendimiento/{id}',[Categoria_EmprendimientoController::class, 'update']);
Route::patch('/categoria_emprendimiento/{id}',[Categoria_EmprendimientoController::class, 'updatePartial']);

//Rutas clientes
Route::get('/cliente',[ClienteController::class, 'index']);
Route::post('/cliente',[ClienteController::class, 'store']);
Route::get('/cliente/{id}',[ClienteController::class, 'show']);
Route::delete('/cliente/{id}',[ClienteController::class, 'destroy']);
Route::put('/cliente/{id}',[ClienteController::class, 'update']);
Route::patch('/cliente/{id}',[ClienteController::class, 'updatePartial']);

//Rutas interaccion
Route::get('/interaccion',[InteraccionController::class, 'index']);
Route::post('/interaccion',[InteraccionController::class, 'store']);
Route::get('/interaccion/{id}',[InteraccionController::class, 'show']);
Route::delete('/interaccion/{id}',[InteraccionController::class, 'destroy']);
Route::put('/interaccion/{id}',[InteraccionController::class, 'update']);
Route::patch('/interaccion/{id}',[InteraccionController::class, 'updatePartial']);

