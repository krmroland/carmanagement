<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;

trait Helpers
{
    /**
     * Validates given model ids
     * @param  array $ids
     * @return Collection
     */
    public static function validateIds($ids)
    {
        if ($ids instanceof Arrayable) {
            $ids = $ids->all();
        }

        if (!is_array($ids)) {
            $ids = func_get_args();
        }

        $parsed = [];

        $instance = new static();

        foreach ($ids as $id) {
            if ($id instanceof $instance) {
                $parsed[] = $id->getKey();
            } else {
                $parsed[] = $id;
            }
        }
        // remove all ids that don't belong to the model
        return static::pluck($instance->getKeyName())->intersect($parsed);
    }

    /**
     * Parses and sets a given raw date string as a carbon instance
     * @param string $key
     * @param string $value
     */
    public function setRawDate($key, $value)
    {
        $date = blank($value) ? null : Carbon::parse($value);

        $this->attributes[$key] = $date;

        return $this;
    }

    /**
     * Makes a model cache key
     * @param mixed|null $postfix
     * @return string
     */
    public function updatedAtCacheKey($postfix = null)
    {
        return sprintf(
            '%s/%s-%s-%s+%s',
            $this->getConnectionName(),
            $this->getTable(),
            $this->getKey(),
            $this->updated_at,
            $postfix
        );
    }

    /**
     * Deletes or trashes a given model
     * @param  boolean $trash
     */
    public function discard($trash = false)
    {
        return $trash ? $this->forceDelete() : $this->delete();
    }

    /**
     * Wraps a model from a given di
     * @param  int|static  $id
     * @param  boolean $strict
     * @return static
     */
    public static function wrapfromId($id, $strict = true)
    {
        if ($id instanceof static) {
            return $id;
        }
        return $strict ? static::findOrFail($id) : static::find($id);
    }

    /**
     * Fill and persist model attributes
     * @param  array $attributes
     * @return array
     */
    public function persistAttributes($attributes)
    {
        return tap($this->fill($attributes))->save();
    }

    /**
     * Gets the morph attributes
     * @return array
     */
    public function getMorphAttributes($morph)
    {
        return [
            "{$morph}_id" => $this->getKey(),
            "{$morph}_type" => $this->getMorphClass(),
        ];
    }

    /**
     * Makes a model cache key
     * @param mixed|null $postfix
     * @return string
     */
    protected function makeCacheKey($postfix = null)
    {
        return sprintf('%s/%s-%s', $this->getConnectionName(), $this->getTable(), $this->getKey()) .
            $postfix;
    }
}
