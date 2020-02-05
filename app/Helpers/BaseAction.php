<?php

namespace App\Helpers;

use Illuminate\Validation\ValidationException;

abstract class BaseAction
{
    /**
     * Raises an error in an action
     * @throws Validation
     */
    public function raiseError($error)
    {
        $error = is_array($error) ? $error : compact('error');

        throw ValidationException::withMessages($error);
    }
}
