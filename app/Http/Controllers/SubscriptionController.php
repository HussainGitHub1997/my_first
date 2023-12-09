<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionCollection;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function index()
    {
        return new SubscriptionCollection(Subscription::all());
    }

    public function show(Subscription $subscription)
    {
        Subscription::findOrFail($subscription->id);
        return response()->json(['Subscription' => $subscription]);
    }
    public function store(Request $request, User $user)
    {
        if ($user->role == 'admin') {

            $request->validate([
                'user_id' => ['required', 'string', 'nullable'],
                'model_type' => ['required', 'string', 'nullable'],
                'model_id' => ['required', 'string', 'nullable'],
                'code' => ['required', 'string', 'nullable', 'size:8'],
                'note' => ['required', 'string', 'nullable'],
                'expire_duration' => ['required', 'integer', 'nullable'],
            ]);

            Subscription::insert($request->all());

            return response()->json([
                'message' => 'Subscription stored successfully',
                "Subscription" => [
                    'user_id' => $request->user_id,
                    'model_type' => $request->model_type,
                    'model_id' => $request->model_id,
                    'code' => $request->code,
                    'note' => $request->note,
                    'expire_duration' => $request->expire_duration
                ]
            ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
    public function update(Request $request, User $user, Subscription $subscription)
    {
        if ($user->role == 'admin') {
            $request->validate([
                'user_id' => ['required', 'string', 'nullable'],
                'model_type' => ['required', 'string', 'nullable'],
                'model_id' => ['required', 'string', 'nullable'],
                'code' => ['required', 'string', 'nullable', 'size:8'],
                'note' => ['required', 'string', 'nullable'],
                'expire_duration' => ['required', 'integer', 'nullable'],
            ]);


            Subscription::findOrFail($subscription->id); 

                $subscription->update($request->all());
                return response()->json([
                    'message' => 'Subscription updated successfully',
                    "Subscription" => [
                        'user_id' => $request->user_id,
                        'model_type' => $request->model_type,
                        'model_id' => $request->model_id,
                        'code' => $request->code,
                        'note' => $request->note,
                        'expire_duration' => $request->expire_duration
                    ]
                ]);
            
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }


    public function destroy(user $user, Subscription $subscription)
    {
        if ($user->role == 'admin') {
            Subscription::findOrFail($subscription->id);
            $subscription->delete();
            return response()->json(['message' => 'Subscription destroyed successfully']);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
}
