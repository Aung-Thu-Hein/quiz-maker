<?php

namespace App\Users\Contracts;

use Core\DB;

interface UserDaoInterface
{
    public function create(array $data): DB;

    public function getByEmail(string $email): array|false;

    public function createRefreshToken(array $data): DB;

    public function deleteRefreshToken(string $token) : bool;
}
