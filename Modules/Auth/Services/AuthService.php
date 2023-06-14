<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Modules\Auth\Enums\RoleEnum;
use Modules\Auth\Events\UserLoggedIn;
use Modules\Auth\Events\UserRegistered;

class AuthService
{
    /**
     * @param string $email
     * @param string $password
     *
     * Weryfikuje dane użytkownika wymagane do zalogowania
     * Zwraca array gdy logowanie poprawne, zaś false gdy logowanie nie przeszło pomyślnie
     *
     * @return array|bool
     */
    public function login(string $email, string $password): array | bool
    {
        $user = User::where('email', $email)->first();
        if (empty($user)) {
            return false;
        }
        if (Hash::check($password, $user->password)) {
            if (Hash::needsRehash($user->password)) {
                $hashed = Hash::make($password);
                $user->update(['password' => $hashed]);
            }
            return $this->generateLoginResponse($user);
        } else {
            return false;
        }
    }

    /**
     * @param string $email
     * @param string $password
     *
     * Rejestruje użytkownika o danym emailu i haśle
     *
     * @return array
     */
    public function register(string $email, string $password, array $userData, int $money = 0, $role = 'user'): array
    {
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'money' => $money,
            'role' => $role
        ]);
        event(new UserRegistered($user, $userData));

        return $this->generateLoginResponse($user);
    }

    private function generateLoginResponse(User $user): array
    {
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        event(new UserLoggedIn($user));

        return [ 'user_id' => $user->id, 'token' => $token ];
    }

    public function set_role(RoleEnum $role, User $user) : bool
    {
        return $user->update(['role' => $role]);
    }

}
