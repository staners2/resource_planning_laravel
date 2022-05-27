<?php

namespace App\Http\Controllers;


use App\Http\Resources\ProductResource;
use App\Jobs\NotifyCreatedProductJob;
use App\Models\Product;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse {
        $response=Gate::inspect('viewAny', Product::class);
        if ($response->allowed()) {
            return response()->json(ProductResource::collection(Cache::get('products')))
                ->setStatusCode(ResponseAlias::HTTP_OK);
        }

        $message = $response->message();
        return response()->json([
            $message['message']
        ])->setStatusCode($response->code());
    }

    public function create(Request $request): JsonResponse {

        $name = $request->input('name');
        $article = $request->input('article');
        $data = $request->input('data');

        $product = new Product(['name' => $name, 'article' => $article, 'data' => $data]);
        $product->save();

//        $email = auth()->user()->email;
//        NotifyCreatedProductJob::dispatch($product->article, $email);

        Cache::forget('products');

        return response()->json($product)->setStatusCode(ResponseAlias::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse {

        $product = Product::find($id);
        if ($product == null){
            return response()->json([
                'message'=> "Продукт не найден!",
            ])->setStatusCode(ResponseAlias::HTTP_NOT_FOUND);
        }

        $name = $request->input('name');
        $article = $request->input('article');
        $data = $request->input('data');

        $rules = [
            'name' => 'min:5',
            'article' => 'min:5|regex:/^[a-zA-z0-9]+$/',
        ];
        $validationData = $request->only(["name", "article", "data"]);
        $messages = [
            'min' => ':attribute должен быть больше :min символов',
            'article.regex' => ':attribute должен содержать только цифры и латинские символы',
        ];
        $validator = Validator::make($validationData, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $product->name = $name == null ? $product->name : $name;
        $product->article = $article == null ? $product->article : $article;
        $product->data = $data == null ? $product->data : $data;

        if ($article != null) {
            $response = Gate::inspect('update', Product::class);
            $message = $response->message();
            if ($response->denied()){
                return response()->json([
                    'message' => $message['message']
                ])->setStatusCode($response->code());
            }
        }

        Cache::forget('products');

        $product->save();

        return response()->json($product)->setStatusCode(ResponseAlias::HTTP_OK);
    }

    public function delete(Request $request, $id): JsonResponse {

        $product = Product::find($id);
        if ($product == null){
            return response()->json([
                'message'=> "Продукт не найден!",
            ])->setStatusCode(ResponseAlias::HTTP_NOT_FOUND);
//            Product::withTrashed()->where('id', $id)->restore();
        }

        $product->delete($id);

        Cache::forget('products');

        return response()->json([
            'message' => 'Продукт удален'
        ])->setStatusCode(ResponseAlias::HTTP_OK);
    }
}
