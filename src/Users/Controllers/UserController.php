<?php

namespace App\Users\Controllers;

use App\Auth\Auth;
use App\Traits\ApiResponse;
use App\Users\Services\UserService;
use Core\Http\Request;

class UserController
{
    use ApiResponse;

    public function __construct(protected UserService $userService)
    {
        //
    }

    public function store(Request $request)
    {
        $this->userService->buildUser($request);
        $user = $this->userService->createUser();

        $token = Auth::login($user->getEmail(), $user->getPassword());

        if(!$token) {
            $this->response(400);
        }

        $data = [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'token' => $token
        ];

        $this->response(201, data: $data);
    }

    public function login(Request $request)
    {
        $attributes = $request->getAttributes();

        $user = $this->userService->getUserByEmail($attributes['email']);
        if(!$user) {
            $this->response(404, message: "Invalid credentials");
        }

        $token = Auth::login($attributes['email'], $attributes['password']);
        if(!$token) {
            $this->response(400, message: "Something was wrong, try again...");
        }

        $user['token'] = $token;
        $this->response(201, data: $user);
    }
}
