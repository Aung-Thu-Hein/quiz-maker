<?php

namespace App\Users\Controllers;

use App\Auth\Auth;
use App\Traits\ApiResponse;
use App\Users\Contracts\UserServiceInterface;
use Core\Http\Request;

class UserController
{
    use ApiResponse;

    public function __construct(protected UserServiceInterface $userService)
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

    public function logout()
    {
        $refreshToken = $_COOKIE['refresh_token'];

        if(!isset($refreshToken)) {
            $this->response(403, message: "No refresh token is found...");
        }

        $isLogout = Auth::logout($refreshToken);

        if(!$isLogout) {
            $this->response(400, message: "Something was wrong, try again...");
        }

        $this->response(200);
    }

    public function refresh()
    {
        $refreshToken = $_COOKIE['refresh_token'];

        if(!isset($refreshToken)) {
            $this->response(403, message: "No refresh token is found...");
        }

        list($isValid, $data) = Auth::validateRefreshToken($refreshToken);
        if(!$isValid) {
            $this->response(401, message: $data);
        }

        $newToken = Auth::refreshToken($data);

        $this->response(200, data: ['token' => $newToken]);
    }
}
