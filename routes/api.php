<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\WahanaController;
use App\Controllers\ReviewController;
use App\Controllers\PesanController;
use App\Controllers\AdminController;
use App\Controllers\UploadController;

// =====================
// AUTH ROUTES
// =====================
$router->post('/api/auth/login',    [AuthController::class, 'login']);
$router->post('/api/auth/register', [AuthController::class, 'register']);
$router->post('/api/auth/logout',   [AuthController::class, 'logout']);
$router->get('/api/auth/me',        [AuthController::class, 'me']);

// =====================
// USER ROUTES
// =====================
$router->get('/api/user/profile',         [UserController::class, 'profile']);
$router->put('/api/user/profile',         [UserController::class, 'updateProfile']);
$router->put('/api/user/change-password', [UserController::class, 'changePassword']);

// =====================
// WAHANA ROUTES
// =====================
$router->get('/api/wahana',      [WahanaController::class, 'index']);
$router->get('/api/wahana/{id}', [WahanaController::class, 'show']);

// =====================
// REVIEW ROUTES
// =====================
$router->get('/api/review',          [ReviewController::class, 'index']);
$router->post('/api/review',         [ReviewController::class, 'store']);
$router->delete('/api/review/{id}',  [ReviewController::class, 'destroy']);

// =====================
// PESAN ROUTES (public)
// =====================
$router->post('/api/pesan', [PesanController::class, 'store']);

// =====================
// ADMIN ROUTES
// =====================
$router->get('/api/admin/dashboard',          [AdminController::class, 'dashboard']);
$router->get('/api/admin/users',              [AdminController::class, 'users']);
$router->delete('/api/admin/users/{id}',      [AdminController::class, 'deleteUser']);
$router->get('/api/admin/wahana',             [AdminController::class, 'wahana']);
$router->post('/api/admin/wahana',            [AdminController::class, 'createWahana']);
$router->put('/api/admin/wahana/{id}',        [AdminController::class, 'updateWahana']);
$router->delete('/api/admin/wahana/{id}',     [AdminController::class, 'deleteWahana']);
$router->get('/api/admin/review',             [AdminController::class, 'review']);
$router->delete('/api/admin/review/{id}',     [AdminController::class, 'deleteReview']);

// =====================
// UPLOAD ROUTE (admin)
// =====================
$router->post('/api/admin/upload', [UploadController::class, 'image']);

// =====================
// ADMIN PESAN ROUTES
// =====================
$router->get('/api/admin/pesan',              [PesanController::class, 'index']);
$router->put('/api/admin/pesan/{id}/baca',    [PesanController::class, 'tandaiBaca']);
$router->delete('/api/admin/pesan/{id}',      [PesanController::class, 'destroy']);