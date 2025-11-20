<?php

namespace app\model;

class Response
{
    public $data;
    public $code;
    public $msg;

    public function __construct($data, $code, $msg)
    {
        $this->data = $data;
        $this->code = $code;
        $this->msg = $msg;
    }

    public static function success($data)
    {
        return new Response($data, 200, "success");
    }

    public static function error($code, $msg)
    {
        return new Response(null, $code, $msg);
    }
}