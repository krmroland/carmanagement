<?php

namespace App\Users\Models;

use App\Users\OwnsProducts;
use App\Contracts\ProductOwner;
use App\Models\InteractsWithUser;
use App\Users\Auth\Models\Associatable;

class Organization extends Associatable implements ProductOwner
{
    use InteractsWithUser, OwnsProducts;
}
