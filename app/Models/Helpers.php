<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Tappable;
use Illuminate\Contracts\Support\Arrayable;

trait Helpers
{
    use Tappable;

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
     * Listens for when a model is force deleting
     */
    public function whenForceDeleting(callable $callback)
    {
        if (method_exists($this, 'isForceDeleting') && !$this->isForceDeleting()) {
            return;
        }
        return call_user_func($callback);
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
     * Set a given attribute on the model.
     *
     * @param  string  $key
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute($key, $value);
    }

    /**
     * Update the creation and update timestamps.
     */
    public function updateTimestamps()
    {
        // exposes the parent protected method as a public one
        return parent::updateTimestamps();
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
    public function getMorhpAttributes($morph)
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

    /**
     * Serialize all dates to use ISO-8601 timestamps
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('c');
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @return \Illuminate\Support\Carbon
     */
    protected function asDateTime($value)
    {
        return Carbon::parse($value);
    }
}
