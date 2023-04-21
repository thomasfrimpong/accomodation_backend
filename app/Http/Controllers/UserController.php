<?php

namespace App\Http\Controllers;

use App\Classes\Data;
use App\Classes\Queries;
use App\Classes\Response;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\LoginUserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function addUser(AddUserRequest $request)
    {

        try {


            $user =  Queries::createUser($request);

            $token = $user->createToken('tokens')->plainTextToken;

            //Cache::put('user', $user);

            $response = [
                'user' => $user,
                'token' => $token,

            ];
            return Response::response(true, $response);
        } catch (Exception $ex) {
            return $ex->getMessage();
            return Response::response(false, 'Something went wrong.');
        }
    }
    //
    public function loginUser(LoginUserRequest $request)
    {


        $user = Queries::userDetails($request->email);



        if (!$user) {
            return Response::response(false, 'Incorrect email or password.');
        }

        if (!Hash::check($request->password,  $user->password)) {
            return Response::response(false, 'Incorrect email or password');
        }

        $token = $user->createToken('tokens')->plainTextToken;

        //Cache::put('user', $user);

        $response = [
            'user' => $user,
            'token' => $token,

        ];

        return Response::response(true, $response);
    }

    public function getAllUsers()
    {
        return Queries::getUsers();
    }

    public function updateUserInfo(Request $request)
    {
        try {
            Data::updateUser($request);
            return Response::response(true, 'User updated successfully.');
        } catch (Exception $ex) {
            return $ex->getMessage();
            return Response::response(false, 'Something went wrong.');
        }
    }
}
