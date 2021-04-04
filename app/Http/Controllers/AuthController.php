<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $this->parameter = $this->request->all();
        $adminId = Admin::where(['account' => $this->parameter['account']])
            ->where(['password' => $this->parameter['password']])
            ->select('id')
            ->get()
            ->pluck('id')
            ->first();

        if (!$token = auth('api')->tokenById($adminId)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // dd($toke n);

        return $this->respondWithToken($token);
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
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
