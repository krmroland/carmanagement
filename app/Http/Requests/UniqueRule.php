<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Unique;

class UniqueRule extends Unique
{
    /**
     * Ignores in route
     * @param  string $name
     * @return void
     */
    public function ignoreRoute($name, $column = 'id')
    {
        // could be an id or a model
        if ($id = request()->route($name)) {
            $this->ignore($name, $column);
        }

        return $this;
    }

    /**
     * Creates an instance of this class
     *
     * @param  string  $table
     * @param  string  $column
     * @return $this
     */
    public static function for($table, $column = 'NULL')
    {
        return new static($table, $column);
    }
}
