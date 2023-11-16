<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function login_admin(request $request)
    {

        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            //  return  $validator->withErrors($validator)->withInput();
            return $validator->errors();

        } else {

            $p = User::where('device_id', $request->device_id)->first();
            $db_password = $p->password;
            if (Hash::check($request->password, $db_password)) {
                $user = User::where('phone_number', $request->phone_number)->
                    where('device_id', $request->device_id)->first();
                if ($user->role == 'admin') {
                    $token = $user->createToken('admin_token');
                    return response()->json([
                        'id' => $user->id,
                        'name' => $user->name,
                        'token' => $token->plainTextToken
                    ]);


                }
            }
        }

    }
    public function login_custmer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();

        } else {

            $user = Subscription::all()->where('code', $request->code)->first();
            $user_id = $user->user_id;
            $custmer = User::all()->where('id', $user_id);
            $token = $custmer->createToken('custmer_token');

                    return response()->json([
                        'id' => $user->id,
                        'name' => $user->name,
                        'token' => $token->plainTextToken
                    ]);
        }






    }
}
