<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleDefinition;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/module', [ModuleDefinition::class, 'store']);
Route::delete("/module/{module}", [ModuleDefinition::class, 'delete']);
Route::put("/module/{module}", [ModuleDefinition::class, 'update']);
Route::get('/modules', [ModuleDefinition::class, 'index']);

route::get("/teste", function (Request $request) {
    dd($request->all());
});