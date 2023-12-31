<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;

class UserController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'device_id' => ['required', 'string'],
            'phone_number' => ['required', 'numeric'],
            'password' => ['required', 'string', 'present'],
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
    public function loginClient(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:8'],
        ]);

        $subscription = Subscription::where('code', $request->code)->first();
        $client = User::where('id', $subscription->user_id)->first();
        if ($subscription->started_at) {
            $token = $client->createToken('client_token');
            return response()->json([
                'message' => 'Your subscription has been registered successfully',
                'data' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'token' => $token->plainTextToken
                ],
            ]);
        } else {
            $subscription->update(['started_at' => now()]);
            $token = $client->createToken('client_token');
            return response()->json([
                'message' => 'Your subscription has been registered successfully',
                'data' => [
                    'id' => $client->id,
                    'name' => $client->name,
                    'token' => $token->plainTextToken
                ],
            ]);
        }
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => ['string', 'present'],
            'device_id' => ['present', 'string'],
            'phone_number' => ['required', 'numeric'],
            'password' => ['string', 'present', 'required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone_number'  => $request->phone_number,
            'device_id'     => $request->device_id,
            'password'      => Hash::make($request->password),
        ]);

        return response()->json([
            'message ' => 'client created succesfully',
            'data' => [
                UserResource::make($user),
            ]
        ]);
    }

    public function generateSubscription(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string'],
            'model_id' => ['required', 'string'],
            'note' => ['required', 'string'],
            'expire_duration' => ['required', 'integer'],
            'model_type' => ['required', 'string'],
        ]);
        $rand_start = rand(1, 5);
        $uniqid = uniqid();
        $code = substr($uniqid, $rand_start, 8);
        while ($code != Subscription::where('code', $code)->first()) {
            $rand_start = rand(1, 5);
            $uniqid = uniqid();
            $code = substr($uniqid, $rand_start, 8);
        }
        $user = $request->user();
        if ($user->role == 'admin') {

            $subscription = Subscription::create([
                'user_id' => $request->user_id,
                'model_type' => $request->model_type,
                'model_id' => $request->model_id,
                'code' => $code,
                'note' => $request->note,
                'expire_duration' => $request->expire_duration
            ]);
            return response()->json([
                'message' => 'Subscription stored successfully',
                "data" => [
                    'Subscription' => SubscriptionResource::make($subscription),
                ]
            ]);
        }
    }


    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role != 'admin')
            return new AuthenticationException();
        else {
            $users = User::all();
            return response()->json([
                'message' => 'these are the users',
                'data' => [
                    'users' => UserResource::collection($users)
                ],
            ]);
        }
    }

    public function show(User $user)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
