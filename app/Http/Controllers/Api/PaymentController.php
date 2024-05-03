<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        try {
            $data['payments'] = Payment::all();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function show($id){
        try {
            $data['payment'] = Payment::find($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function store(Request $request){
        try {
            $data['payment'] = Payment::create($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function update(Request $request, $id){
        try {
            $data['payment'] = Payment::find($id)->update($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function destroy($id){
        try {
            $data['payment'] = Payment::find($id)->delete();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
