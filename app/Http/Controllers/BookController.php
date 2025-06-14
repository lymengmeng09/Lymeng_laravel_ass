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
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'title' => 'required|string',
            'authorId' => 'required',
            'isbn' => 'required|string',
        ]);

        // Simulate saving by pushing to the array
        $newBook = [
            'id' => count($this->books) + 1,
            'title' => $validated['title'],
            'authorId' => $validated['authorId'],
            'isbn' => $validated['isbn'],
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}