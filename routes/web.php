<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* |-------------------------------------------------------------------------- | Authenticated User Dashboard |-------------------------------------------------------------------------- */
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('user.dashboard');

        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');    });

/* |-------------------------------------------------------------------------- | Service Provider Dashboard |-------------------------------------------------------------------------- */
Route::middleware(['auth', 'service_provider'])->group(function () {

    Route::get('/service-provider/dashboard', function () {
            return view('service_provider.dashboard');
        }
        )->name('service-provider.dashboard');

        // Services Management
        Route::get('/service-provider/services', [App\Http\Controllers\ServiceProviderServiceController::class , 'index'])->name('service-provider.services.index');
        Route::post('/service-provider/services', [App\Http\Controllers\ServiceProviderServiceController::class , 'store'])->name('service-provider.services.store');    });

require __DIR__ . '/auth.php';
