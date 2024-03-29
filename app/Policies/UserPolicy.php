<?php

namespace App\Policies;

use App\User;
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

    public function viewSociosDesativados(User $socioLogged){
        if($socioLogged->direcao){
            return true;
        }

        return false;

    }

    public function view(User $socioLogged, User $socio){
        if($socioLogged->direcao){
            return true;
        }

        if($socioLogged->id === $socio->id){
            return true;
        }

        return false;

    }

    public function update(User $socioLogged, User $socio){
        if($socioLogged->direcao){
            return true;
        }

        if($socioLogged->id === $socio->id){
            return true;
        }

        return false;
    }

    public function createMovimento(User $socioLogged){
        if($socioLogged->direcao){
            return true;
        }

        if($socioLogged->tipo_socio == 'P'){
            return true;
        }

        return false;
    }

    public function updateMovimento(User $socioLogged,User $socio){
        if($socioLogged->direcao){
            return true;
        }

        if($socioLogged->tipo_socio == 'P' && $socioLogged->id == $socio->id){
            return true;
        }

        return false;
    }







}
