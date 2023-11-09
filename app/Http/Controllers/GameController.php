<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GameController extends Controller
{
    public function add(Request $request)
    {

        $name = $request->name;
        $image = $request->file('image');
        $popular = $request->popular;
        $url = $request->url;
        $casino_id = $request->casino_id;
        $game_type_id = $request->game_type_id;

        //บันทึกไฟล์ลง server
        $path = '/game/';
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path($path);

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $game = new Game();
        $game->name = $name;
        $game->image = $path . $input;
        $game->popular = $popular;
        $game->url = $url;
        $game->casino_id = $casino_id;
        $game->game_type_id = $game_type_id;
        $game->save();

        $game['image_url'] = url($game->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $game,
        ], 200);
    }

    public function view($id)
    {
        $game = Game::where('id', $id)->first();

        if (!$game) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $game['image_url'] = url($game->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $game,
        ], 200);
    }

    public function all()
    {
        $games = Game::get();

        //แทรก image_url เพิ่ม
        foreach ($games as $game) {
            $game['image_url'] = url($game->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $games,
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        //ค้นหาข้อมูลใน database จาก id
        $game = Game::where('id', $id)->first();

        if (!$game) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $name = $request->name;
        $image = $request->file('image');
        $popular = $request->popular;
        $url = $request->url;
        $casino_id = $request->casino_id;
        $game_type_id = $request->game_type_id;

        //บันทึกไฟล์ลง server
        $path = '/game/';
        $input = time() . '.' . $image->extension();
        $destinationPath = public_path($path);

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }
        $image->move($destinationPath, $input);

        //บันทึกข้อมูลลงตาราง
        $game->name = $name;
        $game->image = $path . $input;
        $game->popular = $popular;
        $game->url = $url;
        $game->casino_id = $casino_id;
        $game->game_type_id = $game_type_id;
        $game->save();

        $game['image_url'] = url($game->image);

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
            'data' => $game,
        ], 200);
    }

    public function delete($id) {
        $game = Game::where('id', $id)->first();
        if (!$game) {
            return response()->json([
                'status' => false,
                'message' => 'ไม่พบข้อมูล'
            ], 400);
        }

        $game->delete();

        return response()->json([
            'status' => true,
            'message' => 'สำเร็จ',
        ], 200);
    }
}
