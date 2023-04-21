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
use Illuminate\Support\Facades\Hash;

class Queries
{

    public static function createUser($data)
    {

        $user = new User;
        $user->first_name = $data->first_name;
        $user->other_names = $data->other_names;
        $user->phone_number = $data->phone_number;
        $user->employee_id = $data->employee_id;
        $user->role = $data->role;
        $user->email = $data->email;
        $user->password = Hash::make('changemenow');
        $user->save();
        return $user;
    }

    public static function addGuest($data)
    {
        $guest = new Guest;
        $guest->first_name = $data->first_name;
        $guest->other_names = $data->other_names;
        $guest->phone_number = $data->phone_number;
        $guest->email = $data->email;
        $guest->advert = $data->advert;
        $guest->added_by = $data->added_by;
        $guest->save();
    }

    public static function addRoom($data)
    {
        $date =  Carbon::parse($data->date_of_availability)->format('Y-m-d H:i:s');

        $room = new Room;
        $room->price_of_room = $data->cost_of_room;
        $room->room_number = $data->room_number;
        $room->percentage_discount = $data->percentage_discount;
        $room->date_of_availability = $date;
        $room->added_by = $data->added_by;
        $room->is_reserved = $data->is_reserved ?? 0;
        $room->save();
    }

    public static function addService($data)
    {
        $service = new Service;
        $service->room_id = $data->room_id;
        $service->start_of_residence = $data->start_of_residence;
        $service->end_of_residence = $data->end_of_residence;
        $service->duration_extended = $data->duration_extended ?? 0;
        $service->duration_reduced = $data->duration_reduced ?? 0;
        $service->added_by = $data->added_by;
        $service->guest_id = $data->guest_id;
        $service->is_reservation = $data->is_reservion ?? 0;
        $service->save();
    }
    public static function addPayment($data)
    {
        $payment = new Payment;
        $payment->guest_id = $data->guest_id;
        $payment->amount = $data->amount;
        $payment->added_by = $data->added_by;
        $payment->service_id = $data->service_id;
        $payment->is_invalid = $data->is_invalid ?? 0;
        $payment->room_id = $data->room_id;
        $payment->save();
    }

    public static function addRefund($data)
    {
        $refund = new Refund;
        $refund->guest_id = $data->guest_id;
        $refund->amount = $data->amount;
        $refund->added_by = $data->added_by;
        $refund->service_id = $data->service_id;
        $refund->is_invalid = $data->is_invalid ?? 0;
        $refund->room_id = $data->room_id;
        $refund->save();
    }

    public static function addExpense($data)
    {
        $expense = new Expense;
        $expense->purpose_of_expense = $data->purpose_of_expense;
        $expense->amount_involved = $data->amount_involved;
        $expense->added_by = $data->added_by;
        $expense->save();
    }

    public static function userDetails($email)
    {
        return User::where('email', $email)

            ->first();
    }

    public static function changePassword($user, $new_password)
    {

        $user->password = Hash::make($new_password);
        $user->default_password = false;
        $user->save();
    }

    public static function getUsers()
    {
        return User::all();
    }
    public static function getGuests()
    {
        return Guest::all();
    }

    public static function getRooms()
    {
        return Room::all();
    }

    public static function getRentals()
    {
        $days = Carbon::now()->subDays(7);

        $rentals = Service::whereDate("services.created_at", '>=', $days)
            ->join('rooms', 'rooms.id', '=', 'services.room_id')
            ->join('guests', 'guests.id', '=', 'services.guest_id')
            ->join('users', 'users.id', '=', 'services.added_by')
            ->select(
                "services.id",
                "services.start_of_residence",
                'services.end_of_residence',
                'services.duration_extended',
                'services.duration_reduced',
                'rooms.price_of_room',
                'rooms.state_of_occupancy',
                'rooms.date_of_availability',
                'rooms.percentage_discount',
                'guests.first_name as guest_first_name',
                'guests.other_names as guest_other_names',
                'guests.phone_number',
                'guests.email',
                'users.first_name as user_first_name',
                'users.other_names as user_other_names',
                'users.phone_number',
                'users.role'
            )
            ->orderBy('services.created_at', 'desc')
            ->get();

        return $rentals;
    }


    public static function  getPayments()
    {
        //$days = Carbon::now()->subDays(7);
        $payments = Payment::join('services', 'services.id', '=', 'payments.service_id')
            ->join('guests', 'guests.id', '=', 'payments.guest_id')
            ->join('users', 'users.id', '=', 'payments.added_by')
            ->join('rooms', 'rooms.id', '=', 'payments.room_id')

            ->select(
                'services.start_of_residence',
                'services.end_of_residence',
                'guests.first_name as guest_first_name',
                'guests.other_names as guest_other_names',
                'guests.email as guest_email',
                'guests.phone_number as guest_phone_number',
                'users.first_name as user_first_name',
                'users.other_names as user_other_names',
                'rooms.room_number',

            )
            ->orderBy('payments.created_at', 'desc')
            ->jsonPaginate($_GET['page']['size']);

        return $payments;
    }


    public static function  getRefunds()
    {
        //$days = Carbon::now()->subDays(7);
        $refunds = Refund::join('services', 'services.id', '=', 'refunds.service_id')
            ->join('guests', 'guests.id', '=', 'refunds.guest_id')
            ->join('users', 'users.id', '=', 'refunds.added_by')
            ->join('rooms', 'rooms.id', '=', 'refunds.room_id')

            ->select(
                'services.start_of_residence',
                'services.end_of_residence',
                'guests.first_name as guest_first_name',
                'guests.other_names as guest_other_names',
                'guests.email as guest_email',
                'guests.phone_number as guest_phone_number',
                'users.first_name as user_first_name',
                'users.other_names as user_other_names',
                'rooms.room_number',

            )
            ->orderBy('refunds.created_at', 'desc')
            ->jsonPaginate($_GET['page']['size']);

        return $refunds;
    }
}
