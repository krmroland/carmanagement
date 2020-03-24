<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use Helpers;

    /**
     * The guarded fields
     * @var array
     */
    protected $guarded = [];
}
