<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
     * @SWG\Post(
     *     path="/auth/login",
     *     tags={"auth"},
     *     operationId="login",
     *     summary="Login",
     *     description="Returs token in authorization header",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Credntials",
     *         required=true,
     *         @SWG\Schema(
     *              @SWG\Property(property="email", type="string"),
     *              @SWG\Property(property="password", type="string"),
     *         ),
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success",
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @SWG\Get(
     *     path="/auth/account",
     *     summary="Get user info",
     *     description="",
     *     operationId="getAccount",
     *     produces={"application/json"},
     *     tags={"auth"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="id", type="integer", format="int32"),
     *             @SWG\Property(property="name", type="string"),
     *             @SWG\Property(property="role", type="string"),
     *             @SWG\Property(property="email", type="string"),
     *             @SWG\Property(property="site_id", type="integer", format="int32"),
     *             @SWG\Property(property="created_at", type="string", format="date-time"),
     *             @SWG\Property(property="updated_at", type="string", format="date-time"),
     *         ),
     *     ),
     *     security={
     *       {"Bearer": {}}
     *     }
     * )
     */
    public function account()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->guard()->user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
     * @SWG\Post(
     *     path="/auth/logout",
     *     tags={"auth"},
     *     operationId="logout",
     *     summary="Logout",
     *     description="",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successfully logged out",
     *     ),
     *     security={
     *       {"Bearer": {}}
     *     }
     * )
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
     * @SWG\Post(
     *     path="/auth/refresh",
     *     tags={"auth"},
     *     operationId="refresh",
     *     summary="Refresh token",
     *     description="",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success",
     *     ),
     *     security={
     *       {"Bearer": {}}
     *     }
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
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
        return response([
            'status' => 'success'
        ])
        ->header('Authorization', $token);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}