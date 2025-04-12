<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

Route::group(['middleware' => ['api']], function () {
    Route::get('/product/{id}', [ProductController::class, 'show']);
});

