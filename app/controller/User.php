<?php

namespace app\controller;

use app\model\Response;
use app\service\UserService;
use app\utils\TokenJWT;
use think\facade\Request;

class User
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllUsers()
    {
        $payload = TokenJWT::decodeToken(Request::header("Authorization"));
        if ($payload->role !== 1) {
            return json(Response::error(401, "权限不足"));
        }
        return json(Response::success($this->userService->getAllUsers()));
    }

    public function deleteUser($id)
    {
        $payload = TokenJWT::decodeToken(Request::header("Authorization"));
        if ($payload->role !== 1) {
            return json(Response::error(401, "权限不足"));
        }
        return json(Response::success($this->userService->deleteUser($id)));
    }
}