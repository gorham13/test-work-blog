<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:40|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        } else {
            $user = User::create($request->all());
            return Response()->json($user, 200);
        }
    }

    public function changeRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,editor,user'
        ]);
        if ($validator->fails()) {
            return Response()->json($validator->errors(), 400);
        } else {
            $user = User::find($id);
            $user['role'] = $request->role;
            $user->save();
            return Response()->json('User role updated to '.$user['role'], 200);
        }
    }
}
