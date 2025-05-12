<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubMemberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register/student', [AuthController::class, 'showStudentRegistrationForm'])->name('register.student');
Route::post('/register/student', [AuthController::class, 'registerStudent']);
Route::get('/register/club', [AuthController::class, 'showClubRegistrationForm'])->name('register.club');
Route::post('/register/club', [AuthController::class, 'registerClub']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/club/dashboard', [ClubController::class, 'dashboard'])->name('club.dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Event Routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/pre-register', [EventController::class, 'preRegister'])->name('events.pre-register');
    Route::get('/events/{event}/participants', [EventController::class, 'showParticipants'])->name('events.participants');

    // Review Routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{event}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/events/{event}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Admin-only Routes
    Route::middleware(['admin'])->group(function () {
        Route::post('/events/{event}/approve', [EventController::class, 'approve'])->name('events.approve');
        Route::post('/events/{event}/reject', [EventController::class, 'reject'])->name('events.reject');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

    // Room routes
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::delete('/rooms/{booking}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Admin-only Room routes
    Route::middleware(['admin'])->group(function () {
        Route::post('/rooms/{booking}/approve', [RoomController::class, 'approve'])->name('rooms.approve');
        Route::post('/rooms/{booking}/reject', [RoomController::class, 'reject'])->name('rooms.reject');
    });

    // Club Membership Routes
    Route::post('/clubs/{club}/apply', [ClubMemberController::class, 'apply'])->name('clubs.apply');
    Route::get('/my-applications', [ClubMemberController::class, 'myApplications'])->name('my.applications');
    Route::get('/pending-applications', [ClubMemberController::class, 'pendingApplications'])->name('pending.applications');
    Route::post('/members/{member}/approve', [ClubMemberController::class, 'approve'])->name('members.approve');
    Route::post('/members/{member}/reject', [ClubMemberController::class, 'reject'])->name('members.reject');
    Route::post('/members/{member}/promote', [ClubMemberController::class, 'promote'])->name('members.promote');
});

// Public Routes
Route::get('/events/upcoming', [EventController::class, 'upcoming'])->name('events.upcoming');
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/clubs/{club}', [ClubController::class, 'show'])->name('clubs.show');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
