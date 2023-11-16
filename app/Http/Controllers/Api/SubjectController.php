<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
            'term_id' => 'required',
            'name' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {
            return $validator->errors();

        } else {
            $p = User::where('user_name', $request->user_name)->first();
            $db_password = $p->password;
            if (Hash::check($request->password, $db_password)) {
                DB::table('subjects')->insert([
                    'term_id' => $request->term_id,
                    'name' => $request->name,
                    'description' => $request->description,
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

            'term_id' => 'required',
            'id' => 'required',
            'name' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {
            return $validator->errors();

        } else {
            $p = User::where('user_name', $request->user_name)->first();
            $db_password = $p->password;
            if (Hash::check($request->password, $db_password)) {
                DB::table('subjects')->where('id', $request->id)
                    ->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'term_id' => $request->term_id,

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
                DB::table('subjects')->where('id', $request->id)->delete();
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

            $subjects = Subject::all()->where('id', $request->id);
            return response()->json(['subjects' => $subjects]);
        }
    }
    public function index()
    {
        $subjects = Subject::all();
        return response()->json(['subjects' => $subjects]);
    }
}
