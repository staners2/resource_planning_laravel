<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $rules = [
            'name' => 'required|min:10',
            'article' => 'required|min:10|regex:/^[a-z0-9]+$/i|unique:product',
        ];
        $data = $request->only(["name", "article"]);
        $messages = [
            'required' => ':attribute должен быть обязательным',
            'min' => ':attribute должен быть больше 10 символов',
            'regex' => ':attribute должен содержать латнские символы и буквы',
            'unique' => ':attribute должен быть уникальным'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        return $next($request);
    }
}
