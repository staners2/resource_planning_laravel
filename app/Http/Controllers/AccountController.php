<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AccountController extends Controller
{
    public function registration(Request $request){
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|min:5|regex:/^[a-zA-z0-9 \-.]+@[a-zA\-.]+$/|unique:users',
            'password' => 'required|min:5',
        ];
        $data = $request->only(["name", "email", "password"]);
        $messages = [
            'required' => ':attribute должен быть обязательным',
            'min' => ':attribute должен быть больше :min символов',
            'email.regex' => ':attribute должен содержать @',
            'email.unique' => 'Данный :attribute уже зарегистрирован'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
           'message' => 'Аккаунт успешно создан!'
        ])->setStatusCode(ResponseAlias::HTTP_OK);
    }
}
