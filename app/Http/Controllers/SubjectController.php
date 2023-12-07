<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response()->json(['subjects' => $subjects]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        Subject::insert($request->all());
        return response()->json(["name" => $request->name, "insert sucssesfuly"]);
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'unit_id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        if ($subject) {
            $subject->update($request->all());
            return response()->json(['message' => 'subject updated successfully']);
        } else {
            return response()->json(['message' => 'not found this subject Please check your id']);
        }
    }

    public function destroy(Subject $subject)
    {
        if ($subject) {
            $subject->delete();
            return response()->json(["subject destroy sucssesfuly"]);
        } else {
            return response()->json(['message' => 'not found this subject Please check your id']);
        }
    }
    public function show(Request $request)
    {
        $request->validate(['id' => ['required', 'string'],]);
        $subject = Subject::where('id', $request->id)->first();
        if ($subject) {
            return response()->json(['subjects' => $subject]);
        } else {
            return response()->json(['message' => 'not found this subject Please check your id']);
        }
    }
}
