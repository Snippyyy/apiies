<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubcategoryRequest;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    public function index()
    {
        return SubcategoryResource::collection(Subcategory::all());
    }

    public function list()
    {
        return SubcategoryResource::collection(Subcategory::paginate(10));
    }

    public function store(SubcategoryRequest $request)
    {
        $subcategory = Subcategory::create($request->validated());
        return new SubcategoryResource($subcategory);
    }
    public function show(Subcategory $subcategory)
    {
        return new SubcategoryResource($subcategory);
    }
    public function update(SubcategoryRequest $request, Subcategory $subcategory)
    {
        $subcategory->update($request->validated());
        return new SubcategoryResource($subcategory);
    }
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->products()->detach();
        $subcategory->delete();
        return response()->json(['message' => 'Se ha eliminado la subcategoria Correctamente'], 204);
    }
}
