<?php

namespace app\service;

use app\model\User;
use app\utils\TokenJWT;

class AuthService
{

    function login($account, $password)
    {
        $user = new User();
        $user = $user->where('email', $account)->findOrEmpty();
        if (!$user->isEmpty()) {
            if (password_verify($password, $user["password"])) {
                return TokenJWT::encodeToken([
                    "id" => $user["id"],
                    "nickName" => $user["nick_name"],
                    "email" => $user["email"],
                    "role" => $user["role"]
                ]);
            }
        }
        return null;
    }

    function register($account, $password)
    {
        if (empty($account) || empty($password)) {
            return null;
        }
        $user = new User();
        $safe_password = password_hash($password, PASSWORD_DEFAULT);
        $user->save([
            "password" => $safe_password,
            "email" => $account,
        ]);
        if ($user['id']) {
            return TokenJWT::encodeToken([
                "id" => $user["id"],
                "nickName" => $user["nick_name"],
                "email" => $user["email"],
                "role" => $user["role"]
            ]);
        }
        return null;
    }

    function valid_unique_email($email)
    {
        $user = new User();
        $user = $user->where('email', $email)->findOrEmpty();
        return $user->isEmpty();
    }
}