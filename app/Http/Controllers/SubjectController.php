<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\SubjectCollection;
use App\Models\User;

class SubjectController extends Controller
{
    public function index()
    {
        return new SubjectCollection(Subject::all());
    }

    public function show(Subject $subject)
    {
        Subject::findOrFail($subject->id);
        return response()->json(['subjects' => $subject]);
    }

    public function store(Request $request, User $user)
    {
        if ($user->role == 'admin') {
            $request->validate([
                'unit_id' => ['required', 'string', 'nullable'],
                'name' => ['required', 'alpha_dash:ascii', 'string', 'nullable'],
                'description' => ['required', 'string', 'nullable'],
            ]);

            Subject::insert($request->all());

            return response()->json([
                "message" => "subject insert sucssesfuly",
                "subject" => [
                    "name" => $request->name,
                    'unit_id' => $request->unit_id,
                    'description' => $request->description,
                ]
            ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
    public function update(Request $request, User $user, Subject $subject)
    {
        if ($user->role == "admin") {
            $request->validate([
                'unit_id' => ['required', 'string', 'nullable'],
                'name' => ['required', 'alpha_dash:ascii', 'string', 'nullable'],
                'description' => ['required', 'string', 'nullable'],
            ]);

            Subject::findOrFail($subject->id);
            $subject->update($request->all());
            return response()->json([
                'message' => 'subject updated successfully',
                "subject" => [
                    "name" => $request->name,
                    'unit_id' => $request->unit_id,
                    'description' => $request->description,
                ],
            ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }

    public function destroy(User $user, Subject $subject)
    {
        if ($user->role == 'admin') {
            Subject::findOrFail($subject->id);
            $subject->delete();
            return response()->json(["subject destroy sucssesfuly"]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
}
