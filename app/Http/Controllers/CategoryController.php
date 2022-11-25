<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public static function getCategories()
    {
        return [
            'main' => Category::with('categories')
                ->whereNull('category_id')
                ->whereNull('user_id')->get(),
            'user' => Category::userId()->get(),
        ];
    }

    public function index(Request $request)
    {
        $categories = Category::userId()->get();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $user= Auth::user();
        $category = new Category();
        $category->name = $request->name;
        $category->user_id = $user->id;
        $category->save();

        return response()->json(['status' => 'success', 'msg' => 'Category Successfully Created.']);
    }

    public function edit(Request $request, $id)
    {
        $category = Category::userId()->where('id', $id)->firstOrFail();
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $category = Category::userId()->where('id', $id)->firstOrFail();
        $category->name = $request->name;
        $category->save();

        return response()->json(['status' => 'success', 'msg' => 'Category Successfully Updated.', 'href' => route('categories.edit', $category->id)]);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::userId()->where('id', $id)->firstOrFail();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Successfully Deleted.');
    }
}
