<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));

//posts
Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
Route::get('storage/private/posts/{file}', function ($file) {
    $path = storage_path("app/private/public/posts/{$file}");

    if (file_exists($path)) {
        return Response::file($path);
    }

    abort(404);
});
