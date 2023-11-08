<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class CheckJWT
{
    public function handle($request, Closure $next)
    {
        try {
            $header = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $header);

            if (!$token) {
                return response()->json([
                    'code' => '401',
                    'status' => false,
                    'message' => 'Token Not Found',
                ], 400);
            }

            $payload = JWT::decode($token, new Key(env('AUTH_SECRET'), 'HS256'));
            $request->login_id = $payload->aud;

        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'code' => '401',
                'status' => false,
                'message' => 'Token is expire',
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'code' => '401',
                'status' => false,
                'message' => 'Can not verify identity',
            ], 400);
        }

        return $next($request);
    }
}
