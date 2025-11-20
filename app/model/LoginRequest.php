<?php

namespace app\model;

use app\Request;

class LoginRequest extends Request
{
    private $json;

    function __construct()
    {
        parent::__construct();
        $json_str = file_get_contents("php://input");
        $this->json = json_decode($json_str, true);
    }

    function getEmail()
    {
        return $this->json['email'] ?? "";
    }

    function getPassword()
    {
        return $this->json['password'] ?? "";
    }

}