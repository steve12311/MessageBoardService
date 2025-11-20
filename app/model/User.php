<?php

namespace app\model;

use think\Model;

class User extends Model
{
    protected $name = 'users';
    protected $pk = 'id';
    protected $autoinc = true;
    protected $convertNameToCamel = true;

    protected $schema = [
        "id" => "int",
        "nick_name" => "string",
        "email" => "string",
        "password" => "string",
        "role" => "int",
    ];
}