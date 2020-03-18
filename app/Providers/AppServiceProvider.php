<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Request::mixin(new \App\Http\Requests\Mixin());

        Builder::macro('paginateByRequest', function ($perPage = null, ...$args) {
            return $this->paginate(request()->getPerPage($perPage), ...$args)->appends(
                request()->except('page')
            );
        });

        Blueprint::macro('syncable', function () {
            $this->timestamp('local_created_at')->nullable();
            $this->timestamp('local_updated_at')->nullable();
        });

        Relation::morphMap([
            'user' => \App\Users\Models\User::class,
            'organization' => \App\Users\Models\Organization::class,
        ]);

        Route::model('productOwner', \App\Users\Models\OwnerUniqueName::class);
    }
}
