<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->only(
            'username',
            'password',
            'fullName',
            'alamat',
            'jenisKelamin',
            'noHp',
            'email',
            'roleId',
        );

        $validator = Validator::make($data, [
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'fullName' => 'required',
            'alamat' => 'required',
            'jenisKelamin' => 'required',
            'noHp' => 'required',
            'email' => 'required|string|email|unique:users,email',
            'roleId' => 'required'
        ],[
            'password.min' => 'password minimal 6',
            'email.unique' => 'email sudah digunakan',
            'username.unique' =>'username sudah digunakan'
           ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first()
            ], 400);
        }

        $users = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'full_name' => $request->fullName,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenisKelamin,
            'no_hp' => $request->noHp,
            'email' => $request->email,
            'role_id' => $request->roleId
        ]);

        //response success
       return response()->json([
        'success' => true,
        'message' => 'user created',
        'data' => $users
    ], Response::HTTP_OK);
    }
}
