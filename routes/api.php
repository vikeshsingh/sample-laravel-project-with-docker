<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Routing\Route;

Route::apiResource('documents', DocumentController::class);
