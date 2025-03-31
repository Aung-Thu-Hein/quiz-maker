<?php

namespace App\Auth;

use App\Users\DAOs\UserDao;
use Core\Auth\JWT;
use Core\DB;

class Auth
{
    public static function login(string $email, string $password)
    {
        $db = new DB();
        $userDao = new UserDao($db);

        $user = $userDao->getByEmail($email);

        if(!$user) {
            return false;
        }

        if(password_verify($password, $user['password'])) {

            $issuedAt = time();
            $payload = [
                'sub' => $user['id'],
                'iat' => $issuedAt,
                'exp' => $issuedAt + config('jwt')['expiry_time']
            ];
            
            return JWT::token($payload);
        }

        return false;
    }
}
