<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ResponseMessages;
use App\Http\Requests\ChangePasswordRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
{
    use ResponseMessages;
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (!$token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'admin' => auth('admin')->user()
        ]);
    }
    
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->successMessage('success', 'message', 'Logged out successfully.');
        } catch (\Exception $e) {
            return $this->errorMessage('error', 'message', 'Logout failed.');
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $admin = auth('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return $this->errorMessage('error', 'message', 'Current password is incorrect');
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return $this->successMessage('success', 'message', 'Password changed successfully');
    }
}
