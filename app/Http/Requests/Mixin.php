<?php

namespace App\Http\Requests;

class Mixin
{
    /**
     * Gets the per_page request field
     * @return int
     */
    public function getPerPage()
    {
        return function ($default = null) {
            $value = $this->get('per_page');

            if (is_numeric($value)) {
                return (int) min($value, 100);
            }
            // allow developers to pass closures
            return value($default);
        };
    }

    /**
     * Makes the request rules optional
     * @return array
     */
    public function makeRulesOptional()
    {
        return function ($rules) {
            return array_map(function ($constraits) {
                return is_array($constraits)
                    ? array_merge(['sometimes'], $constraits)
                    : 'sometimes|' . $constraits;
            }, $rules);
        };
    }
}
