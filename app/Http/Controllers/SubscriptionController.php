<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json(['subscriptions' => $subscriptions]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string'],
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'string'],
            'code' => ['required', 'string'],
            'note' => ['required', 'string'],
            'expire_duration' => ['required', 'bool', 'size:1'],
        ]);
        Subscription::insert([
            'user_id' => $request->user_id,
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'code' => $request->code,
            'note' => $request->note,
            'started_at' => now(),
            'expire_duration' => $request->expire_duration
        ]);
        return response()->json(["'message' => 'Subscription stored successfully'"]);
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            'user_id' => ['required', 'string'],
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'string'],
            'code' => ['required', 'string'],
            'note' => ['required', 'string'],
            'expire_duration' => ['required', 'bool', 'size:1'],
        ]);
        if ($subscription) {
            $subscription->update($request->all());
            return response()->json(['message' => 'Subscription updated successfully']);
        } else {
            return response()->json(['message' => 'not found this subscription Please check your id']);
        }
    }


    public function destroy(Subscription $subscription)
    {
        if ($subscription) {
            $subscription->delete();
            return response()->json(['message' => 'Subscription destroyed successfully']);
        } else {
            return response()->json(['message' => 'not found this subscription Please check your id']);
        }
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string'],
        ]);
        $subscription = Subscription::where('id', $request->id)->first();
        if ($subscription) {
            return response()->json(['Subscription' => $subscription]);
        } else {
            return response()->json(['message' => 'not found this subscription Please check your id']);
        }
    }
}
