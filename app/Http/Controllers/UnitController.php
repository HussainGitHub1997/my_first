<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Resources\UnitResource;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return response()->json([
            'message'   => "These are the units",
            'data'  => [
                'units' => UnitResource::collection($units),
            ]
        ]);
    }

    public function show(Unit $unit)
    {
        return response()->json(['unit' => $unit]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => ['string', 'present'],
            'description'   => ['nullable', 'string'],
        ]);
        $user = $request->user();
        if ($user->role != 'admin') {
            throw new AuthenticationException();
        }
        $unit = Unit::create([
            'name'          => $request->name,
            'description'   => $request->description,
        ]);
        return response()->json([
            "message" => "unit insert sucssesfuly",
            'data'  => [
                'unit' => UnitResource::make($unit),
            ]
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => ['string', 'present'],
            'description' => ['string', 'nullable'],
        ]);
        $user = $request->user();

        if ($user->role != 'admin') {
            throw new AuthenticationException();
        } else {
            $unit->update($request->all());
            return response()->json([
                'message' => 'unit updated successfully',
                "unit" => [
                    "name" => $request->name,
                    "description" => $request->description,
                ]
            ]);
        }
    }

    public function destroy(Request $request, Unit $unit)
    {
        $user = $request->user();
        if ($user->role != 'admin') {
            return new AuthenticationException();
        } else {
            $unit->delete();
            return response()->json(['message' => 'unit destroyed successfully']);
        }
    }
}
