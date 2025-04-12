<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

Route::group(['middleware' => ['api']], function () {
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
});

