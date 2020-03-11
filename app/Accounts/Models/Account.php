<?php

namespace App\Accounts\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Account extends BaseModel
{
    public static function createOfType($type)
    {
        return static::create(compact('type'));
    }
}
