<?php

use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SellerController;

Route::apiResource('sellers', SellerController::class);

Route::apiResource('sales', SaleController::class)->only(['index', 'store']);

Route::get('sellers/{seller}/sales', [SellerController::class, 'sales']);

Route::post('sellers/{seller}/resend-report', [SellerController::class, 'resendReport']);
