<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cover_image' => ['required', 'image', 'mimes:png,jpg,jpeg,gif,svg', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_published' => ['required', 'boolean']
        ]);

        $validatedData['cover_image'] = $request->file('cover_image')->store('images', 'public');
        Book::create($validatedData);

        return response()->json(['success' => 'Book created successfully']);
    }

    public function show(Book $book)
    {
        return response()->json(['data' => $book]);
    }
}
