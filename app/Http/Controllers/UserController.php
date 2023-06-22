<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return $users;
    }

    

    public function show($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        return $user;
    }

    public function delete($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->fullname = $request->fullname;
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }
}
