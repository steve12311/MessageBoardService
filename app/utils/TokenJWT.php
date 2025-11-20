<?php

namespace app\utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenJWT
{
    public static $key = "abcdefghijklmnopqrstuvwxyz01234567890";
    public static $expire = 2 * 60 * 60;

    static function encodeToken(array $tokenData)
    {
        $payload = [
            "iat" => time(), // 签发时间
            "nbf" => time(), // 生效时间
            "exp" => time() + TokenJWT::$expire, // 失效时间
        ];
        $payload = array_merge($payload, $tokenData);
        return JWT::encode($payload, TokenJWT::$key, 'HS256');
    }


    static function decodeToken($jwt)
    {
        return JWT::decode($jwt, new Key(TokenJWT::$key, 'HS256'));
    }
}