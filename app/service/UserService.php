<?php

namespace app\service;

use app\model\User;

class UserService
{
    public function getAllUsers()
    {
        $user = new User();
        return $user->select();
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        return $user->delete();
    }
}