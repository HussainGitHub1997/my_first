<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'device_id' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        $user = User::where('phone_number', $request->phone_number)->first();
        if (Hash::check($request->password, $user->password) && $user->role == 'admin') {
            $token = $user->createToken('admin_token');
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'token' => $token->plainTextToken
            ]);
        }
    }
    public function loginCustmer(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);
        $subscription = Subscription::where('code', $request->code)->first();
        $custmer = User::all()->where('id', $subscription->user_id)->first();
        $token = $custmer->createToken('custmer_token');
        return response()->json([
            'id' => $custmer->id,
            'name' => $custmer->name,
            'token' => $token->plainTextToken
        ]);
    }
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string'],
        ]);
        $users = User::where('id', $request->id);
        return response()->json(['user' => $users]);
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
