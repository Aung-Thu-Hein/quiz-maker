<?php

namespace Core\Auth;

class JWT 
{
    private static string $secretKey;
    private static string $algorithm;
    private static string $type;

    public static function init()
    {
        $jwt = config('jwt');
        self::$secretKey = $jwt['secret_key'];
        self::$algorithm = $jwt['algorithm'];
        self::$type = $jwt['type'];
    }

    private static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    public static function token(array $payload): string
    {
        //encode header
        $header = json_encode(['typ' => self::$type, 'alg' => self::$algorithm]);
        $header = self::base64UrlEncode($header);

        //encode payload
        $payload = json_encode($payload);
        $payload = self::base64UrlEncode($payload);

        //encode signature
        $signature = hash_hmac('sha256', "$header.$payload", self::$secretKey, true);
        $signature = self::base64UrlEncode($signature);

        return "$header.$payload.$signature";
    }
}
