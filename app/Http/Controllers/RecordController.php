<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::all();
        foreach ($records as $record) {
            if ($record->is_free || $record->is_subscribed) {
                echo json_encode($record) . "\n";
            }
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'is_subscribed' => ['required', 'bool'],
            'is_free' => ['required', 'bool'],
            'url' => ['required', 'string'],
        ]);
        Record::insert([
            'section_id' => $request->section_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_subscribed' => $request->is_subscribed,
            'expries_at' => now(),
            'url' => $request->url,
            'is_free' => $request->is_free
        ]);
        return response()->json(["name" => $request->name, "insert sucssesfuly"]);
    }

    public function update(Request $request, Record $record)
    {
        $request->validate([
            'section_id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'is_subscribed' => ['required', 'bool', 'size:1'],
            'is_free' => ['required', 'bool', 'size:1'],
        ]);
        if ($record) {
            $record->update($request->all());
            return response()->json(['message' => 'record updated successfully']);
        } else {
            return response()->json(['message' => 'not found this record Please check your id']);
        }
    }

    public function destroy(Record $record)
    {
        if ($record) {
            $record->delete();
            return response()->json(['message' => 'record destroy successfully']);
        } else {
            return response()->json(['message' => 'not found this record Please check your id']);
        }
    }
    public function show(Request $request)
    {
        $request->validate(['id' => ['required', 'string'],]);
        $record = Record::where('id', $request->id)->first();
        if ($record) {
            if ($record->is_free || $record->is_subscribed) {
                return response()->json(['record' => $record]);
            } else {
                return response()->json(['message' => 'You do not have any subscriptions']);
            }
        } else {
            return response()->json(['message' => 'not found this record Please check your id']);
        }
    }
}
