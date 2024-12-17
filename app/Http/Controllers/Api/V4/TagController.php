<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return TagResource::collection($tags);
    }
    public function store(StoreTagRequest $request)
    {
        $request = $request->validated();
        $tag = Tag::create($request);
        return new TagResource($tag);
    }
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }
    public function update(StoreTagRequest $request, Tag $tag)
    {
        $request = $request->validated();
        $tag->update($request);
        return new TagResource($tag);
    }
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json([
            'message' => 'Tag deleted successfully',
        ]);
    }
}
