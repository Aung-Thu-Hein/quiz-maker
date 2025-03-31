<?php

namespace App\Users\DAOs;

use App\Users\Contracts\UserDaoInterface;
use Core\DB;

class UserDao implements UserDaoInterface
{
    public function __construct(private DB $db)
    {
        //
    }

    public function create(array $data): DB 
    {
        $query = "INSERT INTO users (first_name, last_name, email, password, token) VALUES (:first_name, :last_name, :email, :password, :token)";
        return $this->db->run($query, $data);
    }

    public function getByEmail(string $email): array|false
    {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->db->run($query, ['email' => $email])->find();
    }
}