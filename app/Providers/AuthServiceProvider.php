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

        // Gate::before(function (Authenticatable $user, $ability) {
        //     if ($user->tokenCan($ability)) {
        //         return true;
        //     }
        // });
    }
}
