<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student API

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::get('/{id}', [StudentController::class, 'show']);
    Route::post('/create', [StudentController::class, 'store']);
    Route::put('/update/{student}', [StudentController::class, 'update']);
    Route::delete('/delete/{student}', [StudentController::class, 'destroy']);
    Route::get('/class/{id}', [StudentController::class, 'showByClass']);
});

// Course API

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::get('/{id}', [CourseController::class, 'show']);
    Route::post('/create', [CourseController::class, 'store']);
    Route::put('/update/{course}', [CourseController::class, 'update']);
    Route::delete('/delete/{course}', [CourseController::class, 'destroy']);
    Route::get('/classes/{id}', [CourseController::class, 'showByCourse']);
});

// Class API

Route::prefix('classes')->group(function () {
    Route::get('/', [ClassController::class, 'index']);
    Route::get('/{id}', [ClassController::class, 'show']);
    Route::post('/create', [ClassController::class, 'store']);
    Route::put('/update/{class}', [ClassController::class, 'update']);
    Route::delete('/delete/{class}', [ClassController::class, 'destroy']);
});

// Account API

Route::prefix('accounts')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/{id}', [AccountController::class, 'show'])->middleware('auth:sanctum');;
    Route::post('/create', [AccountController::class, 'store']);
    Route::put('/update/{account}', [AccountController::class, 'update'])->middleware('auth:sanctum');;
    Route::delete('/delete/{account}', [AccountController::class, 'destroy'])->middleware('auth:sanctum');;
    Route::post('/login', [AccountController::class, 'login']);
});

// Post API

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{id}', [PostController::class, 'show']);
    Route::post('/create', [PostController::class, 'store']);
    Route::put('/update/{post}', [PostController::class, 'update']);
    Route::delete('/delete/{post}', [PostController::class, 'destroy']);
});

//middleware('auth:sanctum')->

// Upload Image API

Route::prefix('images')->group(function () {
    Route::post('/upload', [ImageController::class, 'imageUpload']);
});


Route::group(["namespace" => "Api"], function () {
    Route::post('signup', [ImageController::class, 'signup']);
    Route::post('login', [ImageController::class, 'login']);
});
