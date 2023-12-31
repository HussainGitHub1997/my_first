<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Resources\RecordResource;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\Unit;
use App\Models\User;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::all();
        return response()->json([
            'message'   => "These are the records",
            'data'  => [
                'records' => RecordResource::collection($records),
            ]
        ]);
    }

    public function show(Request $request, Record $record)
    {
        $section = Section::find($record->section_id);
        $subject = Subject::find($section->subject_id);
        $subscription_subject = $subject->subscription;
        $unit = Unit::find($subject->unit_id);
        $subscription_unit = $unit->subscription;
        $user = User::findOrFail($request->user()->id);
        $subscription_user = Subscription::where('user_id', $user->id)->first();
        $now_date = date('Y-m-d');
        $started_date = $subscription_user->started_at;
        $time = strtotime($now_date) - strtotime($started_date);
        $days = $time / (24 * 60 * 60) - $subscription_user->expire_duration;
        if (!$subscription_unit || !$subscription_subject) {
            return response()->json([
                'record' => [
                    'path' => $record->path,
                    'description' => $record->description,
                    'expired_at' => $record->expired_at,
                    'is_subscribed' => $record->is_subscribed,
                ],
            ]);
        }
        if ($record->is_free) {
            return response()->json([
                'record' => [
                    'path' => $record->path,
                    'description' => $record->description,
                    'expired_at' => $record->expired_at,
                    'is_subscribed' => $record->is_subscribed,
                ],
            ]);
        } elseif ($days <= 0) {
            return response()->json([
                'message' => 'sorry Your subscription has expired',
                'record' => [
                    'id' => $record->id,
                    'section_id' => $record->section_id,
                    'name' => $record->name,
                    'is_free' => $record->is_free,
                ],
            ]);
        } elseif ($days > 0 && $subscription_unit->user_id == $user->id || $user->id == $subscription_subject->user_id) {

            $subscription = Subscription::where('user_id', $user->id)->first();
            $rand_start = rand(1, 5);
            $uniqid = uniqid();
            $code = substr($uniqid, $rand_start, 8);
            $subscription->update(['code' => $code]);
            $record->update(['is_subscribed' => true]);

            return response()->json([
                'message' => "you have $days day to your subscription",
                'record' => [
                    'path' => $record->path,
                    'description' => $record->description,
                    'expired_at' => $record->expired_at,
                    'is_subscribed' => $record->is_subscribed,
                ],
            ]);
        } else {
            return response()->json([
                'record' => [
                    'id' => $record->id,
                    'section_id' => $record->section_id,
                    'name' => $record->name,
                    'is_free' => $record->is_free,
                ],
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => ['required', 'string'],
            'name' => ['string', 'present'],
            'description' => ['required', 'string'],
            'is_free' => ['required', 'bool'],
            'path' => ['required', 'string',],
        ]);

        $user = $request->user();
        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $record = Record::create([
                'section_id'    => $request->section_id,
                'name'          => $request->name,
                'description'   => $request->description,
                'is_free'       => $request->is_free,
                'path'          => $request->path,
            ]);

            return response()->json([
                "message: " => "record insert sucssesfuly",
                "data" => [
                    "Records" => RecordResource::make($record),
                ]
            ]);
        }
    }

    public function update(Request $request, Record $record)
    {
        $request->validate([
            'section_id' => ['required', 'string'],
            'name' => ['string', 'present'],
            'description' => ['required', 'string'],
            'is_free' => ['required', 'bool'],
            'path' => ['required', 'string'],
        ]);

        $user = $request->user();

        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $record->update($request->all());
            return response()->json([
                'message' => 'record updated successfully',
                "record" => [
                    'section_id' => $request->section_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'path' => $request->path,
                    'is_free' => $request->is_free,
                ]
            ]);
        }
    }

    public function destroy(Request $request, Record $record)
    {
        $user = $request->user();
        if ($user->role != "admin") {
            return new AuthenticationException();
        } else {
            $record->delete();
            return response()->json(['message' => 'record destroy successfully']);
        }
    }
}
