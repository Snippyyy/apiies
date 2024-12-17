<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ProductResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;


class CommentController extends Controller
{
    public function index(Product $product)
    {
        abort_if(
            !(auth()->user()->tokenCan('read-write') || auth()->user()->tokenCan('read')),
            401,
            'You are not allowed to see comments'
        );

        $productComments = $product->comments()
            ->orderBy('created_at', 'desc')
            ->get();


        return CommentResource::collection($productComments);
    }
    public function show(Product $product, Comment $comment)
    {
        abort_if(
            !(auth()->user()->tokenCan('read-write') || auth()->user()->tokenCan('read')),
            401,
            'You are not allowed to see this comment'
        );
        return new CommentResource($comment);
    }
    public function store(CommentRequest $request, Product $product)
    {
        abort_if(! auth()->user()->tokenCan('read-write'),
            401,
            'You are not allowed to create a comment');

        $request = $request->validated();
        $product->comments()->create([
            'comment' => $request['comment'],
            'user_id' => auth()->id(),
        ]);
        $product->load(['comments.user']);
        return new ProductResource($product);
    }
    public function destroy(Comment $comment)
    {
        abort_if(! auth()->user()->tokenCan('read-write') && $comment->user_id !== auth()->id(),
            401,
            'You are not allowed to Delete this comment');
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
    public function update(CommentRequest $request,Product $product, Comment $comment, )
    {
        abort_if(! auth()->user()->tokenCan('read-write') && $comment->user_id !== auth()->id(),
            401,
            'You are not allowed to update this comment');

        $comment->update($request->validated());

        return new CommentResource($comment);
    }

}
