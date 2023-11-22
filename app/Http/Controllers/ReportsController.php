<?php

namespace App\Http\Controllers;

use App\Classes\Data;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function sumOfExpenses(Request $request)
    {
        return Data::totalExpenses($request);
    }


    public function sumOfPayments(Request $request)
    {
        return Data::totalPayments($request);
    }


    public function sumOfRefunds(Request $request)
    {
        return Data::totalRefunds($request);
    }

    public function numberOfGuests(Request $request)
    {
        return Data::countOfGuests($request);
    }

    public function numberOfRentals(Request $request)
    {
        return Data::countOfRentals($request);
    }

    public function checkOutGuest()
    {
    }
}
