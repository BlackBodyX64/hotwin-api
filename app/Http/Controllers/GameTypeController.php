<?php

namespace App\Http\Controllers;

use App\Models\GameType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GameTypeController extends Controller
{
    //เพิ่ม GameType
    public function addGameType(Request $request)
    {

        $name = $request->name;
        $image = $request->file('image');

        //บันทึกไฟล์ลง server
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path('/game_type');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $game_type = new GameType();
        $game_type->name = $name;
        $game_type->image = '/game_type/' . $input;
        $game_type->save();

        $game_type['image_url'] = url($game_type->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $game_type,
        ], 200);
    }

    //เรียกดู GameType
    public function viewGameType($id)
    {
        $game_type = GameType::where('id', $id)->first();

        if (!$game_type) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $game_type['image_url'] = url($game_type->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $game_type,
        ], 200);
    }

    //ดู GameType ทั้งหมด
    public function allGameType()
    {
        $game_types = GameType::get();

        //แทรก image_url เพิ่ม
        foreach ($game_types as $game_type) {
            $game_type['image_url'] = url($game_type->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $game_types,
        ], 200);
    }

    //แก้ไข GameType
    public function editGameType(Request $request, $id) {
        $name = $request->name;
        $image = $request->file('image');

        $game_type = GameType::where('id', $id)->first();
        if (!$game_type) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        //บันทึกไฟล์ลง server
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path('/game_type');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลใหม่
        $game_type->name = $name;
        $game_type->image = '/game_type/' . $input;
        $game_type->save();

        $game_type['image_url'] = url($game_type->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $game_type,
        ], 200);
    }

    //ลบข้อมูล
    public function deleteGameType($id) {
        $game_type = GameType::where('id', $id)->first();
        if (!$game_type) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $game_type->delete();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
        ], 200);
    }
}
