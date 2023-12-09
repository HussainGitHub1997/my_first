<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Resources\SectoinCollection;
use App\Models\User;

class SectionController extends Controller
{
    public function index()
    {
        return new SectoinCollection(Section::all());
    }

    public function show(Section $section)
    {
        Section::findOrFail($section->id);
            return response()->json(['section' => $section]);
    }

    public function store( User $user,Request $request)
    {
        if ($user->role == 'admin') {
            $request->validate([
                'subject_id' => ['required', 'string','nullable'],
                'name' => ['required','alpha_dash:ascii' , 'string','nullable'],
                'description' => ['required', 'string','nullable'],
            ]);

            Section::insert($request->all());

            return response()->json([
                "message" => "section insert sucssesfuly",
                "section" => [
                    "name" => $request->name,
                    'subject_id' => $request->subject_id,
                    'description' => $request->description,
                ]
            ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }

    public function update(User $user, Section $section, Request $request)
    {  
        if ($user->role == 'admin') {
        $request->validate([
            'subject_id' => ['required', 'string','nullable'],
                'name' => ['required','alpha_dash:ascii' , 'string','nullable'],
                'description' => ['required', 'string','nullable'],
        ]);

        Section::findOrFail($section->id);
        
            $section->update($request->all());
            return response()->json(['message' => 'section updated successfully',
            "section" => [
                "name" => $request->name,
                'subject_id' => $request->subject_id,
                'description' => $request->description,
            ],
        ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }

    public function destroy(User $user, Section $section)
    {
        if ($user->role == 'admin') {
            Section::findOrFail($section->id);
            $section->delete();
            return response()->json(["section destroy sucssesfuly"]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
}
