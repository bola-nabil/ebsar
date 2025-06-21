<?php

namespace App\Http\Controllers;

use App\Traits\ResponseMessages;
use App\Http\Requests\Publisher\StorePublisherRequest;
use App\Http\Requests\Publisher\UpdatePublisherRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Publisher;

class PublisherController extends Controller
{
    use ResponseMessages;
    public function index()
    {
        $publishers = Publisher::all();
        return $this->successMessage('success', 'publishers', $publishers);
    }

    public function store(StorePublisherRequest $request)
    {
        $publisher = Publisher::create($request->validated());
        return $this->successMessage('success', 'publisher', $publisher);
    }

    public function show($id)
    {
        try {
            $publisher = Publisher::with('books')->findOrFail($id);
            return $this->successMessage('success', 'publisher', $publisher);
    
        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message' , 'Publisher Not Found');
        }

    }

    public function search($name) {
        $publishers = Publisher::with('books')->where('name' , 'like', '%' . $name . '%')->get();

        if($publishers->isEmpty()) {
            return $this->errorMessage('error', 'message' , 'Publiser Not Found');
        }
        return $this->successMessage('success', 'publishers', $publishers);
    }

    public function update(UpdatePublisherRequest $request, $id)
    {

        try {
            $publisher = Publisher::findOrFail($id);
            $publisher->update($request->validated());
            
            return $this->successMessage('success', 'publisher', $publisher);    

        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message' , 'Publisher Not Found');
        }
    }

    public function destroy($id)
    {

        try {
            $publisher = Publisher::findOrFail($id);

            $publisher->delete();
    
            return $this->successMessage('success', 'message', 'Publisher Deleted Successfully');    

        } catch(ModelNotFoundException $e) {
            return $this->errorMessage('error', 'message' , 'Publisher Not Found');
        }
    }
}
