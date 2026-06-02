<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Admin routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Books CRUD
        Route::resource('books', BookController::class);
        Route::get('/api/books/search', [BookController::class, 'search'])->name('books.search');

        // Members CRUD
        Route::resource('members', MemberController::class);
        Route::get('/api/members/search', [MemberController::class, 'search'])->name('members.search');

        // Loans
        Route::resource('loans', LoanController::class);
        Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
    });

    // Member routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/member/dashboard', [DashboardController::class, 'memberDashboard'])->name('member.dashboard');
        Route::get('/member/loans', [LoanController::class, 'memberLoans'])->name('member.loans');
    });

    // Redirect based on role
    Route::get('/home', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('member.dashboard');
    })->name('home');
});

require __DIR__.'/auth.php';
