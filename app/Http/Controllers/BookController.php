<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseMessages;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Traits\UploadFiles;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
{
    use ResponseMessages, UploadFiles;
    public function index()
    {
        $books = Book::with(['publisher','image', 'file'])->get();

        return $this->successMessage('success', 'books', $books);
    }

    public function show($id)
    {
        try {
            $book = Book::with(['publisher', 'authors', 'categories', 'image', 'file'])->findOrFail($id);
            return $this->successMessage('success', 'book', $book);    
        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Book Not Found');
        }
    }

    public function search($title)
    {
    
        $books = Book::where('title', 'like', '%' . $title . '%')->get();
        if($books->isEmpty())
            return $this->errorMessage('error', 'message', "Book Not Found");

        return $this->successMessage('success', 'books', $books);
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        $book = Book::create([
            'title' => $data['title'],
            'publisher_id' => $data['publisher_id']
        ]);

        $imagePath = $this->uploadFile($request->file('image'), 'images');
        $book->image()->create(['image_path' => $imagePath]);

        $filePath = $this->uploadFile($request->file('file'), 'aduios');
        $book->file()->create(['file_path' => $filePath]);

        $book->authors()->attach($data['author_ids']);
        $book->categories()->attach($data['category_ids']);

        return $this->successMessage('success', 'book', $book);
    }

    public function update(UpdateBookRequest $request, $id)
    {

        try {
            $book = Book::findOrFail($id);

            $data = $request->validated();
    
            $book->update([
                'title' => $data['title'],
                'publisher_id' => $data['publisher_id'],
            ]);
    
            if($request->hasFile('image')) {
                if($book->image) {
                    $this->deleteFile($book->image->image_path);
                }
                $imagePath = $this->uploadFile($request->file('image'), 'images');
                $book->image()->updateOrCreate([], ['image_path' => $imagePath]);
            }
    
            if($request->hasFile('file')) {
                if($book->file) {
                    $this->deleteFile($book->file->file_path);
                }
    
                $filePath = $this->uploadFile($request->file('file'), 'audios');
                $book->file()->updateOrCreate([],['file_path' => $filePath]);
            }
    
            $book->authors()->sync($data['author_ids']);
            $book->categories()->sync($data['category_ids']);
    
            return $this->successMessage('success', 'book', $book);
    
        
        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Book Not Found');
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);

            if($book->image) {
                $this->deleteFile($book->image->image_path);
                $book->image()->delete();
            }
    
            if($book->file) {
                $this->deleteFile($book->file->file_path);
                $book->file()->delete();
            }
    
            $book->authors()->detach();
            $book->categories()->detach();
    
            $book->delete();
    
            return $this->successMessage('success', 'message', 'Book Deleted Successfully');
    
        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message', 'Book Not Found');
        }
    }
}
