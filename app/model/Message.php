<?php

namespace app\model;

use think\Model;

class Message extends Model
{
    protected $pk = 'id';
    protected $name = 'messages';
    protected $autoinc = true;
    protected $convertNameToCamel = true;

    public $publish_user_name;
    public $source_user_name;

    protected $schema = [
        "id" => "int",
        "source_user_id" => "int",
        "source_message_id" => "int",
        "publish_user_id" => "int",
        "title" => "string",
        "content" => "string",
        "publish_time" => "string",
        "modify_time" => "string",
    ];
}