<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use App\Models\User;

class JWTAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json(compact('token'));
    }

    // public function generateToken(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     try {
    //         if (! $token = JWTAuth::attempt($credentials)) {
    //             return response()->json(['error' => 'Invalid credentials'], 401);
    //         }
    //     } catch (JWTException $e) {
    //         return response()->json(['error' => 'Could not create token'], 500);
    //     }

    //     // Set the token's expiration time (e.g., 1 hour from now)
    //     // $expiration = Carbon::now()->addMinute()->timestamp;
    //     $expiration = Carbon::now()->addHour()->timestamp;

    //     // Retrieve the user from the database
    //     $user = User::where('email', $credentials['email'])->first();

    //     // Add the expiration time to the token payload
    //     $customClaims = ['exp' => $expiration];
    //     $token = JWTAuth::claims($customClaims)->fromUser($user);

    //     return response()->json(compact('token'));
    // }

    public function generateToken(Request $request)
    {
        // Retrieve Basic Auth credentials from request headers
        $credentials = base64_decode(substr($request->header('Authorization'), 6));
        list($email, $password) = explode(':', $credentials);

        dd($request);

        // Rest of your code for token generation
        // ...
        try {
            if (! $token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Set the token's expiration time (e.g., 1 hour from now)
            $expiration = Carbon::now()->addHour()->timestamp;

            // Retrieve the user from the database
            $user = User::where('email', $email)->first();

            // Add the expiration time to the token payload
            $customClaims = ['exp' => $expiration];
            $token = JWTAuth::claims($customClaims)->fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

}
