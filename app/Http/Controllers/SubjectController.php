<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Resources\SubjectResource;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response()->json([
            'message'   => "These are the subjects",
            'data'  => [
                'Subjects' => SubjectResource::collection($subjects),
            ]
        ]);
    }


    public function show(Subject $subject)
    {
        return response()->json(['subjects' => $subject]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => ['required', 'string'],
            'name' =>['string', 'present'],
            'description' => ['required', 'string'],
        ]);

        $user = $request->user();

        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $subject = Subject::create([
                'unit_id' => $request->unit_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                "message" => "subject insert sucssesfuly",
                "data" => [
                    "subject" => SubjectResource::make($subject),
                ]
            ]);
        }
    }
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'unit_id' => ['required', 'string'],
            'name' =>['string', 'present'],
            'description' => ['required', 'string'],
        ]);

        $user = $request->user();
        if ($user->role != "admin") {
            return new AuthenticationException();
        } else {
            $subject->update($request->all());
            return response()->json([
                'message' => 'subject updated successfully',
                "subject" => [
                    "name" => $request->name,
                    'unit_id' => $request->unit_id,
                    'description' => $request->description,
                ],
            ]);
        }
    }

    public function destroy(Request $request, Subject $subject)
    {
        $user = $request->user();
        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $subject->delete();
            return response()->json(["message"=>"subject destroy sucssesfuly"]);
        }
    }
}
