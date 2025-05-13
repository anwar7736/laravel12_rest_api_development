<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->only(['name', 'phone', 'email', 'password', 'address']);
            $user = User::create($data);
            $user->created_by = $user->id;
            $user->save();
            if ($request->hasFile('image')) {
                $newName = uploadFile($request->image);
                $user->image()->create(['image' => $newName, 'created_by' => $user->id]);
            }

            $data = $user->select('id', 'name', 'phone', 'email', 'address')->first();
            $data->access_token = $user->createToken('user_auth_token')->plainTextToken;
            Auth::login($user);
            DB::commit();
            return apiResponse(true, "Registration successfully", $data);
        } catch (\Throwable $th) {
            DB::rollBack();
            return apiResponse(false, $th->getMessage());
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $user = User::where('phone',  $request->email)
                ->orWhere('email', $request->email)
                ->first();
            if ($user && Hash::check($request->password, $user->password)) {
                $data = $user->select('id', 'name', 'phone', 'email', 'address')->first();
                $data->access_token = $user->createToken('user_auth_token')->plainTextToken;
                Auth::login($user);
                return apiResponse(true, "Login successfully", $data);
            }
             return apiResponse(false, "Inavalid credentials");
        } catch (\Throwable $th) {
 return apiResponse(false, $th->getMessage());
        }
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        return apiResponse(true, "Logout successfully");
    }
}
