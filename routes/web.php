<?php

use App\Controllers\HomeController;
use App\Controllers\PaymentController;
use App\Controllers\RegisterController;

$app->get('/', HomeController::class)->setName('home');
$app->get('/register', [RegisterController::class, 'index'])->setName('register');
$app->get('/payment', [PaymentController::class, 'index'])->setName('payment.index');
$app->post('/payment', [PaymentController::class, 'store'])->setName('payment.store');