<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\SetUserRoleRequest;
use Modules\Auth\Services\AuthService;

class UserController extends Controller
{
    public function set(SetUserRoleRequest $request, User $user)
    {
        $success = (new AuthService())->set_role($request->role, $user);

        if(!$success) {return apiResponse(False, [], 'Nie udalo zmienic rangi uzytkownika', 400);}
        else {return apiResponse(True, [], 'Udalo sie zmienic range uzytkownika', 204);}
    }

    public function show(User $user)
    {
        return apiResponse(True, (array)$user->role, 'Zwrocono role uzytkownika', 200);
    }

    public function me(Request $request)
    {
        return apiResponse(True, (array)$request->user()->role, 'Zwrocono range uzytkownika', 200);
    }
}
