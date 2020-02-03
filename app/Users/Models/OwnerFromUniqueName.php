<?php

namespace App\Users\Models;

use App\Models\BaseModel;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OwnerFromUniqueName extends BaseModel
{
    /**
     * The owner of the user name
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function owner()
    {
        return $this->morphTo('owner');
    }

    /**
     * Resolves the owner of a username
     * @param  string $value
     * @return Organization|User
     */
    public function resolveRouteBinding($value)
    {
        return OwnerFromUniqueName::where(compact('value'))
            ->firstOrFail()
            ->owner()
            ->firstOrFail();
    }

    /**
     * Set(s) the value attribute
     * @param string $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = Str::slug($value);
    }

    /**
     * Determines if the value has been ysed
     * @param  string $value
     * @param  id|null $ignoreId
     * @return boolean
     */
    public function valueHasBeenUsed($value, $ignoreId = null)
    {
        return static::where(['value' => Str::slug($value)])
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->whereKeyNot($ignoreId);
            })
            ->exists();
    }
    /**
     * Updates the current value
     * @param  string $value
     * @return $this
     */
    public function updateValue($value)
    {
        if (static::valueHasBeenUsed($value, $this->id)) {
            throw ValidationException::withMessages([
                'unique_name' => 'This username is not available',
            ]);
        }

        return $this->persistAttributes(compact('value'));
    }
}
