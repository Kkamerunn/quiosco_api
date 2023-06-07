<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        //return response()->json(['categories' => Category::all()]);

        return new CategoryCollection(Category::all());
    }
}
