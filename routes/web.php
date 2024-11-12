<?php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use  App\Http\Controllers\Backend\AuthController;
    use  App\Http\Controllers\Backend\DashboardController;

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
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', function () {
            return view('login');
        });
        Route::post('/login', [AuthController::class, 'login'])->name('login');    
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::get('/chage-password', [AuthController::class, 'changePassword'])->name('changePassword');
        Route::post('/chage-password', [AuthController::class, 'saveChangePassword'])->name('saveChangePassword');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
    Route::get('logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');   

