<?php

namespace App\Accounts\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class DeletedEntity extends BaseModel
{
    /**
     * Turnoff timestamps
     * @var boolean
     */
    public $timestamps = false;
}
