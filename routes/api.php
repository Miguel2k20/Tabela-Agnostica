<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleDefinition;
use App\Http\Controllers\DynamicRecord;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/module', [ModuleDefinition::class, 'store']);
Route::delete("/module/{module}", [ModuleDefinition::class, 'delete']);
Route::put("/module/{module}", [ModuleDefinition::class, 'update']);
Route::get('/modules', [ModuleDefinition::class, 'index']);

Route::post('/dynamic-record/{module}', [DynamicRecord::class, 'store']);
