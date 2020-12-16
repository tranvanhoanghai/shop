<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('login-dashboard', function($user){
            return $user->hasAccess(['login-dashboard']);
        });
        Gate::define('sale', function($user){
            return $user->hasAccess(['sale']);
        });
        Gate::define('view-user', function($user){
            return $user->hasAccess(['view-user']);
        });
        Gate::define('act-user', function($user){
            return $user->hasAccess(['act-user']);
        });
        Gate::define('view-product', function($user){
            return $user->hasAccess(['view-product']);
        });
        Gate::define('act-product', function($user){
            return $user->hasAccess(['act-product']);
        });
        Gate::define('view-category', function($user){
            return $user->hasAccess(['view-category']);
        });
        Gate::define('act-category', function($user){
            return $user->hasAccess(['act-category']);
        });
        Gate::define('act-prices', function($user){
            return $user->hasAccess(['act-prices']);
        });        
        Gate::define('view-bill-order', function($user){
            return $user->hasAccess(['view-bill-order']);
        });
        Gate::define('act-bill-order', function($user){
            return $user->hasAccess(['act-bill-order']);
        });
        Gate::define('view-bill-import', function($user){
            return $user->hasAccess(['view-bill-import']);
        });
        Gate::define('act-bill-import', function($user){
            return $user->hasAccess(['act-bill-import']);
        });
        Gate::define('view-customer', function($user){
            return $user->hasAccess(['view-customer']);
        });
        Gate::define('act-customer', function($user){
            return $user->hasAccess(['act-customer']);
        });
        Gate::define('view-suppliers', function($user){
            return $user->hasAccess(['view-suppliers']);
        });
        Gate::define('act-suppliers', function($user){
            return $user->hasAccess(['act-suppliers']);
        });
        Gate::define('view-blog', function($user){
            return $user->hasAccess(['view-blog']);
        });
        Gate::define('act-blog', function($user){
            return $user->hasAccess(['act-blog']);
        });
        Gate::define('view-contact', function($user){
            return $user->hasAccess(['view-contact']);
        });
        Gate::define('act-contact', function($user){
            return $user->hasAccess(['act-contact']);
        });
        Gate::define('view-slide', function($user){
            return $user->hasAccess(['view-slide']);
        });
        Gate::define('act-slide', function($user){
            return $user->hasAccess(['act-slide']);
        });
        Gate::define('view-coupon', function($user){
            return $user->hasAccess(['view-coupon']);
        });
        Gate::define('act-coupon', function($user){
            return $user->hasAccess(['act-coupon']);
        });
        Gate::define('act-role', function($user){
            return $user->hasAccess(['act-role']);
        });
    }
}
