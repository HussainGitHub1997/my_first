<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json([
            'message'   => "These are the subscriptions",
            'data'  => [
                'Subscriptions' => SubscriptionResource::collection($subscriptions),
            ]
        ]);
    }

    public function show(Subscription $subscription)
    {
        return response()->json(['Subscription' => $subscription]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string'],
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'string'],
            'code' => ['required', 'string', 'size:8'],
            'note' => ['required', 'string'],
            'expire_duration' => ['required', 'integer'],
        ]);

        $user = $request->user();

        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $subscription = Subscription::create([
                'user_id'         => $request->user_id,
                'model_type'      => 'App\Models\\' . $request->model_type,
                'model_id'        => $request->model_id,
                'code'            => $request->code,
                'note'            => $request->note,
                'expire_duration' => $request->expire_duration,
            ]);

            return response()->json([
                'message' => 'Subscription stored successfully',
                "data" => [
                    'subscription' => SubscriptionResource::make($subscription),
                ]
            ]);
        }
    }
    public function update(Request $request,  Subscription $subscription)
    {
        $request->validate([
            'user_id' => ['required', 'string'],
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'string'],
            'code' => ['required', 'string', 'size:8'],
            'note' => ['required', 'string'],
            'expire_duration' => ['required', 'integer'],
        ]);

        $user = $request->user();

        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
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
        }
    }


    public function destroy(Request $request, Subscription $subscription)
    {
        $user = $request->user();
        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $subscription->delete();
            return response()->json(['message' => 'Subscription destroyed successfully']);
        }
    }
}
