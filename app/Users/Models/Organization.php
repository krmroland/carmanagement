<?php

namespace App\Users\Models;

use App\Users\OwnsProjects;
use App\Contracts\ProjectOwner;
use App\Models\InteractsWithUser;
use App\Users\Auth\Models\Associatable;

class Organization extends Associatable implements ProjectOwner
{
    use InteractsWithUser, OwnsProjects;
}
