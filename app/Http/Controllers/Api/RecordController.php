<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            'subject_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'is_subscribed' => 'required',
            'expries_at' => 'required',
            'is_free' => 'required',

        ]);

        if ($validator->fails()) {
            return $validator->errors();

        } else {
            $p = User::where('user_name', $request->user_name)->first();
            $db_password = $p->password;
            if (Hash::check($request->password, $db_password)) {

                DB::table('records')->insert([
                    'subject_id' => $request->subject_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'is_subscribed' => $request->is_subscribed,
                    'expries_at' => $request->expries_at,

                    'is_free' => $request->is_free,

                ]);

                return response()->json(["name" => $request->name, "insert sucssesfuly"]);
            }

        }
    }
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            'subject_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'is_subscribed' => 'required',
            'expries_at' => 'required',
            'is_free' => 'required',
            'id' => 'required',

        ]);
        if ($validator->fails()) {
            return $validator->errors();

        } else {
            $p = User::where('user_name', $request->user_name)->first();
            $db_password = $p->password;
            if (Hash::check($request->password, $db_password)) {
                DB::table('records')->where('id', $request->id)
                    ->update([
                        'subject_id' => $request->subject_id,
                        'name' => $request->name,
                        'description' => $request->description,
                        'is_subscribed' => $request->is_subscribed,
                        'expries_at' => $request->expries_at,
                        'is_free' => $request->is_free,

                    ]);
                return response()->json(["name" => $request->name, "updated sucssesfuly"]);

            }
        }
    }
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            'id' => 'required',

        ]);

        if ($validator->fails()) {
            return $validator->errors();

        } else {
            $p = User::where('user_name', $request->user_name)->first();
            $db_password = $p->password;
            if (Hash::check($request->password, $db_password)) {
                DB::table('records')->where('id', $request->id)->delete();
                return response()->json(["destroy sucssesfuly"]);

            }
        }
    }
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();

        } else {

            $records = Record::all()->where('id', $request->id);
            return response()->json(['records' => $records]);
        }
    }
    public function index(Request $request)
    {
        $records = Record::all()->where('is_free',true);
        return response()->json(['records' => $records]);
    }
}
