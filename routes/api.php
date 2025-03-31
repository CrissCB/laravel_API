<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\catproducto_Controller;
use App\Http\Controllers\Api\emprendimiento_Controller;
use App\Http\Controllers\Api\feria_Controller;
use App\Http\Controllers\Api\feria_emprendimiento_Controller;
use App\Http\Controllers\Api\producto_controller;

// Categoria Productos -> rutas
Route::get('/categoria_productos', [catproducto_Controller::class, 'index']);
Route::get('/categoria_productos/{nombre}', [catproducto_Controller::class, 'show']);
Route::post('/categoria_productos', [catproducto_Controller::class, 'store']);
Route::put('/categoria_productos/{nombre}', [catproducto_Controller::class, 'update']);
Route::patch('/categoria_productos/{nombre}', [catproducto_Controller::class, 'updatePartial']);
Route::delete('/categoria_productos/{nombre}', [catproducto_Controller::class, 'destroy']);

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