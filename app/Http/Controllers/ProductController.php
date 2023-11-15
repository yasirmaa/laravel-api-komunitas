<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductController extends Controller
{
    use HttpResponses, SoftDeletes;

    public function index()
    {
        $products = Product::latest()->get();

        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
        ]);

        $image = null;
        if ($request->file) {
            // upload file
            $fileName = $this->RandomString();
            $extension = $request->file->extension();
            $image = $fileName . '.' . $extension;
            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;
        $request['user_id'] = Auth::user()->id;

        $product = Product::create($request->all());
        return response()->json([
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->error(null, 'Product not found', 404);
            }

            $product->update($request->only([
                'name', 'description', 'price', 'stock', 'category_id', 'image'
            ]));

            return $this->success($product, "Product updated successfully", 200);
        } catch (Exception $e) {
            return $this->error(null, $e, 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->error(null, 'Product not found', 404);
            }

            $product->delete();

            return $this->success($product, 'Product deleted successfully');
        } catch (Exception $e) {
            return $this->error(null, $e, 500);
        }
    }

    public function create()
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
