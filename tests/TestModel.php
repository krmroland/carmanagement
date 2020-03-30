<?php

namespace Tests;

use App\Models\BaseModel;

class TestModel extends BaseModel
{
    /**
     * Get the table associated with the model.
     */
    public function getTable()
    {
        // just make sure we don't try to persist stuff while running tests
        return null;
    }
}
