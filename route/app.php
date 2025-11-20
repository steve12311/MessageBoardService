<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use app\middleware\Auth;
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP8!';
});

Route::get('hello/:name', 'index/hello');

Route::group("api", function () {
    Route::get("messages/search", 'message/searchMessage');
    Route::delete("messages/:id", 'message/deleteMessage');
    Route::get('messages', 'message/getAllMessages');
    Route::post('messages', 'message/addMessage');
    Route::delete("admin/users/:id", "user/deleteUser");
    Route::get("admin/users", "user/getAllUsers");
})->middleware(Auth::class);

Route::post('/api/login', 'login/login');
Route::post('/api/register', 'login/register');


