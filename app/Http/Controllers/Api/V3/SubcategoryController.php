<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
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
}
