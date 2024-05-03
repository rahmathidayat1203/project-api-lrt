<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $data['bookings'] = Booking::with('schedule')->with('user')->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function show($id)
    {
        try {
            $data['booking'] = Booking::with('schedule')->with('user')->find($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function getByIdUser(Request $request)
    {
        try {
            $user = $request->user();
            $data['bookings'] = Booking::where('user_id', $user->id)->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            $user = $request->user();
            $data = [
                'kode_booking' => uniqid() . date("Y.m.d"),
                'user_id' => $user->id,
                'schedule_id' => $request->schedule_id,
                'booking_date' => $request->booking_date,
                'status' => $request->status,
                'total_cost' => $request->total_cost
            ];
            $data['booking'] = Booking::create($data);
            return response()->json(['message' => 'created success']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data['booking'] = Booking::find($id)->update($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $data['booking'] = Booking::find($id)->delete();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
