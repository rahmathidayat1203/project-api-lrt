<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'phone' => 'required',
                'passport' => 'required',
                'id_city' => 'required',
                'date_of_birth' => 'required',
                'foto' => 'required|mime:png,jpg'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $encodedFoto = $request->input('foto');
            $decodedFoto = base64_decode($encodedFoto);
            if (!$decodedFoto) {
                return response()->json(['error' => 'invali data photo']);
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_buffer($finfo, $decodedFoto);
            finfo_close($finfo);
            $extensions = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];

            $extension = $extensions[$mime_type] ?? 'jpg';
            $filepath = 'foto/' . uniqid() . '.' . $extension;
            Storage::disk('public')->put($filepath, $decodedFoto);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'foto' => Storage::url($filepath)
            ]);
            Passenger::create([
                'name' => $user->name,
                'email' => $user->email,
                'passport' => $request->passport,
                'address' => $request->address,
                'id_city' => $request->id_city,
                'post_code' => $request->post_code,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth
            ]);
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'email' => 'required',
                'password' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['error' => $validator->errors()], 422);
            }
            
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['access_token' => $token], 200);
            }
            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'date_of_birth' => $user->date_of_birth,
                'foto' => $user->foto
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $encodedFoto = $request->input('foto');
            $decodedFoto = base64_decode($encodedFoto);

            if (!$decodedFoto) {
                return response()->json(['error' => 'invali data photo']);
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_buffer($finfo, $decodedFoto);
            finfo_close($finfo);

            $extensions = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];

            $extension = $extensions[$mime_type] ?? 'jpg';
            $filepath = 'foto/' . uniqid() . '.' . $extension;
            Storage::disk('public')->put($filepath, $decodedFoto);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->date_of_birth = $request->date_of_birth;
            $user->foto = Storage::url($filepath);
            $user->update();
            return response()->json(['message' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function changepassword(Request $request){
        try {
            $user = $request->user();
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['message' => 'Old password is incorrect']);
            }
            $user->password = Hash::make($request->new_password);
            $user->update();
            return response()->json(['message' => 'Password changed successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
