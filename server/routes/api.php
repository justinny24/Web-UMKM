<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Harus Login)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // --- FITUR KLIEN (UMKM/Siswa/Guru) ---
    Route::post('/consultations/book', [ConsultationController::class, 'book']); // Booking jadwal
    Route::get('/my-consultations', [ConsultationController::class, 'myConsultations']); // Lihat jadwal sendiri

    // --- FITUR DOSEN ---
    Route::get('/lecturer/requests', [ConsultationController::class, 'lecturerRequests']); // Lihat request masuk
    Route::patch('/lecturer/consultations/{id}/respond', [ConsultationController::class, 'respondRequest']); // Accept/Reject

    // --- FITUR ADMIN ---
    Route::patch('/admin/consultations/{id}/zoom', [ConsultationController::class, 'addZoomLink']); // Fasilitator Zoom
});