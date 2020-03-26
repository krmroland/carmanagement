<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;

class UniqueRule extends Unique
{
    /**
     * Ignores in route
     * @param  string $name
     */
    public function ignoreRoute($name, $column = 'id')
    {
        // could be an id or a model
        if ($id = request()->route($name)) {
            $this->ignore($id, $column);
        }

        return $this;
    }

    /**
     * Scopes the unique rule to the currently authenticated user
     * @param  string $column
     * @return $this
     */
    public function forAuthenticatedUser($column = 'user_id')
    {
        if ($user = Auth::user()) {
            $this->where($column, $user->id);
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
