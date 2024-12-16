<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(9);

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        abort_if(
            ! (auth()->user()->tokenCan('read-write') || auth()->user()->tokenCan('read')),
            401,
            'You are not allowed to see this product'
        );
        return new ProductResource($product);
    }
    public function store(StoreProductRequest $request)
    {
        abort_if(! auth()->user()->tokenCan('read-write'), 401,'You are not allowed to create a product');
        $request = $request->validated();

        $product = Product::create($request);

        return new ProductResource($product);
    }
    public function update(StoreProductRequest $request, Product $product)
    {
        $request = $request->validated();

        $product->update($request);

        return new ProductResource($product);
    }
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
