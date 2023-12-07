<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;


class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return response()->json(['sections' => $sections]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        Section::insert($request->all());
        return response()->json(["name" => $request->name, "insert sucssesfuly"]);
    }

    public function update(Section $section, Request $request)
    {
        $request->validate([
            'subject_id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        if ($section) {
            $section->update($request->all());
            return response()->json(['message' => 'section updated successfully']);
        } else {
            return response()->json(['message' => 'not found this section Please check your id']);
        }
    }

    public function destroy(Section $section)
    {
        if ($section) {
            $section->delete();
            return response()->json(["section destroy sucssesfuly"]);
        } else {
            return response()->json(['message' => 'not found this section Please check your id']);
        }
    }
    public function show(Request $request)
    {
        $request->validate(['id' => 'required',]);
        $section = Section::where('id', $request->id)->first();
        if ($section) {
            return response()->json(['section' => $section]);
        } else {
            return response()->json(['message' => 'not found this section Please check your id']);
        }
    }
}
