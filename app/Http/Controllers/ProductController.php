<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailProductResource;
use Exception;
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

        return new DetailProductResource($product);
    }

    public function showByCategory($slug)
    {
        $products = Product::latest()->get();

        $data = [];
        foreach ($products as $product) {
            if ($product->category->slug == $slug) {
                $data[] = $product;
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function showByUser($username)
    {
        $products = Product::latest()->get();
        $products = ProductResource::collection($products);

        $data = [];
        foreach ($products as $product) {
            if ($product->user->username == $username) {
                $data[] = $product;
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'condition' => 'required'
        ]);

        $image = $request->image;
        try {
            if ($request->hasFile('file')) { // Memeriksa apakah file ada dalam request
                // upload file
                $fileName = $this->RandomString();
                $extension = $request->file('file')->extension();
                $image = $fileName . '.' . $extension;
                $request->file('file')->storeAs('public/images', $image); // Simpan file ke direktori yang diinginkan
            }

            $requestData = $request->except('file');

            $requestData['image'] = $image;
            $requestData['user_id'] = Auth::user()->id;

            $product = Product::create($requestData);
            return response()->json([
                'data' => $product
            ]);
        } catch (Exception $e) {
            return $this->error(null, $e, 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->error(null, 'Product not found', 404);
            }

            $product->update($request->only([
                'name', 'description', 'price', 'stock', 'category_id',
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
