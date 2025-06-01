<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Api\catproducto_Controller;
use App\Http\Controllers\Api\emprendimiento_Controller;
use App\Http\Controllers\Api\feria_Controller;
use App\Http\Controllers\Api\feria_emprendimiento_Controller;
use App\Http\Controllers\Api\producto_controller;
use App\Http\Controllers\Api\UsuarioKeyController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\Categoria_EmprendimientoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InteraccionController;

use App\Http\Middleware\KeycloakAuth;

Route::post('/token-exchange', [AuthController::class, 'exchangeToken']);

// Categoria Productos -> rutas
Route::middleware([KeycloakAuth::class])->group(function () {
    Route::get('/categoria_productos', [catproducto_Controller::class, 'index']);
    Route::get('/categoria_productos/{nombre}', [catproducto_Controller::class, 'show']);
    Route::post('/categoria_productos', [catproducto_Controller::class, 'store']);
    Route::put('/categoria_productos/{nombre}', [catproducto_Controller::class, 'update']);
    Route::patch('/categoria_productos/{nombre}', [catproducto_Controller::class, 'updatePartial']);
    Route::delete('/categoria_productos/{nombre}', [catproducto_Controller::class, 'destroy']);
});

// Emprendimiento -> rutas
Route::get('/emprendimiento', [emprendimiento_Controller::class, 'index']);
Route::get('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'show']);
Route::post('/emprendimiento', [emprendimiento_Controller::class, 'store']);
Route::put('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'update']);
Route::patch('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'updatePartial']);
Route::delete('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'destroy']);

// Feria -> rutas
Route::get('/feria', [feria_Controller::class, 'index']);
Route::get('/feria/{id}', [feria_Controller::class, 'show']);
Route::post('/feria', [feria_Controller::class, 'store']);
Route::put('/feria/{id}', [feria_Controller::class, 'update']);
Route::patch('/feria/{id}', [feria_Controller::class, 'updatePartial']);
Route::delete('/feria/{id}', [feria_Controller::class, 'destroy']);

// Feria-Emprendimiento -> rutas
Route::get('/feria_emprendimiento', [feria_emprendimiento_Controller::class, 'index']);
Route::get('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'show']);
Route::post('/feria_emprendimiento', [feria_emprendimiento_Controller::class, 'store']);
Route::put('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'update']);
Route::patch('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'updatePartial']);
Route::delete('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'destroy']);

// Producto -> rutas
Route::get('/producto', [producto_controller::class, 'index']);
Route::get('/producto/{id}', [producto_controller::class, 'show']);
Route::post('/producto', [producto_controller::class, 'store']);
Route::put('/producto/{id}', [producto_controller::class, 'update']);
Route::patch('/producto/{id}', [producto_controller::class, 'updatePartial']);
Route::delete('/producto/{id}', [producto_controller::class, 'destroy']);

//Rutas usuario
Route::get('/user',[UsuarioController::class, 'index']);
Route::post('/user',[UsuarioController::class, 'store']);
Route::get('/user/{id}',[UsuarioController::class, 'show']);
Route::delete('/user/{id}',[UsuarioController::class, 'destroy']);
Route::put('/user/{id}',[UsuarioController::class, 'update']);
Route::patch('/user/{id}',[UsuarioController::class, 'updatePartial']);

//Rutas autenticacion usuario keycloak
Route::get('/user_key',[UsuarioKeyController::class, 'index']);
Route::get('/user_key/{id}', [UsuarioKeyController::class, 'show']);

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
