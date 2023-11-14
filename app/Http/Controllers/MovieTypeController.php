<?php

namespace App\Http\Controllers;

use App\Models\MovieType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MovieTypeController extends Controller
{
    public function add(Request $request)
    {
        $name = $request->name;

        //เช็คชื่อซ้ำ
        $check_movie_type = MovieType::where('name', $name)->first();
        if ($check_movie_type) {
            return response()->json([
                'status' => false,
                'message' => 'มี ' . $name . ' ในระบบแล้ว',
            ], 400);
        }

        //บันทึกข้อมูลลงตาราง
        $movie_type = new MovieType();
        $movie_type->name = $name;
        $movie_type->save();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movie_type,
        ], 200);
    }

    public function view($id)
    {
        $movie_type = MovieType::with('movies')->where('id', $id)->first();

        if (!$movie_type) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movie_type,
        ], 200);
    }

    public function all()
    {
        $movie_types = MovieType::with('movies')->get();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movie_types,
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        //ค้นหาข้อมูลใน database จาก id
        $movie_type = MovieType::where('id', $id)->first();

        //ค้นหาแล้วไม่เจอข้อมูล
        if (!$movie_type) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $name = $request->name;

        //บันทึกข้อมูลลงตาราง
        $movie_type->name = $name;
        $movie_type->save();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movie_type,
        ], 200);
    }

    public function delete($id)
    {
        $movie_type = MovieType::where('id', $id)->first();
        if (!$movie_type) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $movie_type->delete();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
        ], 200);
    }
}
