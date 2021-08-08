<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Webhook routes for your application. These
| routes are loaded by the RouteServiceProvider.
|
*/

Route::webhooks('payment-webhook', 'payments');
Route::webhooks('delivery-webhook', 'deliveries');
