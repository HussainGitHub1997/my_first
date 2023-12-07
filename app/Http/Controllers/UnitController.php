<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return response()->json(['units' => $units]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        Unit::insert($request->all());
        return response()->json(["name" => $request->name, "insert sucssesfuly"]);
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        if ($unit) {
            $unit->update($request->all());
            return response()->json(['message' => 'unit updated successfully']);
        } else {
            return response()->json(['message' => 'not found this unit Please check your id']);
        }
    }

    public function destroy(Unit $unit)
    {
        if ($unit) {
            $unit->delete();
            return response()->json(['message' => 'unit destroyed successfully']);
        } else {
            return response()->json(['message' => 'not found this unit Please check your id']);
        }
    }

    public function show(Request $request)
    {
        $request->validate(['id' => ['required', 'string'],]);
        $unit = Unit::where('id', $request->id)->first();
        if ($unit) {
            return response()->json(['units' => $unit]);
        } else {
            return response()->json(['message' => 'not found this unit Please check your id']);
        }
    }
}
