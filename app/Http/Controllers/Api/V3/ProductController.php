<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
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
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->subcategory()->detach();

        $product->delete();

        return response()->json(['message' => 'Se ha borrado el producto'], 204);
    }
}
