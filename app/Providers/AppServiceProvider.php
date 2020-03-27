<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use App\Accounts\ResolveUserAccountFromRequest;

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
        Builder::macro('forCurrentAccount', function ($key = 'account_id') {
            return $this->where([
                $key => with(app('request')->userAccount())->getKey(),
            ]);
        });

        Builder::macro('paginateUsingCurrentRequest', function ($perPage = null, ...$args) {
            return $this->paginate(app('request')->getPerPage($perPage), ...$args)->appends(
                app('request')->except('page')
            );
        });

        Request::macro('userAccount', function () {
            return app(ResolveUserAccountFromRequest::class)->get();
        });

        Request::macro('getPerPage', function ($default = null) {
            $value = $this->get('per_page', 25);

            return is_numeric($value) ? min(abs($value), 200) : value($default);
        });
    }
}
