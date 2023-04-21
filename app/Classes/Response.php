<?php

namespace App\Classes;

class Response
{
    public static function response($status, $data)
    {
        $result = ['success' => $status, 'data' => $data];
        return $result;
    }
}
