<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Tag;

class ProductController extends Controller
{
    public function index()
    {
        abort_if(
            !(auth()->user()->tokenCan('read-write') || auth()->user()->tokenCan('read')),
            401,
            'You are not allowed to see this product'
        );

        $products = Product::with('category','tags')->paginate(9);



        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        abort_if(
            !(auth()->user()->tokenCan('read-write') || auth()->user()->tokenCan('read')),
            401,
            'You are not allowed to see this product'
        );

        if ($product->comments()->count() > 0) {
            $product->load(['comments.user']);
        }
        return new ProductResource($product);
    }
    public function store(StoreProductRequest $request)
    {
        abort_if(! auth()->user()->tokenCan('read-write'), 401,'You are not allowed to create a product');
        $request = $request->validated();

        $product = Product::create($request);

        if (!$product->tags()->count() > 0) {
            $product->tags()->attach(Tag::whereIn('name', $request['tags'])->pluck('id'));
        }


        return new ProductResource($product);
    }
    public function update(StoreProductRequest $request, Product $product)
    {
        abort_if(! auth()->user()->tokenCan('read-write'), 401,'You are not allowed to update a product');

        $request = $request->validated();

        $product->update($request);

        return new ProductResource($product);
    }
    public function destroy(Product $product)
    {
        abort_if(! auth()->user()->tokenCan('read-write'), 401,'You are not allowed to Delete a product');
        $product->delete();
    }
}
