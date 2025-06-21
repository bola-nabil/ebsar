<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Traits\ResponseMessages;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorController extends Controller
{
    use ResponseMessages;
    public function index()
    {
        $authors = Author::all();
        return $this->successMessage('success', 'authors', $authors);
    }

    public function store(StoreAuthorRequest $request) {
        $author = Author::create($request->validated());

        return $this->successMessage('success', 'author', $author);
    }

    public function show($id)
    {

        try {
            $author = Author::with('books')->findOrFail($id);

            return $this->successMessage('success', 'author', $author);

        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Author Not Found');
        }
    }

    public function search($name)
    {
    
        $authors = Author::with('books')->where('name', 'like', '%' . $name . '%')->get();

        if($authors->isEmpty())
            return $this->errorMessage('error', 'message', "Author Not Found");

        return $this->successMessage('success', 'authors', $authors);
    }

    public function update(UpdateAuthorRequest $request, $id)
    {

        try {

            $author = Author::findOrFail($id);
            $author->update($request->validated());
            return $this->successMessage('success', 'author', $author);    

        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Author Not Found');
        }
    }

    public function destroy($id)
    {

        try {
            $author = Author::findOrFail($id);
            $author->books()->detach();
            $author->delete();
    
            return $this->successMessage('success', 'message', 'Author Deleted Successfully');    

        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Author Not Found');
        }
    }
}
