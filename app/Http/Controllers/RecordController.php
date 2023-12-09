<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Resources\RecordCollection;
use App\Models\User;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::where('is_free', true)->where('is_subscribed', true)->get();
        return new RecordCollection($records);
    }

    public function show(Record $record)
    {
        if ($record->is_free || $record->is_subscribed) {
            return response()->json(['record' => $record->path]);
        }
    }

    public function store(Request $request, User $user)
    {
        if ($user->role == 'admin') {
            $request->validate([
                'section_id' => ['required', 'string', 'nullable'],
                'name' => ['required', 'string', 'alpha_dash:ascii', 'nullable'],
                'description' => ['required', 'string', 'nullable'],
                'is_free' => ['required', 'bool'],
                'path' => ['required', 'string', 'nullable'],
            ]);

            Record::insert($request->all());

            return response()->json([
                "message: " => "record insert sucssesfuly",
                "record" => [
                    'section_id' => $request->section_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'path' => $request->path,
                    'is_free' => $request->is_free,
                ]
            ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }

    public function update(Request $request, User $user, Record $record)
    {
        if ($user->role == 'admin') {
            $request->validate([
                'section_id' => ['required', 'string', 'nullable'],
                'name' => ['required', 'alpha_dash:ascii', 'nullable'],
                'description' => ['required', 'string', 'nullable'],
                'is_free' => ['required', 'bool'],
                'path' => ['required', 'string', 'nullable'],
            ]);

            Record::findOrFail($record->id);
            
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
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }

    public function destroy(User $user, Record $record)
    {
        if ($user->role == "admin") {
            Record::findOrFail($record->id);
            $record->delete();
            return response()->json(['message' => 'record destroy successfully']);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
}
