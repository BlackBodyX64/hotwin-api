<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PromotionController extends Controller
{
    public function add(Request $request)
    {
        $name = $request->name;
        $image = $request->file('image');
        $url = $request->url;

        //บันทึกไฟล์ลง server
        $path = '/promotion/';
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path($path);

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $promotion = new Promotion();
        $promotion->name = $name;
        $promotion->image = $path . $input;
        $promotion->url = $url;
        $promotion->save();

        $promotion['image_url'] = url($promotion->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $promotion,
        ], 200);
    }

    public function view($id)
    {
        $promotion = Promotion::where('id', $id)->first();

        if (!$promotion) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $promotion['image_url'] = url($promotion->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $promotion,
        ], 200);
    }

    public function all()
    {
        $promotions = Promotion::get();

        //แทรก image_url เพิ่ม
        foreach ($promotions as $promotion) {
            $promotion['image_url'] = url($promotion->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $promotions,
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        //ค้นหาข้อมูลใน database จาก id
        $promotion = Promotion::where('id', $id)->first();

        if (!$promotion) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $name = $request->name;
        $image = $request->file('image');
        $url = $request->url;

        //บันทึกไฟล์ลง server
        $path = '/promotion/';
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path($path);

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $promotion->name = $name;
        $promotion->image = $path . $input;
        $promotion->url = $url;
        $promotion->save();

        $promotion['image_url'] = url($promotion->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $promotion,
        ], 200);
    }

    public function delete($id) {
        $promotion = Promotion::where('id', $id)->first();
        if (!$promotion) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $promotion->delete();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
        ], 200);
    }
}
