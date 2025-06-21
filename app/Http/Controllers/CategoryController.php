<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Traits\ResponseMessages;
use App\Traits\UploadFiles;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CategoryController extends Controller
{
    use ResponseMessages, UploadFiles;
    public function index()
    {
        $categories = Category::all();
        return $this->successMessage('success', 'categories', $categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $imagePath = $this->uploadFile($request->file('image'), 'cateogry-images');

        $category = Category::create([
            "name" => $request->name,
            "image" => $imagePath,
        ]);

        return $this->successMessage('success', 'category', $category);
    }

    public function show($id)
    {
        try {
            $category = Category::with('books')->findOrFail($id);
            return $this->successMessage('success', 'category', $category);
        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Category Not Found');
        }
    }

    public function search($name)
    {
        $categories = Category::with('books')->where('name', 'like' , '%' . $name . '%')->get();

        if($categories->isEmpty()) {
            return $this->errorMessage('error', 'message', 'Category Not Found');
        }

        return $this->successMessage('success', 'category', $categories);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {

        try {
            $category = Category::findOrFail($id);

            $category->name = $request->name;
    
            if ($request->hasFile('image')) {
                if($category->image) {
                    $this->deleteFile($category->image);
                }
                $category->image = $this->uploadFile($request->file('image'), 'cateogry-images');
            }
    
            $category->save();
            return $this->successMessage('success', 'category', $category);
    
        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Category Not Found');
        }
    }

    public function destroy($id)
    {

        try {
            $category = Category::findOrFail($id);

            if ($category->image) {
                $this->deleteFile($category->image);
            }

            $category->books()->detach();
            $category->delete();
    
            return $this->successMessage('success', 'message', 'Category Deleted Successfully');    
        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Category Not Found');
        }
    }
}
