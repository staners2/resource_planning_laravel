<?php

namespace App\Http\Controllers;


use App\Models\Product;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function create(Request $request): JsonResponse {

        $name = $request->input('name');
        $article = $request->input('article');
        $data = $request->input('data');

        $product = new Product(['name' => $name, 'article' => $article, 'data' => $data]);
        $product->save();

        return response()->json();
    }

    public function update(Request $request): JsonResponse {

        return response()->json();
    }
}
