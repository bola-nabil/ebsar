<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use App\Traits\ResponseMessages;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    use ResponseMessages;
    public function index()
    {
        $counts = Cache::remember('dashboard_counts', 60, function () {
            return [
                'books' => Book::count(),
                'users' => User::count(),
                'publishers' => Publisher::count(),
                'authors' => Author::count(),
                'categories' => Category::count(),
            ];
        });
    
        return $this->successMessage('success', 'counts', $counts);
    }
}
