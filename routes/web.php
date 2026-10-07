<?php

use App\Http\Controllers\AcceptInvitationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\InviteClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InviteController as AdminInviteController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard (redirects by role)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Invitation acceptance (guests only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/invitations/{token}', [InviteClientController::class, 'show'])
        ->name('invitations.show');

    Route::post('/invitations/{token}', [InviteClientController::class, 'store'])
        ->name('invitations.store');
});

/*
|--------------------------------------------------------------------------
| SuperAdmin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/invite-client', [InviteClientController::class, 'create'])
            ->name('invite-client');

        Route::post('/invite-client', [InviteClientController::class, 'store'])
            ->name('invite-client.store');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/invite', [AdminInviteController::class, 'create'])
            ->name('invite');

        Route::post('/invite', [AdminInviteController::class, 'store'])
            ->name('invite.store');
    });

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/dashboard', [MemberDashboardController::class, 'index'])
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('guest')->group(function () {
    Route::get('/invitations/{token}', [AcceptInvitationController::class, 'show'])
        ->name('invitations.show');

    Route::post('/invitations/{token}', [AcceptInvitationController::class, 'store'])
        ->name('invitations.store');
});

Route::middleware(['auth', 'verified', 'role:admin,member'])->group(function () {
    Route::post('/short-urls', [ShortUrlController::class, 'store'])
        ->name('short-urls.store');
});
Route::get('/{shortCode}', [ShortUrlController::class, 'redirect'])
    ->where('shortCode', '[A-Za-z0-9]{6}')
    ->name('short-urls.redirect');
require __DIR__.'/auth.php';

// Step 6: the public short URL redirect route goes HERE, LAST.