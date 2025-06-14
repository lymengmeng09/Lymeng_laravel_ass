<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{   
    // In-memory book list (simulates a database)
    public $books = [ 
        [
            'id' => '1',
            'title' => 'Book One',
            'authorId' => 'a1',
            'isbn' => '111',
            'publicationYear' => 2000,
            'genre' => 'Fiction',
            'availableCopies' => 3
        ],
        [
            'id' => '2',
            'title' => 'Book Two',
            'authorId' => 'a2',
            'isbn' => '222',
            'publicationYear' => 2005,
            'genre' => 'Sci-fi',
            'availableCopies' => 5
        ],
    ];

    /**
     * List all books.
     * Route: GET /books
     */
    public function index()
    {
        return response()->json($this->books);
    }

    /**
     * Create a new book.
     * Route: POST /books/create
     */
    public function create(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'title' => 'required|string',
            'authorId' => 'required',
            'isbn' => 'required|string',
            'publicationYear' => 'required|integer',
            'genre'=> 'required|string',
            'availableCopies' => 'required|integer',
        ]);

        // Create a new book array
        $newBook = [
            'id' => count($this->books) + 1,
            'title' => $validated['title'],
            'authorId' => $validated['authorId'],
            'isbn' => $validated['isbn'],
            'publicationYear' => $validated['publicationYear'],
            'genre' => $validated['genre'],
            'availableCopies' => $validated['availableCopies'],
        ];

        // Add the new book to the books array (simulating DB insert)
        $this->books[] = $newBook;

        // Return the newly created book with 201 status
        return response()->json($newBook, 201);
    }

    /**
     * Show a single book by ID.
     * Route: GET /books/{id}
     */
    public function show(string $id)
    {
        // Find the book by ID
        $book = collect($this->books)->firstWhere('id', $id);

        // Return the book if found, otherwise 404
        return $book
            ? response()->json($book)
            : response()->json(['message' => 'Book not found'], 404);
    }

    /**
     * Update book details by ID.
     * Route: PUT/PATCH /books/{id}
     */
    public function update(Request $request, string $id)
    {
        // Loop through books and find the matching one
        foreach ($this->books as &$book) {
            if ($book['id'] == $id) {
                // Merge new values into the book
                $book = array_merge($book, $request->all());
                return response()->json($book);
            }
        }

        // Book not found
        return response()->json(['error' => 'Book not found'], 404);
    }

    /**
     * Delete a book by ID.
     * Route: DELETE /books/{id}
     */
    public function destroy(string $id)
    {
        // Loop through books and find the one to delete
        foreach ($this->books as $index => $book) {
            if ($book['id'] == $id) {
                // Remove the book from the array
                array_splice($this->books, $index, 1);
                return response()->json(['message' => 'Deleted']);
            }
        }

        // Book not found
        return response()->json(['error' => 'Book not found'], 404);
    }
}
