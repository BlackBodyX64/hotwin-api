<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request) {

        $phone = $request->phone;
        $username = $request->username;
        $password = $request->password;
        $fullname = $request->fullname;

        //เช็คเบอร์
        $check_phone = User::where('phone', $phone)->first();
        if ($check_phone) {
            return response()->json([
                'status' => false,
                'message' => 'เบอร์นี้ถูกใช้งานแล้ว'
            ], 400);
        }

        //เช็ค username
        $check_username = User::where('username', $username)->first();
        if ($check_username) {
            return response()->json([
                'status' => false,
                'message' => 'ผู้ใช้งานถูกใช้แล้ว'
            ], 400);
        }

        $user = new User();
        $user->phone = $phone;
        $user->username = $username;
        $user->password = md5($password);
        $user->fullname = $fullname;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $user,
        ], 200);

    }
}
