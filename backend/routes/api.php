<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GamificationController;
use App\Http\Controllers\MemorizationReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecitationController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::patch('auth/profile', [AuthController::class, 'update']);

    Route::apiResource('classrooms', ClassroomController::class);
    Route::post('classrooms/{classroom}/assign-teachers', [ClassroomController::class, 'assignTeacher']);
    Route::post('classrooms/{classroom}/enroll', [ClassroomController::class, 'enrollStudent']);

    Route::apiResource('assignments', AssignmentController::class);
    Route::post('assignments/{assignment}/feedback', [AssignmentController::class, 'feedback']);

    Route::get('recitations', [RecitationController::class, 'index']);
    Route::post('recitations', [RecitationController::class, 'store']);
    Route::post('recitations/{recitation}/score', [RecitationController::class, 'score']);

    Route::get('memorization/reviews', [MemorizationReviewController::class, 'index']);
    Route::post('memorization/reviews', [MemorizationReviewController::class, 'store']);
    Route::post('memorization/reviews/{review}/complete', [MemorizationReviewController::class, 'complete']);

    Route::get('gamification/leaderboard', [GamificationController::class, 'leaderboard']);
    Route::get('gamification/streaks', [GamificationController::class, 'streaks']);
    Route::get('gamification/badges', [GamificationController::class, 'badges']);
    Route::post('gamification/check-in', [GamificationController::class, 'checkIn']);

    Route::get('payments', [PaymentController::class, 'index']);
    Route::post('payments/initialize', [PaymentController::class, 'initialize']);
    Route::post('payments/{payment}/refund', [PaymentController::class, 'refund']);
});

Route::post('payments/webhook', [PaymentController::class, 'webhook']);
