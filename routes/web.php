<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// use Laravel\Fortify\Features;
// use Livewire\Volt\Volt;

// Auth
Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'registerView']);
Route::post('/register', [AuthController::class, 'register']);

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:Admin,User')->name('dashboard');

//resident hak akses admin
Route::get('/resident', [ResidentController::class, 'index'])->middleware('role:Admin');
Route::get('/resident/create', [ResidentController::class, 'create'])->middleware('role:Admin');
Route::get('/resident/{id}', [ResidentController::class, 'edit'])->middleware('role:Admin');
Route::post('/resident', [ResidentController::class, 'store'])->middleware('role:Admin');
Route::put('/resident/{id}', [ResidentController::class, 'update'])->middleware('role:Admin');
Route::delete('/resident/{id}', [ResidentController::class, 'destroy'])->middleware('role:Admin');

//akun list
Route::get('/account-list', [UserController::class, 'account_list_view'])->middleware('role:Admin');

//akun request
Route::get('/account-request', [UserController::class, 'account_request_view'])->middleware('role:Admin');
Route::post('/account-request/approval/{id}', [UserController::class, 'account_approval'])->middleware('role:Admin');

//profil
Route::get('/profile', [UserController::class, 'profile_view'])->middleware('role:Admin,User')->name('profile.edit');
Route::post('/profile/{id}', [UserController::class, 'update_profile'])->middleware('role:Admin,User');
Route::get('/change-password', [UserController::class, 'change_password_view'])->middleware('role:Admin,User');
Route::post('/change-password/{id}', [UserController::class, 'change_password'])->middleware('role:Admin,User');

//complaint
Route::get('/complaint', [ComplaintController::class, 'index'])->middleware('role:Admin,User');
Route::get('/complaint/create', [ComplaintController::class, 'create'])->middleware('role:User');
Route::get('/complaint/{id}', [ComplaintController::class, 'edit'])->middleware('role:User');
Route::post('/complaint', [ComplaintController::class, 'store'])->middleware('role:User');
Route::put('/complaint/{id}', [ComplaintController::class, 'update'])->middleware('role:User');
Route::delete('/complaint/{id}', [ComplaintController::class, 'destroy'])->middleware('role:User');
Route::post('/complaint/update-status/{id}', [ComplaintController::class, 'update_status'])->middleware('role:Admin');

// Letter
Route::get('/letter', [LetterController::class, 'index'])->middleware('role:Admin,User');
Route::get('/letter/create', [LetterController::class, 'create'])->middleware('role:User');
Route::get('/letter/{id}', [LetterController::class, 'edit'])->middleware('role:User');
Route::post('/letter', [LetterController::class, 'store'])->middleware('role:User');
Route::put('/letter/{id}', [LetterController::class, 'update'])->middleware('role:User');
Route::delete('/letter/{id}', [LetterController::class, 'destroy'])->middleware('role:User');
Route::post('/letter/approve/{id}', [LetterController::class, 'approve'])->middleware('role:Admin');
Route::post('/letter/reject/{id}', [LetterController::class, 'reject'])->middleware('role:Admin');
Route::get('/letter/download/{id}', [LetterController::class, 'download'])->middleware('role:Admin,User');

//Announcement
Route::get('/announcement', [AnnouncementController::class, 'index'])->middleware('role:Admin,User');
Route::get('/announcement/create', [AnnouncementController::class, 'create'])->middleware('role:Admin');
Route::get('/announcement/{id}/edit', [AnnouncementController::class, 'edit'])->middleware('role:Admin');
Route::post('/announcement', [AnnouncementController::class, 'store'])->middleware('role:Admin');
Route::put('/announcement/{id}', [AnnouncementController::class, 'update'])->middleware('role:Admin');
Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy'])->middleware('role:Admin');
Route::post('/announcement/{id}/toggle-pin', [AnnouncementController::class, 'togglePin'])->middleware('role:Admin');