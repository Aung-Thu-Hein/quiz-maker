<?php

namespace Core\Auth;

class JWT 
{
    private static string $secretKey;
    private static string $algorithm;
    private static string $type;
    private static string $refreshSecretKey;

    private static function init()
    {
        $jwt = config('jwt');
        self::$secretKey = $jwt['secret_key'];
        self::$algorithm = $jwt['algorithm'];
        self::$type = $jwt['type'];
        self::$refreshSecretKey = $jwt['refresh_secret_key'];
    }

    private static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    private static function encodeHeader(): string
    {
        $header = json_encode(['typ' => self::$type, 'alg' => self::$algorithm]);
        return self::base64UrlEncode($header);
    }

    private static function encodePayload(array $payload): string
    {
        $payload = json_encode($payload);
        return self::base64UrlEncode($payload);
    }

    private static function encodeSignature(string $header, string $payload, string $key): string
    {
        $signature = hash_hmac('sha256', "$header.$payload", $key, true);
        return self::base64UrlEncode($signature);
    }

    private static function decodePayload(string $payload): array
    {
        $decodedPayload = self::base64UrlDecode($payload);
        return json_decode($decodedPayload, true);
    }

    public static function token(array $payload): string
    {
        self::init();

        //encode header
        $header = self::encodeHeader(); 

        //encode payload
        $payload = self::encodePayload($payload);

        //encode signature
        $signature = self::encodeSignature($header, $payload, self::$secretKey);

        return "$header.$payload.$signature";
    }

    public static function refreshToken(array $payload): string
    {
        self::init();

        //encode header
        $header = self::encodeHeader(); 

        //encode payload
        $payload = self::encodePayload($payload);

        //encode signature
        $signature = self::encodeSignature($header, $payload, self::$refreshSecretKey);

        return "$header.$payload.$signature";
    }

    public static function validateToken(string $token): array
    {
        self::init();

        //extract token parts
        list($header, $payload, $signature) = explode('.', $token);

        //decode payload
        $decodedPayload = self::decodePayload($payload);

        //check token is expired or not 
        if($decodedPayload['exp'] < time()) {
            return [false, 'Token expired...'];
        }

        //compute hash value
        $hashedSignature = self::encodeSignature($header, $payload, self::$secretKey);

        //validate signature
        if(!hash_equals($hashedSignature, $signature)) {
            return [false, 'Invalid token...'];
        }
        
        //valid
        return [true, $decodedPayload];
    }

    public static function validateRefreshToken(string $token): array
    {
        self::init();

        //extract token parts
        list($header, $payload, $signature) = explode('.', $token);

        //decode payload
        $decodedPayload = self::decodePayload($payload);

        //check token is expired or not 
        if($decodedPayload['exp'] < time()) {
            return [false, 'Refresh token has expired...'];
        }

        //compute hash value
        $hashedSignature = self::encodeSignature($header, $payload, self::$refreshSecretKey);

        //validate signature
        if(!hash_equals($hashedSignature, $signature)) {
            return [false, 'Invalid token...'];
        }
        
        //valid
        return [true, $decodedPayload];
    }
}
