<?php

namespace App\Http\Controllers;
use App\Models\User;


use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request){
        $request->validate([
            'fullname' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);
    
        $user = new User([
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'password' => $request->password
        ]);
    
        $user->save();
    
        if (! $token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $this->respondWithToken($token);
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
