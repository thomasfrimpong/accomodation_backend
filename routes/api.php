<?php

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//create apis
Route::post('/add/user', [UserController::class, 'addUser']);

Route::post('/login/user', [UserController::class, 'loginUser']);

Route::post('/add/new/guest', [RoomsController::class, 'addNewGuest']);

Route::post('/add/new/room', [RoomsController::class, 'addNewRoom']);

Route::post('/add/new/service', [RoomsController::class, 'addNewService']);

Route::post('/add/new/payment', [RoomsController::class, 'addNewPayment']);

Route::post('/add/new/refund', [RoomsController::class, 'addNewRefund']);

Route::post('/add/new/expense', [RoomsController::class, 'addNewExpense']);



//Read apis
Route::get('/get/all/users', [UserController::class, 'getAllUsers']);

Route::get('/get/all/guests', [RoomsController::class, 'getAllGuests']);

Route::get('/get/all/rooms', [RoomsController::class, 'getAllRooms']);

Route::get('/get/room/rentals', [RoomsController::class, 'getRoomRentals']);

Route::get('/get/all/payments', [RoomsController::class, 'getAllPayments']);

Route::get('/get/all/refunds', [RoomsController::class, 'getAllRefunds']);

//Update apis
Route::post('/update/user/info', [UserController::class, 'updateUserInfo']);

Route::post('/update/guest/info', [ServicesController::class, 'updateGuestInfo']);

Route::post('/update/room/info', [ServicesController::class, 'updateRoomInfo']);

Route::post('/update/service/info', [ServicesController::class, 'updateServiceInfo']);

Route::get('/invalidate/payment/{id}', [ServicesController::class, 'invalidatePayment']);

Route::get('/invalidate/refund/{id}', [ServicesController::class, 'invalidateRefund']);

Route::get('/invalidate/expense/{id}', [ServicesController::class, 'invalidateExpense']);

//filter apis
Route::post('/filter/all/users', [ServicesController::class, 'filterAllUsers']);

Route::post('/filter/all/guests', [ServicesController::class, 'filterAllGuests']);

Route::post('/filter/guests/by/date/added', [ServicesController::class, 'filterGuestsByDateAdded']);

Route::post('/filter/rent/by/period', [ServicesController::class, 'filterRentByPeriod']);

Route::post('/filter/rent/by/user', [ServicesController::class, 'filterRentByUser']);

Route::post('/filter/guests/by/user', [ServicesController::class, 'filterGuestsByUser']);

Route::post('/filter/payment/by/user', [ServicesController::class, 'filterPaymentByUser']);

Route::post('/filter/refund/by/user', [ServicesController::class, 'filterRefundByUser']);

Route::post('/filter/payment/by/date', [ServicesController::class, 'filterPaymentByDate']);

Route::post('/filter/refund/by/date', [ServicesController::class, 'filterRefundByDate']);


//reports api
Route::post('/sum/of/expenses', [ReportsController::class, 'sumOfExpenses']);

Route::post('/sum/of/payments', [ReportsController::class, 'sumOfPayments']);

Route::post('/sum/of/refunds', [ReportsController::class, 'sumOfRefunds']);

Route::post('/number/of/guests', [ReportsController::class, 'numberOfGuests']);

Route::post('/number/of/rentals', [ReportsController::class, 'numberOfRentals']);

Route::get('/list/of/available/rooms', [ServicesController::class, 'listOfAvailableRooms']);
