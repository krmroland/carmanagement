<?php

namespace App\Users\Auth;

use App\Users\Models\User;
use Illuminate\Auth\Access\Response;
use App\Users\Auth\Models\Associatable;

class AssociatableGate
{
    /**
     * The user moder
     * @var User
     */
    protected $user;
    /**
     * The associatable model
     * @var Associatable
     */
    protected $associatable;
    /**
     * The entity being checked against
     * @var Model|null
     */
    protected $model = null;
    /**
     * The user related key
     * @var string
     */
    protected $userRelatedFieldName = 'user_id';

    /**
     * Creates an instance of this clss
     * @param User              $user
     * @param Aormassociatable|null $associatable
     */
    public function __construct(Associatable $associatable, User $user = null)
    {
        $this->associatable = $associatable;

        $this->user = $user;
    }

    /**
     * Detemines if a user has an ability to perform an action in the current associatable
     * @param  string $ability
     * @return
     */
    public function allows($ability = null)
    {
        return cache()->rememberForever($this->cacheKey($ability), function () use ($ability) {
            return $this->inspect($ability);
        });
    }

    /**
     * Authorizes a given ability name
     * @param  string $ability
     * @return void
     */
    public function authorize($ability = null)
    {
        if (!$this->allows($ability)) {
            return $this->deny();
        }

        return $this->associatable;
    }

    /**
     * Find current abilities
     * @return array
     */
    public function currentAbilities()
    {
        $user = $this->associatable
            ->members()
            ->wherePivot('user_id', $this->user->id)
            ->first();

        return data_get($user, 'pivot.abilities', []);
    }

    /**
     * Determines if this class denies a give ability
     * @return boolean
     */
    public function denies($ability = null)
    {
        return !$this->allow($ability = null);
    }

    /**
     * Denies user access
     * @return Response
     */
    public function deny()
    {
        return (new Response(false, 'Unauthorized access', 403))->authorize();
    }

    /**
     * Sets the gate for user
     * @param  User   $user
     * @return $this
     */
    public function forUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * The model  we are checking against
     * @param  Model  $model
     * @return $this
     */
    public function model(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Determines if the model is owned by current user
     * @return boolean
     */
    public function modelIsOwnedByUser()
    {
        return data_get($this->model, $this->user_related_key) === $this->user->id;
    }

    /**
     * The user related field
     * @param  string $name
     * @return $this
     */
    public function userRelatedField($name)
    {
        $this->userRelatedFieldName = $name;

        return $this;
    }

    /**
     * The ability cache key
     * @param  string $ability
     * @return string
     */
    protected function cacheKey($ability)
    {
        return implode(':', [
            'ability',
            $this->associatable->id,
            optional($this->user)->id,
            $ability,
        ]);
    }

    /**
     * Inspects a given ability
     * @param  string $ability
     * @return boolean
     */
    protected function inspect($ability = null)
    {
        if (is_null($this->user)) {
            return false;
        }

        if ($this->associatable->isOwnedByUser($this->user)) {
            return true;
        }

        // if the user doesn't belong to the associatable, we will cur them out

        if (!$this->associatable->hasDirectMember($this->user)) {
            return false;
        }

        if (is_null($ability) || (!is_null($this->model) && $this->modelIsOwnedByUser())) {
            return true;
        }

        // next if we have a ability, we will need to make sure that user has access  that ability

        return with($this->currentAbilities(), function ($abilities) use ($ability) {
            // check if the user has access to given abilitys

            return in_array('*', $abilities) || array_key_exists($ability, array_flip($abilities));
        });
    }
    /**
     * Authorizes a user to perform a certain action
     * @param  string $permission
     * @return void
     */
    public function updateAbilities($abilities)
    {
        if (is_null($this->user) || !$this->associatable->hasDirectMember($this->user)) {
            return false;
        }

        if (!is_array($abilities)) {
            $abilities = func_get_args();
        }

        $this->associatable->members()->updateExistingPivot($this->user, compact('abilities'));
    }
}
