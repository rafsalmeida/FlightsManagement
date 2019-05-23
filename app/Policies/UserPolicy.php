<?php

namespace App\Policies;

use App\User;
use App\Socio;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $socioLogged, Socio $socio){
        if($socioLogged->direcao){
            return true;
        }

        if($socioLogged->id === $socio->id){
            return true;
        }

        return false;

    }

    public function update(User $socioLogged, Socio $socio){
        if($socioLogged->direcao){
            return true;
        }

        if($socioLogged->id === $socio->id){
            return true;
        }

        return false;
    }


}
