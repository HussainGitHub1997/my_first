<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function signup(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'password' => ['required', 'string'],
            'device_id' => ['required', 'string'],
        ]);
        User::insert([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'device_id' => $request->device_id,
            'role' => 'custmer',
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['welcome ' => $request->name]);
    }
}
