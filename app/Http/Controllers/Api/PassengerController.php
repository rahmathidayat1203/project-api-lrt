<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function index()
    {
        try {
            $data['passengers'] = Passenger::all();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function show($id)
    {
        try {
            $data['passenger'] = Passenger::find($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            $data['passenger'] = Passenger::create($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data['passenger'] = Passenger::find($id)->update($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $data['passenger'] = Passenger::find($id)->delete();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
