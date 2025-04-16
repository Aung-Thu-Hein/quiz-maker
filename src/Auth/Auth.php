<?php

namespace App\Auth;

use App\Users\DAOs\UserDao;
use Core\Auth\JWT;
use Core\DB;

class Auth
{
    private static function getCookieParams(): array
    {
        return [
            'path' => '/auth/refresh',
            'domain' => '',
            'secure' => config('app')['env'] == 'development' ? false : true,
            'http_only' => true
        ];
    }

    private static function setRrefreshToken(string $refreshToken): void
    {
        $cookieExp = time() + config('jwt')['refresh_exp'];
        $params = self::getCookieParams();

        setcookie(
            "refresh_token",
            $refreshToken,
            $cookieExp,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['http_only']
        );
    }

    private static function clearRrefreshToken(): void
    {
        $params = self::getCookieParams();

        setcookie(
            "refresh_token",
            "",
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['http_only']
        );
    }

    public static function login(string $email, string $password): false|string
    {
        $db = new DB();
        $userDao = new UserDao($db);

        $user = $userDao->getByEmail($email);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {

            $issuedAt = time();
            $payload = [
                'sub' => $user['id'],
                'iat' => $issuedAt,
            ];

            //set refresh token
            $refreshTokenExp = $issuedAt + config('jwt')['refresh_exp'];
            $refreshPayload = [
                ...$payload,
                'exp' => $refreshTokenExp
            ];
            $refreshToken = JWT::refreshToken($refreshPayload);

            //set refresh token as httpOnly cookies
            self::setRrefreshToken($refreshToken);

            //store refresh token to db
            $userDao->createRefreshToken([
                'user_id' => $user['id'],
                'refresh_token' => $refreshToken,
                'expires_at' => $refreshPayload['exp']
            ]);

            return JWT::token([...$payload, 'exp' => $issuedAt + config('jwt')['expiry_time']]);
        }

        return false;
    }

    public static function validateToken(string $token)
    {
        return JWT::validateToken($token);
    }

    public static function validateRefreshToken(string $token)
    {
        return JWT::validateRefreshToken($token);
    }

    public static function logout(string $refreshToken): bool
    {
        $db = new DB();
        $userDao = new UserDao($db);

        $isDeleted = $userDao->deleteRefreshToken($refreshToken);
        if (!$isDeleted) {
            return false;
        }

        //clear cookie
        self::clearRrefreshToken();

        return true;
    }

    public static function refreshToken($payload)
    {
        $issuedAt = time();
        $payload = [
            'sub' => $payload['sub'],
            'iat' => $issuedAt,
            'exp' => $issuedAt + config('jwt')['expiry_time']
        ];

        return JWT::token($payload);
    }
}
