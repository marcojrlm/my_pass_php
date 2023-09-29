<?php

namespace App\Utils;

use Illuminate\Support\Facades\Crypt;

class Utils
{
    function encryptPassword(string $password): string
    {
        return Crypt::encryptString($password);
    }

    function decryptPassword(string $encryptedPassword): string
    {
        return Crypt::decryptString($encryptedPassword);
    }

}
