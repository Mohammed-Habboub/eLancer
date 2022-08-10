<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/home', function () {
    return view('home');
});

Route::group([
    'prefix' => '/dashboard',
    // 'as'     => 'categoris.'
    'middleware' => ['auth'],
], function(){
    // Route::resource('categoris', CategoriesController::class);

    Route::prefix('/categories')
    ->as('categoris.')
    ->group(function(){

        Route::get('/', [CategoriesController::class, 'index'])
            ->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])
            ->name('create');
        Route::get('/{category}', [CategoriesController::class, 'show'])
            ->name('show');
        Route::post('/', [CategoriesController::class, 'store'])
            ->name('store');
        Route::get('/{category}/edit', [CategoriesController::class, 'edit'])
            ->name('edit');
        Route::put('/{category}', [CategoriesController::class, 'update'])
            ->name('update');
        Route::delete('/{category}', [CategoriesController::class, 'destroy'])
            ->name('destroy');
            

    });
    
});


