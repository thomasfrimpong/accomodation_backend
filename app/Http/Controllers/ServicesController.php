<?php

namespace App\Http\Controllers;

use App\Classes\Data;
use App\Classes\Response;
use App\Http\Requests\DateSearchRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Requests\UpdateServiceRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServicesController extends Controller
{
    //
    public function updateGuestInfo(UpdateGuestRequest $request)
    {
        try {

            Data::updateGuest($request);
            return Response::response(true, 'Guest details updated successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }


    public function updateRoomInfo(UpdateRoomRequest $request)
    {


        try {

            Data::updateRoom($request);
            return Response::response(true, 'Room details updated successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }
    public function  updateServiceInfo(UpdateServiceRequest $request)
    {


        try {

            Data::updateService($request);
            return Response::response(true, 'Room details updated successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }



    public function  invalidatePayment($id)
    {


        try {

            Data::makePaymentInvalid($id);
            return Response::response(true, 'Payment invalidated successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }


    public function  invalidateRefund($id)
    {

        try {

            Data::makeRefundInvalid($id);
            return Response::response(true, 'Refund invalidated successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }




    public function  invalidateExpense($id)
    {

        try {

            Data::makeExpenseInvalid($id);
            return Response::response(true, 'Expense invalidated successfully.');
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
            return Response::response(false, 'Something went wrong.');
        }
    }


    public function listOfAvailableRooms()
    {
        return Data::availableRooms();
    }

    public function filterAllUsers(SearchRequest $request)
    {

        return Data::filterUsers($request->search);
    }

    public function filterAllGuests(SearchRequest $request)
    {

        return Data::filterGuests($request->search);
    }

    public function filterGuestsByDateAdded(DateSearchRequest $request)
    {
        return Data::filterGuestsByDate($request);
    }


    public function filterRentByPeriod(DateSearchRequest $request)
    {
        return Data::filterRentPeriod($request);
    }

    public function  filterRentByUser(SearchRequest $request)
    {

        return Data::filterRentByUser($request->search);
    }

    public function filterGuestsByUser(SearchRequest $request)
    {
        return Data::filterGuestsByUser($request->search);
    }

    public function filterPaymentByUser(SearchRequest $request)
    {
        return Data::filterPaymentByUser($request->search);
    }

    public function filterRefundByUser(SearchRequest $request)
    {
        return Data::filterRefundByUser($request->search);
    }


    public function filterPaymentByDate(SearchRequest $request)
    {
        return Data::filterPaymentByDate($request->search);
    }

    public function filterRefundByDate(SearchRequest $request)
    {
        return Data::filterRefundByDate($request->search);
    }
}
