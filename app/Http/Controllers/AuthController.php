<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $messages = [
            "username.required" => "username is required",
            "username.exists" => "username doesn't exists"
       ];

        //add validator 
        $validator = Validator::make($credentials,[
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ], $messages);

        if($validator->fails()){
            return response()->json([
                'status'=> 'failed',
                'message' => $validator->messages()->first()
            ], 400);
        }

        try {
            if(!$token = auth()->attempt($credentials)) {
                return response()->json([
                    'status'=> 'failed',
                    'message'=> 'password yang anda masukan salah'
                ], 400);
            } 
        } catch (JWTException $e) {
            return $credentials;
            return response()->json([
                'status'=> 'failed',
                'message' => 'could not create token',
                
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => auth()->user(),
            'token' => $token
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}