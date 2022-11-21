<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Scopes\UserIdScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
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
        $category = Category::userId()->where('id', $id)->first();
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

        $category = Category::userId()->where('id', $id)->first();
        $category->name = $request->name;
        $category->save();

        return response()->json(['status' => 'success', 'msg' => 'Category Successfully Updated.']);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::userId()->where('id', $id)->first();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Successfully Deleted.');
    }
}
