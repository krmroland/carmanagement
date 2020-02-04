<?php

namespace App\Users;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Projects\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Users\Models\OwnerUniqueName;
use Illuminate\Validation\ValidationException;

trait OwnsProjects
{
    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // we will have to extract the unique name from the attributes if it exist
        if (!array_key_exists('unique_name', $this->attributes)) {
            return parent::save($options);
        }

        return DB::transaction(function () use ($options) {
            $uniqueName = Arr::pull($this->attributes, 'unique_name');
            parent::save($options);
            $this->setUniqueName($uniqueName);
        });
    }

    /**
     * The unique name relationship
     * @return MoprhOne
     */
    public function uniqueName()
    {
        return $this->morphOne(OwnerUniqueName::class, 'owner');
    }
    /**
     * Sets a given unique name
     */
    public function setUniqueName($value)
    {
        $this->uniqueName()
            ->firstOrNew([])
            ->updateValue($value);

        return $this;
    }
    /**
     * Gets the unique name of the given model
     * @return string|null
     */
    public function getUniqueName()
    {
        return optional($this->uniqueName)->value;
    }
    /**
     * The projects relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function projects()
    {
        return $this->morphMany(Project::class, 'owner');
    }
}
