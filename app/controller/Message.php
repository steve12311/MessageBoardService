<?php

namespace app\controller;

use app\model\Response;
use app\service\MessageService;
use app\utils\TokenJWT;
use think\facade\Request;

class Message
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function getAllMessages()
    {
        return json(Response::success($this->messageService->getAllMessages()));
    }

    public function addMessage()
    {
        $payload = TokenJWT::decodeToken(Request::header("Authorization"));
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data["id"] !== null && $data["publishUserId"] !== $payload->id) {
            return json(Response::error(403, "权限不足"));
        }
        return json(Response::success($this->messageService->insertOrUpdateMessage($data)));
    }

    public function deleteMessage($id)
    {
        $payload = TokenJWT::decodeToken(Request::header("Authorization"));
        $message = $this->messageService->getMessageById($id);
        $isOwner = $message["publishUserId"] === $payload->id;
        $isAdmin = $payload->role === 1;
        if (!$isOwner && !$isAdmin) {
            return json(Response::error(401, "权限不足"));
        }
        return json(Response::success($this->messageService->deleteMessage($id)));
    }

    public function searchMessage()
    {
        $param = Request::param(["type", "value"]);
        $message_list = [];
        switch ($param["type"]) {
            case "publish_user":
                $message_list = $this->messageService->getMessageByPublishUserName($param["value"]);
                break;
            case "content":
                $message_list = $this->messageService->getMessageByContent($param["value"]);
                break;
            case "time":
                $times = explode('-', $param["value"]);
                $message_list = $this->messageService->getMessageByTime($times[0], $times[1]);
                break;
        }
        return json(Response::success($message_list));
    }
}