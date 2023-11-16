<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    public function sign_up(request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'device_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();

        } else {
            DB::table('users')->insert([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'device_id' => $request->device_id,
                'role' => 'custmer',
                'password' => Hash::make($request->password),
            ]);



            return response()->json(['welcome ' => $request->name]);
        }




    }

}
