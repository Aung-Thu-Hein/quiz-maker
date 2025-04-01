<?php

namespace App\Users\Contracts;

use App\Users\Models\User;
use Core\Http\Request;

interface UserServiceInterface
{
    public function buildUser(Request $request): void;

    public function createUser(): User;

    public function getUserByEmail(string $email): array|false;

    public function map(array $user): array;
}
