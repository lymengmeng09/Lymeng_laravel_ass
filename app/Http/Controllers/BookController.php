<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * List all books.
     * Route: GET /books
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Create a new book.
     * Route: POST /books/create
     */
   public function create(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string',
        'authorId' => 'required|string',
        "publicationYear" => 'required|integer',
        'isbn'=>'required|integer',
        "genre" => 'required|string',
        "availableCopies" => 'required|integer'
    ]);

    $book = Book::create($validated);

    return response()->json($book, 201);
}

    /**
     * Show a single book by ID.
     * Route: GET /books/show/{id}
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    /**
     * Update book details by ID.
     * Route: PUT /books/edit/{id}
     */
    public function edit(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'authorId' => 'sometimes|required|string',
            'year' => 'sometimes|required|integer',
        ]);

        $book->update($validated);

        return response()->json($book);
    }

    /**
     * Delete a book by ID.
     * Route: DELETE /books/delete/{id}
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }

    /**
     * Count total books.
     * Route: GET /books/count
     */
    public function CountBooks()
    {
        $count = Book::count();
        return response()->json(['count' => $count]);
    }
}
