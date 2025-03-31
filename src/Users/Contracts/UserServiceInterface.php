<?php

namespace App\Users\Contracts;

use Core\Http\Request;

interface UserServiceInterface
{
    public function buildUser(Request $request);

    public function createUser();

    public function getUserByEmail(string $email);

    public function map(array $user);
}
