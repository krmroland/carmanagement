<?php

namespace App\Users\Models;

use App\Users\HasUniqueName;
use App\Models\InteractsWithUser;
use App\Users\Auth\Models\Associatable;

class Organization extends Associatable
{
    use InteractsWithUser, HasUniqueName;
}
