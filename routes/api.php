<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Middleware\JwtValidator;
use \App\Http\Controllers\WebsitesController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\WifiController;
use \App\Http\Controllers\CardsController;

Route::post('/sign-up', [AuthController::class, 'signUp']);
Route::post('/sign-in', [AuthController::class, 'signIn']);

Route::post('/website', [WebsitesController::class, 'CreateWebsiteCredential'])->middleware(JwtValidator::class);
Route::get('/website', [WebsitesController::class, 'ListWebsiteCredentials'])->middleware(JwtValidator::class);
Route::get('/website/{id}', [WebsitesController::class, 'getWebsiteCredential'])->middleware(JwtValidator::class);
Route::delete('/website/{id}', [WebsitesController::class, 'deleteWebsiteCredential'])->middleware(JwtValidator::class);

Route::post('/wifi', [WifiController::class, 'CreateWifiCredential'])->middleware(JwtValidator::class);
Route::get('/wifi', [WifiController::class, 'ListWifiCredentials'])->middleware(JwtValidator::class);
Route::get('/wifi/{id}', [WifiController::class, 'getWifiCredential'])->middleware(JwtValidator::class);
Route::delete('/wifi/{id}', [WifiController::class, 'deleteWifiCredential'])->middleware(JwtValidator::class);

Route::post('/card', [CardsController::class, 'CreateCardCredential'])->middleware(JwtValidator::class);
Route::get('/card', [CardsController::class, 'ListCardsCredentials'])->middleware(JwtValidator::class);
Route::get('/card/{id}', [CardsController::class, 'GetCardCredential'])->middleware(JwtValidator::class);
Route::delete('/card/{id}', [CardsController::class, 'DeleteCardCredential'])->middleware(JwtValidator::class);
