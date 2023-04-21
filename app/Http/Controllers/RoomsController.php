<?php

namespace App\Http\Controllers;

use App\Classes\Queries;
use App\Classes\Response;
use App\Http\Requests\AddExpenseRequest;
use App\Http\Requests\AddGuestRequest;
use App\Http\Requests\AddPaymentRequest;
use App\Http\Requests\AddRefundRequest;
use App\Http\Requests\AddRoomRequest;
use App\Http\Requests\AddServiceRequest;


use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class RoomsController extends Controller
{
    //



    public function addNewGuest(AddGuestRequest $request)
    {

        try {
            Queries::addGuest($request);
            return Response::response(true, 'Guest added successfully.');
        } catch (Exception $ex) {
            return Response::response(false, 'Something went wrong.');
        }
    }

    public function addNewRoom(AddRoomRequest $request)
    {
        try {
            Queries::addRoom($request);
            return Response::response(true, 'Room added successfully.');
        } catch (Exception $ex) {

            return Response::response(false, 'Something went wrong.');
        }
    }

    public function addNewService(AddServiceRequest $request)
    {
        try {
            Queries::addService($request);
            return Response::response(true, 'Service added successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }

    public function addNewPayment(AddPaymentRequest $request)
    {

        try {
            Queries::addPayment($request);
            return Response::response(true, 'Payment added successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }

    public function addNewRefund(AddRefundRequest $request)
    {
        try {
            Queries::addRefund($request);
            return Response::response(true, 'Refund added successfully.');
        } catch (Exception $ex) {

            return Response::response(false, 'Something went wrong.');
        }
    }


    public function addNewExpense(AddExpenseRequest $request)
    {
        try {
            Queries::addExpense($request);
            return Response::response(true, 'Expense added successfully.');
        } catch (Exception $ex) {

            return Response::response(false, 'Something went wrong.');
        }
    }


    public function getAllGuests()
    {
        return Queries::getGuests();
    }

    public function getAllRooms()
    {
        return Queries::getRooms();
    }

    public function getRoomRentals()
    {
        return  Queries::getRentals();
    }

    public function getAllPayments()
    {
        return  Queries::getPayments();
    }
    public function getAllRefunds()
    {
        return  Queries::getRefunds();
    }
}
