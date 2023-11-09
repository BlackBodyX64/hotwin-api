<?php

namespace App\Http\Controllers;

use App\Models\Casino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CasinoController extends Controller
{
    //เพิ่ม Casino
    public function addCasino(Request $request)
    {

        $name = $request->name;
        $image = $request->file('image');

        //บันทึกไฟล์ลง server
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path('/casino');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $casino = new Casino();
        $casino->name = $name;
        $casino->image = '/casino/' . $input;
        $casino->save();

        $casino['image_url'] = url($casino->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $casino,
        ], 200);
    }

    //เรียกดู Casino
    public function viewCasino($id)
    {
        $casino = Casino::where('id', $id)->first();

        if (!$casino) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $casino['image_url'] = url($casino->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $casino,
        ], 200);
    }

    //ดู Casino ทั้งหมด
    public function allCasino()
    {
        $casinos = Casino::get();

        //แทรก image_url เพิ่ม
        foreach ($casinos as $casino) {
            $casino['image_url'] = url($casino->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $casinos,
        ], 200);
    }

    //แก้ไข Casino
    public function editCasino(Request $request, $id) {
        $name = $request->name;
        $image = $request->file('image');

        $casino = Casino::where('id', $id)->first();
        if (!$casino) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        //บันทึกไฟล์ลง server
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path('/casino');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลใหม่
        $casino->name = $name;
        $casino->image = '/casino/' . $input;
        $casino->save();

        $casino['image_url'] = url($casino->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $casino,
        ], 200);
    }

    //ลบข้อมูล
    public function deleteCasino($id) {
        $casino = Casino::where('id', $id)->first();
        if (!$casino) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $casino->delete();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
        ], 200);
    }
}
