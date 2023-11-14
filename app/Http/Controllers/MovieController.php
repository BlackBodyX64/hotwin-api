<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MovieController extends Controller
{
    public function add(Request $request)
    {
        $name = $request->name;
        $image = $request->file('image');
        $url = $request->url;
        $movie_type_id = $request->movie_type_id;

        //บันทึกไฟล์ลง server
        $path = '/movie/';
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path($path);

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $movie = new Movie();
        $movie->name = $name;
        $movie->image = $path . $input;
        $movie->url = $url;
        $movie->movie_type_id = $movie_type_id;
        $movie->save();

        $movie['image_url'] = url($movie->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movie,
        ], 200);
    }

    public function view($id)
    {
        $movie = Movie::where('id', $id)->first();

        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $movie['image_url'] = url($movie->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movie,
        ], 200);
    }

    public function all()
    {
        $movies = Movie::get();

        //แทรก image_url เพิ่ม
        foreach ($movies as $movie) {
            $movie['image_url'] = url($movie->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movies,
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        //ค้นหาข้อมูลใน database จาก id
        $movie = Movie::where('id', $id)->first();

        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $name = $request->name;
        $image = $request->file('image');
        $url = $request->url;
        $movie_type_id = $request->movie_type_id;

        //บันทึกไฟล์ลง server
        $path = '/movie/';
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path($path);

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $movie->name = $name;
        $movie->image = $path . $input;
        $movie->url = $url;
        $movie->movie_type_id = $movie_type_id;
        $movie->save();

        $movie['image_url'] = url($movie->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $movie,
        ], 200);
    }

    public function delete($id) {
        $movie = Movie::where('id', $id)->first();
        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $movie->delete();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
        ], 200);
    }
}
