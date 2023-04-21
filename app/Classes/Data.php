<?php

namespace App\Classes;

use App\Models\Expense;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Room;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Data
{

    public static function updateUser($data)
    {
        $user = User::find($data->id);
        $user->first_name = $data->first_name;
        $user->other_names = $data->other_names;
        $user->phone_number = $data->phone_number;
        $user->employee_id = $data->employee_id;
        $user->role = $data->role;
        $user->save();
    }

    public static function updateGuest($data)
    {
        $guest = Guest::find($data->id);
        $guest->first_name = $data->first_name;
        $guest->other_names = $data->other_names;
        $guest->phone_number = $data->phone_number;
        $guest->email = $data->email;
        $guest->advert = $data->advert;
        $guest->save();
    }

    public static function updateRoom($data)
    {

        $room = Room::find($data->id);

        $room->room_number = $data->room_number;
        $room->price_of_room = $data->cost_of_room;
        $room->percentage_discount = $data->percentage_discount;
        $room->state_of_occupancy = $data->state_of_occupancy;
        $room->percentage_discount = $data->percentage_discount;
        $room->date_of_availability = $data->date_of_availability;
        $room->save();
    }

    public static function updateService($data)
    {
        $service = Service::find($data->id);
        $service->start_of_residence = $data->start_of_residence;
        $service->end_of_residence = $data->end_of_residence;
        $service->duration_extended = $data->duration_extended;
        $service->duration_reduced = $data->duration_reduced;
        $service->is_reserved = $data->is_reserved;
        $service->save();
    }

    public static function makePaymentInvalid($id)
    {
        $payment = Payment::find($id);
        $payment->is_invalid = true;
        $payment->save();
    }

    public static function  makeRefundInvalid($id)
    {
        $refund = Refund::find($id);
        $refund->is_invalid = true;
        $refund->save();
    }

    public static function makeExpenseInvalid($id)
    {
        $refund = Expense::find($id);
        $refund->is_invalid = true;
        $refund->save();
    }


    public static function filterUsers($data)
    {
        $users = User::where('first_name', 'like', "%$data%")
            ->orWhere('other_names', 'like', "%$data%")
            ->orWhere('employee_id', 'like', "%$data%")
            ->orWhere('phone_number', 'like', "%$data%")
            ->select('first_name', 'other_names', 'phone_number', 'employee_id', 'role', 'email')
            ->get();

        return $users;
    }


    public static function  filterGuests($data)
    {
        $guests = Guest::where('first_name', 'like', "%$data%")
            ->orWhere('other_names', 'like', "%$data%")
            ->orWhere('advert', 'like', "%$data%")
            ->orWhere('phone_number', 'like', "%$data%")
            ->select('first_name', 'other_names', 'phone_number',  'email', 'advert')
            ->get();

        return $guests;
    }

    public static function filterGuestsByDate($data)
    {

        $guests = Guest::whereDate("guests.created_at", '>=', $data->start_date)
            ->whereDate("guests.created_at", '<=', $data->end_date)
            ->select('first_name', 'other_names', 'phone_number',  'email', 'advert')
            ->get();

        return $guests;
    }

    public static function filterRentPeriod($data)
    {

        $services = Service::whereDate("services.start_of_residence", '>=', $data->start_date)
            ->whereDate("services.end_of_residence", '<=', $data->end_date)
            ->join('guests', 'guests.id', '=', 'services.guest_id')
            ->join('rooms', 'rooms.id', '=', 'services.room_id')
            ->join('users', 'users.id', '=', 'services.added_by')
            ->select('start_of_residence', 'end_of_residence', 'guests.first_name as guest_first_name', 'guests.other_names as guest_other_names', 'guests.phone_number', 'users.first_name as user_first_name', 'users.other_names as user_other_names', 'rooms.room_number', 'rooms.price_of_room')
            ->get();

        return $services;
    }

    public static function filterRentByUser($search)
    {

        $services = Service::where("services.added_by", $search)
            ->join('guests', 'guests.id', '=', 'services.guest_id')
            ->join('rooms', 'rooms.id', '=', 'services.room_id')
            ->join('users', 'users.id', '=', 'services.added_by')
            ->select('start_of_residence', 'end_of_residence', 'guests.first_name as guest_first_name', 'guests.other_names as guest_other_names', 'guests.phone_number', 'users.first_name as user_first_name', 'users.other_names as user_other_names', 'rooms.room_number', 'rooms.price_of_room')
            ->get();

        return $services;
    }

    public static function filterGuestsByUser($search)
    {

        $guests = Guest::where("guests.added_by", $search)

            ->select('first_name', 'other_names', 'phone_number',  'email', 'advert')
            ->get();

        return $guests;
    }

    public static function  filterPaymentByUser($search)
    {

        $payments = Payment::where("payments.added_by", $search)
            ->join('services', 'services.id', '=', 'payments.service_id')
            ->join('guests', 'guests.id', '=', 'payments.guest_id')
            ->join('rooms', 'rooms.id', '=', 'payments.room_id')
            ->join('users', 'users.id', '=', 'payments.added_by')
            ->select('services.start_of_residence', 'services.end_of_residence', 'guests.first_name as guest_first_name', 'guests.other_names as guest_other_names', 'guests.phone_number', 'users.first_name as user_first_name', 'users.other_names as user_other_names', 'rooms.room_number', 'rooms.price_of_room', 'payments.amount')
            ->get();

        return $payments;
    }


    public static function  filterRefundByUser($search)
    {

        $payments = Refund::where("refunds.added_by", $search)
            ->join('services', 'services.id', '=', 'refunds.service_id')
            ->join('guests', 'guests.id', '=', 'refunds.guest_id')
            ->join('rooms', 'rooms.id', '=', 'refunds.room_id')
            ->join('users', 'users.id', '=', 'refunds.added_by')
            ->select('services.start_of_residence', 'services.end_of_residence', 'guests.first_name as guest_first_name', 'guests.other_names as guest_other_names', 'guests.phone_number', 'users.first_name as user_first_name', 'users.other_names as user_other_names', 'rooms.room_number', 'rooms.price_of_room', 'refunds.amount')
            ->get();

        return $payments;
    }

    public static function filterPaymentByDate($search)
    {
        $payments = Payment::whereDate("payments.created_at", $search)
            ->join('services', 'services.id', '=', 'payments.service_id')
            ->join('guests', 'guests.id', '=', 'payments.guest_id')
            ->join('rooms', 'rooms.id', '=', 'payments.room_id')
            ->join('users', 'users.id', '=', 'payments.added_by')
            ->select('services.start_of_residence', 'services.end_of_residence', 'guests.first_name as guest_first_name', 'guests.other_names as guest_other_names', 'guests.phone_number', 'users.first_name as user_first_name', 'users.other_names as user_other_names', 'rooms.room_number', 'rooms.price_of_room', 'payments.amount')
            ->get();

        return $payments;
    }


    public static function  filterRefundByDate($search)
    {

        $payments = Refund::whereDate("refunds.created_at", $search)
            ->join('services', 'services.id', '=', 'refunds.service_id')
            ->join('guests', 'guests.id', '=', 'refunds.guest_id')
            ->join('rooms', 'rooms.id', '=', 'refunds.room_id')
            ->join('users', 'users.id', '=', 'refunds.added_by')
            ->select('services.start_of_residence', 'services.end_of_residence', 'guests.first_name as guest_first_name', 'guests.other_names as guest_other_names', 'guests.phone_number', 'users.first_name as user_first_name', 'users.other_names as user_other_names', 'rooms.room_number', 'rooms.price_of_room', 'refunds.amount')
            ->get();

        return $payments;
    }

    public static function totalExpenses($data)
    {
        $total_expenses = Expense::whereDate("expenses.created_at", '>=', $data->start_date)
            ->whereDate("expenses.created_at", '<=', $data->end_date)
            ->sum('amount_involved');
        return $total_expenses;
    }

    public static function totalPayments($data)
    {
        $total_payments = Payment::whereDate("payments.created_at", '>=', $data->start_date)
            ->whereDate("payments.created_at", '<=', $data->end_date)
            ->sum('amount');
        return $total_payments;
    }

    public static function totalRefunds($data)
    {
        $total_payments = Refund::whereDate("refunds.created_at", '>=', $data->start_date)
            ->whereDate("refunds.created_at", '<=', $data->end_date)
            ->sum('amount');
        return  $total_payments;
    }

    public static function countOfGuests($data)
    {
        $count_of_guests = Guest::whereDate("guests.created_at", '>=', $data->start_date)
            ->whereDate("guests.created_at", '<=', $data->end_date)
            ->count();
        return  $count_of_guests;
    }

    public static function countOfRentals($data)
    {
        $count_of_guests = Service::whereDate("services.created_at", '>=', $data->start_date)
            ->whereDate("services.created_at", '<=', $data->end_date)
            ->count();
        return  $count_of_guests;
    }


    public static function availableRooms()
    {
        $today = Carbon::now();
        return Room::whereDate('date_of_availability', '<', $today)->get();
    }
}
