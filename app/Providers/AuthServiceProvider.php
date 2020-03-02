<?php

namespace App\Providers;

use App\Policies\ProductPolicy;
use App\Products\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (Authenticatable $user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('ownership', function ($user, $entity, $key = 'user_id') {
            return $user->ownsEntity($entity, $key);
        });
    }
}
