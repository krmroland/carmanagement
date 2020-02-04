<?php

namespace App\Models;

use App\Users\Models\User;
use Illuminate\Support\Facades\Auth;

trait InteractsWithUser
{
    /**
     * The field name for authenticated user
     * @var string
     */
    protected $userIDFieldName = 'user_id';

    /**
     * Listen for when the eloquent model is booting
     */
    public static function bootInteractsWithUser()
    {
        static::creating(function ($model) {
            if ($user = Auth::user()) {
                $model->{$model->getUserIdFieldName()} = $user->getKey();
            }
        });
    }

    /**
     * The user that created the entity
     * @return BelongTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, $this->getUserIdFieldName());
    }

    /**
     * Determines if the given model is owned by user
     * @return boolean
     */
    public function isOwnedByUser(User $user)
    {
        return (int) $this->user_id === (int) $user->id;
    }

    /**
     * The owner of the model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->user();
    }

    /**
     * Gets the created by field name
     * @return string
     */
    public function getUserIdFieldName()
    {
        return $this->userIDFieldName;
    }
}
