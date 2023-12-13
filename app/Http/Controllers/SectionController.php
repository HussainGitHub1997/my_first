<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return response()->json([
            'message'   => "These are the sections",
            'data'  => [
                'Sections' => SectionResource::collection($sections),
            ]
        ]);
    }

    public function show(Section $section)
    {
        return response()->json(['section' => $section]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => ['required', 'string'],
            'name' => ['string', 'present'],
            'description' => ['required', 'string'],
        ]);

        $user = $request->user();

        if ($user->role != 'admin') {
            return new AuthenticationException;
        } else {
            $section = Section::create([
                'subject_id'    => $request->subject_id,
                'name'          => $request->name,
                'description'   => $request->description,
            ]);
            return response()->json([
                "message" => "section insert sucssesfuly",
                "data" => [
                    "section" => SectionResource::make($section),
                ]
            ]);
        }
    }

    public function update(Section $section, Request $request)
    {
        $request->validate([
            'subject_id' => ['required', 'string'],
            'name' => ['string', 'present'],
            'description' => ['required', 'string'],
        ]);

        $user = $request->user();

        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $section->update($request->all());
            return response()->json([
                'message' => 'section updated successfully',
                "section" => [
                    "name" => $request->name,
                    'subject_id' => $request->subject_id,
                    'description' => $request->description,
                ],
            ]);
        }
    }

    public function destroy(Request $request, Section $section)
    {
        $user = $request->user();
        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $section->delete();
            return response()->json(['message' => 'record destroy successfully']);
        }
    }
}
