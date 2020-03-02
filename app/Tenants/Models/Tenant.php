<?php

namespace App\Tenants\Models;

use App\Models\BaseModel;
use App\Models\InteractsWithUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends BaseModel
{
    use InteractsWithUser, SoftDeletes;
}
