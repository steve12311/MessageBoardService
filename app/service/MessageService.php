<?php

namespace app\service;

use app\model\Message;
use app\model\User;

class MessageService
{
    public function getAllMessages()
    {
        $message = new Message();
        return $this->pushValue($message->select()->toArray());
    }

    public function insertOrUpdateMessage($data)
    {
        $message = new Message();
        if ($data["id"] === null) {
            $data["publishTime"] = time();
            $data["modifyTime"] = time();
            if ($data["content"] != null) {
                $data["content"] = trim($data["content"]);
            }
            $message->insert([
                "source_user_id" => $data["sourceUserId"],
                "publish_user_id" => $data["publishUserId"],
                "content" => $data["content"],
                "publish_time" => $data["publishTime"],
                "modify_time" => $data["modifyTime"],
                "source_message_id" => $data["sourceMessageId"],
                "title" => $data["title"],
            ]);
            return 1;
        } else {
            $message->update([
                "content" => trim($data["content"]),
                "modifyTime" => time()
            ], ["id" => $data["id"]]);
            return 1;
        }
    }

    public function getMessageByPublishUserName($name)
    {
        $massage = new Message();
        $user = new User();
        $user = $user->where("nick_name", 'like', '%' . $name . '%')->select()->toArray();
        $ids = array_column($user, 'id');
        $message = $massage->where('publish_user_id', 'in', $ids)->select()->toArray();
        return $this->pushValue($message);
    }

    private function pushValue($message)
    {
        for ($i = 0; $i < count($message); $i++) {
            $message[$i]["sourceUserName"] = (new User())->find($message[$i]["sourceUserId"])["nick_name"];
            $message[$i]["publishUserName"] = (new User())->find($message[$i]["publishUserId"])["nick_name"];
        }
        return $message;
    }

    public function getMessageByContent($value)
    {
        $massage = new Message();
        $message = $massage->where('content', 'like', '%' . $value . '%')->select()->toArray();
        return $this->pushValue($message);
    }

    public function getMessageByTime($startTime, $endTime)
    {
        $massage = new Message();
        $message = $massage->where('publish_time', '>=', $startTime)
            ->where('publish_time', '<=', $endTime)
            ->select()->toArray();
        return $this->pushValue($message);
    }

    public function getMessageById($id)
    {
        $massage = new Message();
        return $massage->find($id)->toArray();
    }

    public function deleteMessage($id)
    {
        $massage = Message::find($id);
        return $massage->delete();
    }
}