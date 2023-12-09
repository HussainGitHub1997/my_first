<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Resources\UnitCollection;
use App\Models\User;

class UnitController extends Controller
{
    public function index()
    {
        return new UnitCollection(Unit::all());
    }

    public function show(Unit $unit)
    {
        Unit::findOrFail($unit->id);
        return response()->json(['unit' => $unit]);
    }

    public function store(Request $request, User $user)
    {
        if ($user->role == 'admin') {
            $request->validate([
                'name' => ['required', 'alpha_dash:ascii', 'string', 'nullable'],
                'description' => ['required', 'string', 'nullable'],
            ]);

            Unit::insert($request->all());

            return response()->json([
                "message" => "unit insert sucssesfuly",
                "unit" => [
                    "name" => $request->name,
                    "description" => $request->description,
                ]
            ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
    public function update(Request $request, User $user, Unit $unit)
    {
        if ($user->role == 'admin') {
            $request->validate([
                'name' => ['required', 'alpha_dash:ascii', 'nullable'],
                'description' => ['required', 'string', 'nullable'],
            ]);

            Unit::findOrFail($unit->id);

            $unit->update($request->all());
            return response()->json([
                'message' => 'unit updated successfully',
                "unit" => [
                    "name" => $request->name,
                    "description" => $request->description,
                ]
            ]);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }

    public function destroy(User $user, Unit $unit)
    {
        if ($user->role == 'admin') {
            Unit::findOrFail($unit->id);
            $unit->delete();
            return response()->json(['message' => 'unit destroyed successfully']);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            include("error401.php");
            exit;
        }
    }
}
