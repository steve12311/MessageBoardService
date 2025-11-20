<?php
declare (strict_types=1);

namespace app\middleware;

use think\Response;
use app\utils\TokenJWT;
use Closure;
use Exception;
use think\Request;

class Auth
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        try {
            TokenJWT::decodeToken($token);
        } catch (Exception $exception) {
            return Response::create([
                'code' => 401,
                'msg' => $exception->getMessage(),
                'data' => null
            ]);
        }
        return $next($request);
    }
}
