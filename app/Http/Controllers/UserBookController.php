<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseMessages;
use App\Models\User;

class UserBookController extends Controller
{
    use ResponseMessages;
    public function index()
    {
        $users = User::all();

        return $this->successMessage('success', 'users' , $users);
    }

    public function show($id)
    {
        $user = User::find($id);

        if(!$user) {
            return $this->errorMessage('error', 'message', 'User Not Found');
        }

        return $this->successMessage('success', 'user', $user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->successMessage('success', 'message' , 'User Deleted Successfully');
    }

    public function getFavorites()
    {
        $user = auth()->user();

        return $this->successMessage('success', 'favorites', $user->favoriteBooks);
    }

    public function getWishlist()
    {
        $user = auth()->user();
        return $this->successMessage('success', 'wishlist', $user->wishlistBooks);
    }

    public function addFavorite(Request $request)
    {
        $user = auth()->user();
        $user->favoriteBooks()->attach($request->book_id);

        return $this->successMessage('success', 'message', 'Book added to favorites');
    }

    public function removeFavorite(Request $request)
    {
        $user = auth()->user();
        $user->favoriteBooks()->detach($request->book_id);

        return $this->successMessage('success', 'message', 'Book reomoved from favorites');
    }

    public function addWishlist(Request $request)
    {
        $user = auth()->user();
        $user->wishlistBooks()->attach($request->book_id);

        return $this->successMessage('success', 'message', 'Book added to wishlist');
    }

    public function removeWishlist(Request $request)
    {
        $user = auth()->user();
        $user->wishlistBooks()->detach($request->book_id);

        return $this->successMessage('success', 'message', 'Book removed from wishlist'); 
    }
}
