<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\LogoutRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\AuthService;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     *
     * Controller logowania użytkownika
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $logged_in = (new AuthService())->login($email, $password);
        if (!$logged_in) {
            return apiResponse(false, [], 'Email lub hasło nieprawidłowe', 422);
        } else {
            return apiResponse(true, $logged_in, 'Poprawnie zalogowano użytkownika', 200);
        }
    }

    /**
     * @param RegisterRequest $request
     *
     * Controller rejestracji użytkownika
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $registered = (new AuthService())->register($email, $password, $request->all());
        if (!empty($registered['token'])) {
            return apiResponse(true, $registered, 'Pomyślnie zarejestrowano użytkownika');
        } else {
            return apiResponse(false, [], 'Wystąpił błąd podczas rejestracji użytkownika', 422);
        }
    }

    /**
     * @param LogoutRequest $request
     *
     * Controller logout użytkownika
     *
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();

        return apiResponse(true, [], 'Poprawnie wylogowano', 200);
    }
}
