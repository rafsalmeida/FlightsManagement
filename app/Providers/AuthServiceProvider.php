<?php

namespace App\Providers;

use App\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-direcao', function ($socio) {    
            return $socio->direcao == 1;
        });

        Gate::define('is-piloto', function ($socio) {    
            return $socio->tipo_socio == 'P';
        });

        Gate::define('is-direcao-piloto', function ($socio){
            return $socio->direcao == 1 || $socio->tipo_socio == 'P';
        });

        Gate::define('is-direcao-piloto', function ($socio){
            return $socio->direcao == 1 || $socio->tipo_socio == 'P';
        });



    }
}
