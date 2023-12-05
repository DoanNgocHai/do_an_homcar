<?php

use App\Http\Controllers\Admin\Branch\BranchController as AdminBranchController;
use App\Http\Controllers\Admin\Category\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Transaction\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\User\UserController as AdminUserController;
use App\Http\Controllers\Admin\Vehicle\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\Car\CarController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Branch\BranchController;
use App\Http\Controllers\Color\ColorController;
use App\Http\Controllers\Common\UploadFileController;
use App\Http\Controllers\Figure\FigureController;
use App\Http\Controllers\Gear\GearController;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\Car\CarController as UserCarController;
use App\Http\Controllers\User\Favorite\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('upload-file', [UploadFileController::class, 'uploadFile']);

Route::prefix('taxonomy')->group(function () {
    Route::get('brands', [BranchController::class, 'index']);
    Route::get('figures', [FigureController::class, 'index']);
    Route::get('gears', [GearController::class, 'index']);
    Route::get('colors', [ColorController::class, 'index']);
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::get('verify', [AuthController::class, 'verify']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(['auth:api'])->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'getProfile']);
        Route::put('', [ProfileController::class, 'updateProfile']);
    });

    Route::prefix('user')->group(function () {
        Route::resource('cars', UserCarController::class);
        Route::get('history-sale', [UserCarController::class, 'HistorySaleCar']);
        Route::resource('favorites', FavoriteController::class);
    });

    Route::prefix('transaction')->group(function () {
        Route::resource('rest', TransactionController::class);

        Route::get('history/sale-car', [TransactionController::class, 'historySaleCar']);
        Route::get('history/buy-car', [TransactionController::class, 'historyBuyCar']);

        Route::post('seller/confirm/{id}', [TransactionController::class, 'sellerConfirm']);

        Route::post('buyer/approve/{id}', [TransactionController::class, 'buyerApprove']);
        Route::post('buyer/refuse/{id}', [TransactionController::class, 'buyerRefuse']);

        Route::post('seller/approve/{id}', [TransactionController::class, 'sellerApprove']);
        Route::post('seller/refuse/{id}', [TransactionController::class, 'sellerRefuse']);

        Route::post('done-transaction/{id}', [TransactionController::class, 'doneTransaction']);

        Route::get('history-transaction-buyer', [TransactionController::class, 'HistoryTransactionBuyer']);
        Route::get('history-transaction-seller', [TransactionController::class, 'HistoryTransactionSeller']);
    });
});

Route::prefix('anonymous')->group(function () {
    Route::get('list_cars', [UserCarController::class, 'getCars']);
    Route::get('info_cars', [UserCarController::class, 'infoCar']);
});

Route::prefix('admin')->middleware(['auth:api'])->group(function () {
    Route::resource('brand', AdminBranchController::class);
    Route::resource('category', AdminCategoryController::class);
    Route::resource('transaction', AdminTransactionController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('car', CarController::class);
    Route::post('verify/{id}', [CarController::class, 'adminVerify']);

});

Route::prefix('mail')->group(function () {
    Route::get('register', [MailController::class, 'register']);
    Route::get('verify', [MailController::class, 'verify']);
});
