<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Routes;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    public function index()
    {
        try {
            $data['routes'] = Routes::all();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function show($id)
    {
        try {
            $data['route'] = Routes::find($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            $data['route'] = Routes::create($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data['route'] = Routes::find($id)->update($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $data['route'] = Routes::find($id)->delete();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
