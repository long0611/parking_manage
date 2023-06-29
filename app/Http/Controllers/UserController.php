<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UserController extends Controller
{
    public function welcome(){
        $khu = DB::table('khu')->get();
        $khu_slot = DB::table('khu_slot')->get();
        $slot = DB::table('slot')->get();
        return view('welcome' , compact("khu_slot" , "khu" , "slot"));
    }
    public function quanlyben(){
        $khu = DB::table('khu')->get();
        return view("quanlyben" , compact("khu"));
    }

    public function themBen(Request $res){
        DB::table('khu_slot')->insert($res->except("_token"));
        return redirect()->route("quanLyBen");
    }

    public function themKhu(Request $res){
        DB::table('khu')->insert($res->except("_token"));
        return redirect()->route("quanLyBen");
    }

    public function uploadFile(Request $request){
        if($request->file('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();

            // File extension
            $extension = $file->getClientOriginalExtension();

            // File upload location
            $location = 'files';

            // Upload file
            $file->move(public_path('/uploadedimages'),$filename);

            echo $filename;

        }
    }

    public function getEmptySlot(){
        $empty_slot = DB::table('khu_slot')->where("status" , 0)->first();
        $khu = DB::table('khu')->where("id_khu" , $empty_slot->khu_id)->first();
        $op = array();
        $op["khu_slot"] = $empty_slot;
        $op["ten_khu"] = $khu->ten_khu;

        return json_encode($op);
    }

    public function uploadNewSlot(Request $res){
        DB::table('khu_slot')->where("khu_slot_id" , $res->khu_slot_id)->update(["status" => 1]);
        DB::table('slot')->insert($res->except("_token"));
        return redirect()->back();
    }

    public function getSlotDetail($slot_id){
        return json_encode(DB::table("slot")->where("khu_slot_id" , $slot_id)->first());
    }

    public function getSlotDetailUUID($uuid){
        return json_encode(DB::table("slot")->where("mathexe" , $uuid)->first());
    }

    public function finishSlot($slot_id , $khu_slot_id){
        DB::table("khu_slot")->where("khu_slot_id" , $khu_slot_id)->update(["status" => 0]);
        $dt = Carbon::now('Asia/Ho_Chi_Minh');
   
        DB::table("slot")->where("id" , $slot_id)->update(["trangthai" => 1 , "thoigianra" => $dt]);
    }

    public function finishSlotWithUUID($UUID){
        $uuid_object = DB::table('slot')->where("mathexe", $UUID)->first();
        DB::table('slot')->where("mathexe", $UUID)->update(["trangthai" => 1]);
        DB::table("khu_slot")->where("khu_slot_id" , $uuid_object->khu_slot_id)->update(["status" => 0]);
    }

    public function lichsuben(){
        $slot = DB::table('slot')->get();
        return view("lichsu" , compact("slot"));
    }

    public function getLichSu(){
        return json_encode(DB::table('slot')->get());
    }

    public function detectPlate($fileName){
    
        $output=null;
        $retval=null;
        exec('python -W ignore C:\Users\Hieu\Desktop\QLBDX\laravel_qlbdx\python\api.py "C:\Users\Hieu\Desktop\QLBDX\laravel_qlbdx\public\uploadedimages\\' . $fileName . '"' . " 2>&1", $output, $retval);
        try {
            return $output[0];
        }
        catch (\Exception $e) {
            return "Error";
        }
        
    }


}
