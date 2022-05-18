<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Jobs\NotifyCreatedProductJob;
use App\Models\User;
use App\Notifications\CreatedProductNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Authorize
 */
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

/**
 * Account action
 */
Route::group(['prefix' => '/account'], function(){
    Route::post('', [AccountController::class, 'registration']);
});

Route::get('/test', function (){
    $user = User::find(auth()->user()->id)->first();
    dd($user->role->name);
});

Route::group(['middleware' => 'jwt.auth'], function (){
    Route::get('/home', function (){
        return response()->json([
            'Message' => 'This our home!'
        ]);
    })->name('login');

    Route::middleware('auth')->get("/mail", function (Request $request){
        NotifyCreatedProductJob::dispatch("Article!", "dima.aratin@mail.ru");
    });
    Route::group(['prefix' => '/products'], function(){
        Route::get('', [ProductController::class, 'index'])->name('product.index');
        Route::middleware('validation.product')->post('', [ProductController::class, 'create'])
            ->name('product.create');
        Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });
});


