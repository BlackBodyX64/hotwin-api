<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function genToken($id)
    {
        $payload = array(
            "iss" => "erp",
            "aud" => $id,
            "iat" => Carbon::now()->timestamp,
            // "exp" => Carbon::now()->timestamp + 86400,
            "exp" => Carbon::now()->timestamp + 31556926,
            "nbf" => Carbon::now()->timestamp,
        );

        $token = JWT::encode($payload, env('AUTH_SECRET'), 'HS256');

        return $token;
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = User::where('username', $username)
            ->where('password', md5($password))
            ->where('role', 'user')
            ->first();

        // ไม่พบข้อมูล
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'ผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง'
            ], 400);
        }

        $user['token'] = $this->genToken($user->id); //สร้าง token

        return response()->json([
            'status' => true,
            'data' => $user,
        ], 200);
    }

    public function loginAdmin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = User::where('username', $username)
            ->where('password', md5($password))
            ->where('role', 'admin')
            ->first();

        // ไม่พบข้อมูล
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'ผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง'
            ], 400);
        }

        $user['token'] = $this->genToken($user->id); //สร้าง token

        return response()->json([
            'status' => true,
            'data' => $user,
        ], 200);
    }
}
