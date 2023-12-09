<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;


class UserController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'device_id' => ['required', 'string'],
            'phone_number' => ['required', 'string','alpha_num:ascii'],
            'password' => ['required', 'string','alpha_dash:ascii'],
        ]);
        $user = User::where('phone_number', $request->phone_number)->first();
        if (Hash::check($request->password, $user->password) && $user->role == 'admin')
         {
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
            'code' => ['required', 'string','size:8'],
        ]);
        
        $subscription = Subscription::where('code', $request->code)->first();
        $client = User::where('id', $subscription->user_id)->first();
        $subscription->update(['started_at'=>now()]);
        $token = $client->createToken('client_token');
        return response()->json([
            'id' => $client->id,
            'name' => $client->name,
            'token' => $token->plainTextToken
        ]);
    }

    public function signup(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string','alpha_dash:ascii'],
            'device_id' => ['required', 'string'],
            'phone_number' => ['required', 'string','alpha_num:ascii'],
            'password' => ['required', 'string','current_password:api'],
        ]);

        User::insert([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'device_id' => $request->device_id,
            'role' => 'client',
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'welcome ' => $request->name
        ]);
    }

    public function generateCode(){
        $rand_start = rand(1,5);
        $uniqid = uniqid();
        $code = substr($uniqid,$rand_start,8);
        while($code==Subscription::find($code)){
            $rand_start = rand(1,5);
            $uniqid = uniqid();
            $code = substr($uniqid,$rand_start,8);
        }
        return $code;
    }

    public function index()
    {
        return new UserCollection(User::all());
    }

    public function show(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
