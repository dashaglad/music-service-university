<?php

namespace App\ApiModels\RequestModels;

use Illuminate\Database\Eloquent\Model;

class LoginRequestModel extends Model
{
    public string $email;

    public string $password;
}
