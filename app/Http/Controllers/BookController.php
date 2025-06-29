<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;


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
public function store(BookStoreRequest $request)
{
    $book = Book::create($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Book created successfully',
        'data' => $book
    ], 201);
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
 public function update(BookUpdateRequest $request, $id)
{
    $book = Book::find($id);

    if (!$book) {
        return response()->json(['message' => 'Book not found'], 404);
    }

    $book->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Book updated successfully',
        'data' => $book
    ]);
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
    public function searchByTitle(Request $request)
{
    $request->validate([
        'title' => 'required|string',
    ]);

    $title = $request->input('title');

    // Search books where title contains the search string, eager load author
    $books = Book::with('author')
        ->where('title', 'like', "%{$title}%")
        ->get();

    if ($books->isEmpty()) {
        return response()->json(['message' => 'No books found with that title'], 404);
    }

    return response()->json($books);
}
}

