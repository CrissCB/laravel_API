<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\catproducto_Controller;
use App\Http\Controllers\Api\emprendimiento_Controller;
use App\Http\Controllers\Api\feria_Controller;
use App\Http\Controllers\Api\feria_emprendimiento_Controller;
use App\Http\Controllers\Api\producto_controller;

// Categoria Productos -> rutas
Route::get('/categoria_productos', [catproducto_Controller::class, 'getAll']);
Route::get('/categoria_productos/{nombre}', [catproducto_Controller::class, 'getName']);
Route::post('/categoria_productos', [catproducto_Controller::class, 'add']);
Route::put('/categoria_productos/{nombre}', [catproducto_Controller::class, 'update']);
Route::patch('/categoria_productos/{nombre}', [catproducto_Controller::class, 'updatePartial']);
Route::delete('/categoria_productos/{nombre}', [catproducto_Controller::class, 'delete']);

// Emprendimiento -> rutas
Route::get('/emprendimiento', [emprendimiento_Controller::class, 'getAll']);
Route::get('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'getName']);
Route::post('/emprendimiento', [emprendimiento_Controller::class, 'add']);
Route::put('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'update']);
Route::patch('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'updatePartial']);
Route::delete('/emprendimiento/{nombre}', [emprendimiento_Controller::class, 'delete']);

// Feria -> rutas
Route::get('/feria', [feria_Controller::class, 'getAll']);
Route::get('/feria/{id}', [feria_Controller::class, 'getName']);
Route::post('/feria', [feria_Controller::class, 'add']);
Route::put('/feria/{id}', [feria_Controller::class, 'update']);
Route::patch('/feria/{id}', [feria_Controller::class, 'updatePartial']);
Route::delete('/feria/{id}', [feria_Controller::class, 'delete']);

// Feria-Emprendimiento -> rutas
Route::get('/feria_emprendimiento', [feria_emprendimiento_Controller::class, 'getAll']);
Route::get('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'getId']);
Route::post('/feria_emprendimiento', [feria_emprendimiento_Controller::class, 'add']);
Route::put('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'update']);
Route::patch('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'updatePartial']);
Route::delete('/feria_emprendimiento/{id}', [feria_emprendimiento_Controller::class, 'delete']);

// Producto -> rutas
Route::get('/producto', [producto_controller::class, 'getAll']);
Route::get('/producto/{id}', [producto_controller::class, 'getId']);
Route::post('/producto', [producto_controller::class, 'add']);
Route::put('/producto/{id}', [producto_controller::class, 'update']);
Route::patch('/producto/{id}', [producto_controller::class, 'updatePartial']);
Route::delete('/producto/{id}', [producto_controller::class, 'delete']);