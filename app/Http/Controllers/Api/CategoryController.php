<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $categories = Category::userId()->get();

        return $this->responseSuccess('Category Index', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseValidator($validator);
        }

        $user= Auth::user();
        $category = new Category();
        $category->name = $request->name;
        $category->user_id = $user->id;
        $category->save();

        return $this->responseSuccess('Category Successfully Created.', [
            'category' => $category,
        ]);
    }

    public function edit(Request $reuqest, $id)
    {
        $category = Category::userId()->where('id', $id)->firstOrFail();

        return $this->responseSuccess('Category Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseValidator($validator);
        }

        $category = Category::userId()->where('id', $id)->firstOrFail();
        $category->name = $request->name;
        $category->save();

        return $this->responseSuccess('Category Successfully Updated.', [
            'category' => $category
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::userId()->where('id', $id)->firstOrFail();
        $category->delete();

        return $this->responseSuccess('Category Successfully Deleted.');
    }
}
