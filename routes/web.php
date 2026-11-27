<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Route untuk Admin & Petugas (wajib login)
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));

    // Placeholder sementara sampai DashboardController dibuat oleh Rizal
Route::get('/dashboard', function () {
        $user = Auth::user();

        return 'Login berhasil sebagai <b>' . $user->name . '</b> (' . $user->role . ').'
            . '<br><br><a href="/users">Buka Manajemen User (Khusus Admin)</a>'
            . '<form action="' . route('logout') . '" method="POST" style="margin-top:12px;">'
            . csrf_field()
            . '<button type="submit">Logout</button>'
            . '</form>';
    })->name('dashboard');

    // --- BAGIAN HAKIM (feat/master-data) ---
    // Route::resource('categories', CategoryController::class)->except('show');
    // Route::resource('books', BookController::class);
    // Route::resource('members', MemberController::class);

    // --- BAGIAN RIZAL (feat/borrowing-dashboard) ---
    // Route::resource('borrowings', BorrowingController::class)->only(['index', 'create', 'store', 'show']);
    // Route::patch('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
});

// Route khusus ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});