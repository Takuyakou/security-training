<?php
namespace App\Auth;

use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Auth\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class CustomSessionGuard extends SessionGuard {

    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     * @return bool
     */
    protected function hasValidCredentials($user, $credentials)
    {
        $validated = ! is_null($user) && $this->provider->validateCredentials($user, $credentials);

        if ($user === null) {
            //ユーザーがいない
            $validated = false;

        } else {
            //管理者画面の場合
            if ($this->name === 'admin') {
                if (!$user->admin_flg) {
                    $validated = false;
                }
            }
        }

        if ($validated) {
            $this->fireValidatedEvent($user);
        }

        return $validated;
    }
}