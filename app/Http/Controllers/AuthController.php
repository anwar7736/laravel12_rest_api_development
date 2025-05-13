<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create($data);
            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $newName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('images', $newName, 'public');
                $user->image()->create(['image' => $newName]);
                
            }
            

            $user->access_token = $user->createToken('user_auth_token')->plainTextToken;
            return response([
                'success' => true,
                'message' => "Registration successfully",
                'data' => $user->with('image')
                    ->select('id', 'name', 'phone', 'email', 'address')
                    ->first(),
            ]);
        } catch (\Throwable $th) {
            return response([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $user = User::where('phone',  $request->email)
                ->orWhere('email', $request->email)
                ->first();
            if ($user && Hash::check($request->password, $user->password)) {
                $user->access_token = $user->createToken('user_auth_token')->plainTextToken;
                return response([
                    'success' => true,
                    'message' => "Login successfully",
                    'data' => $user,
                ]);
            }
            return response([
                'success' => false,
                'message' => "Inavalid credentials"
            ]);
        } catch (\Throwable $th) {
            return response([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return response([
            'success' => true,
            'message' => "Logout successfully"
        ]);
    }
}
