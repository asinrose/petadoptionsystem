<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/services/{service}', [App\Http\Controllers\PublicServiceController::class , 'show'])->name('services.show');

/* |-------------------------------------------------------------------------- | Authenticated User Dashboard |-------------------------------------------------------------------------- */
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('user.dashboard');

        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

        Route::get('/pethome', [App\Http\Controllers\PetHomeController::class , 'index'])->name('pethome');
        Route::post('/adoption/{pet}', [App\Http\Controllers\AdoptionController::class , 'store'])->name('adoption.store');

        // Pet Management
        Route::get('/pets/{pet}/details', [App\Http\Controllers\PetController::class , 'show'])->name('pets.show');
        Route::get('/pets/create', [App\Http\Controllers\PetController::class , 'create'])->name('pets.create');
        Route::post('/pets', [App\Http\Controllers\PetController::class , 'store'])->name('pets.store');
        Route::get('/my-pets', [App\Http\Controllers\PetController::class , 'myPets'])->name('pets.my_pets');
        Route::delete('/pets/{pet}', [App\Http\Controllers\PetController::class , 'destroy'])->name('pets.destroy');

        // Service List & Booking
        Route::get('/services-list', [App\Http\Controllers\ServiceListController::class , 'index'])->name('services.index');
        Route::post('/services/book', [App\Http\Controllers\ServiceListController::class , 'book'])->name('services.book');

        // Community
        Route::get('/community', [App\Http\Controllers\CommunityController::class , 'index'])->name('community.index');
        Route::post('/community', [App\Http\Controllers\CommunityController::class , 'store'])->name('community.store');
        Route::post('/community/{post}/comment', [App\Http\Controllers\CommunityController::class , 'comment'])->name('community.comment');
        Route::post('/community/{post}/like', [App\Http\Controllers\CommunityController::class , 'toggleLike'])->name('community.like');

        // Favorites
        Route::post('/favorites/{pet}', [App\Http\Controllers\FavoriteController::class , 'toggle'])->name('favorite.toggle');
        Route::get('/profile/favorites', [App\Http\Controllers\FavoriteController::class , 'index'])->name('profile.favorites');

        // Adoption Applications
        Route::get('/profile/adoption-applications', [App\Http\Controllers\AdoptionController::class , 'applications'])->name('profile.applications');

        // Booked Services
        Route::get('/profile/booked-services', [ProfileController::class , 'bookedServices'])->name('profile.booked_services');
    });

/* |-------------------------------------------------------------------------- | Service Provider Dashboard |-------------------------------------------------------------------------- */
Route::middleware(['auth', 'service_provider'])->group(function () {

    Route::get('/service-provider/dashboard', [\App\Http\Controllers\ServiceProviderDashboardController::class , 'index'])->name('service-provider.dashboard');
    Route::post('/service-provider/bookings/{booking}/confirm', [\App\Http\Controllers\ServiceProviderDashboardController::class , 'confirmBooking'])->name('service-provider.bookings.confirm');

    // Services Management
    Route::get('/service-provider/services', [App\Http\Controllers\ServiceProviderServiceController::class , 'index'])->name('service-provider.services.index');
    Route::post('/service-provider/services', [App\Http\Controllers\ServiceProviderServiceController::class , 'store'])->name('service-provider.services.store');
});

/* |-------------------------------------------------------------------------- | Admin Dashboard |-------------------------------------------------------------------------- */
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class , 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class , 'users'])->name('admin.users');
    Route::get('/admin/pets', [App\Http\Controllers\AdminController::class , 'pets'])->name('admin.pets');
    Route::delete('/admin/pets/{pet}', [App\Http\Controllers\AdminController::class , 'destroyPet'])->name('admin.pets.destroy');
    Route::patch('/admin/pets/{pet}/status', [App\Http\Controllers\AdminController::class , 'updatePetStatus'])->name('admin.pets.update_status');
});

require __DIR__ . '/auth.php';
