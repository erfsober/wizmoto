<?php

namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Provider extends Authenticatable implements MustVerifyEmail {
    use Notifiable;

    public static function boot () {
        parent::boot();
        ResetPassword::createUrlUsing(function ( $user , string $token ) {
            return route('provider.password.reset' , [
                'token' => $token ,
                'email' => $user->email ,
            ]);
        });
    }
}
