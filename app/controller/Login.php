<?php

namespace app\controller;

use app\model\Response;
use app\model\LoginRequest;
use app\service\AuthService;

class Login
{
    private AuthService $authService;
    private LoginRequest $loginRequest;

    public function __construct(AuthService $authService, LoginRequest $loginRequest)
    {
        $this->authService = $authService;
        $this->loginRequest = $loginRequest;
    }

    public function login()
    {
        $token = $this->authService->login($this->loginRequest->getEmail(), $this->loginRequest->getPassword());
        if (empty($token)) {
            return json(Response::error(401, "账号或密码错误"));
        }
        return json(Response::success($token));
    }

    public function register()
    {
        if (!$this->authService->valid_unique_email($this->loginRequest->getEmail())) {
            return json(Response::error(401, "账号已存在"));
        }
        $token = $this->authService->register($this->loginRequest->getEmail(), $this->loginRequest->getPassword());
        if (empty($token)) {
            return json(Response::error(401, "账号或密码错误"));
        }
        return json(Response::success($token));
    }
}