<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{   
    public $books = [ 
        ['id' => '1', 'title' => 'Book One', 'authorId' => 'a1', 'isbn' => '111', 'publicationYear' => 2000, 'genre' => 'Fiction', 'availableCopies' => 3],
        ['id' => '2', 'title' => 'Book Two', 'authorId' => 'a2', 'isbn' => '222', 'publicationYear' => 2005, 'genre' => 'Sci-fi', 'availableCopies' => 5],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->books);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
         // Validate required fields
        $validated = $request->validate([
            'title' => 'required|string',
            'authorId' => 'required',
            'isbn' => 'required|string',
            'publicationYear' => 'required|integer',
            'genre'=> 'required|string',
            'availableCopies' => 'required|integer',
        ]);

        // Simulate saving by pushing to the array
        $newBook = [
            'id' => count($this->books) + 1,
            'title' => $validated['title'],
            'authorId' => $validated['authorId'],
            'isbn' => $validated['isbn'],
            'publicationYear' => $validated['publicationYear'],
            'genre' => $validated['genre'],
            'availableCopies' => $validated['availableCopies'],
        ];

        // In a real app, you'd save this to a database.
        $this->books[] = $newBook;

        return response()->json($newBook, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $book = collect($this->books)->firstWhere('id', $id);
        return $book
            ? response()->json($book)
            : response()->json(['message' => 'Book not found'], 404);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    foreach ($this->books as &$book) {
        if ($book['id'] == $id) {
            $book = array_merge($book, $request->all());
            return response()->json($book);
        }
    }

    return response()->json(['error' => 'Book not found'], 404);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        foreach ($this->books as $index => $book) {
        if ($book['id'] == $id) {
            array_splice($this->books, $index, 1);
            return response()->json(['message' => 'Deleted']);
        }
    }
    return response()->json(['error' => 'Book not found'], 404);
    }
}