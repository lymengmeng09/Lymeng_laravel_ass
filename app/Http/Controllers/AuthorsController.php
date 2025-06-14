<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    // Fake in-memory data for authors. This data is reset with every request.
    public $authors = [
        [
            'id' => '1',
            'name' => 'Lymeng Phorng',
            'bio' => 'Believe you can and you are halfway there.',
            'nationality' => 'Cambodia',
        ],
        [
            'id' => '2',
            'name' => 'MENG_Oliveavera',
            'bio' => 'A Negative Mind Will Never Give You A Positive life.❤️',
            'nationality' => 'USA',
        ],
    ];

    /**
     * Display a listing of all authors.
     * Route: GET /authors
     */
    public function index()
    {
        // Return all authors as a JSON response
        return response()->json($this->authors);
    }

    /**
     * Create a new author.
     * Route: POST /authors/create
     * Note: This method is used for demonstration; typically creation logic is placed in `store()`
     */
    public function create(Request $request)
    {
        // Validate the request data; name is required and must be a string
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        // Prepare new author data
        $newAuthor = [
            'id' => count($this->authors) + 1,
            'name' => $validated['name'],
        ];

        // Add the new author to the authors list
        $this->authors[] = $newAuthor;

        // Return the created author with a 201 status code
        return response()->json($newAuthor, 201);
    }

    /**
     * Store a newly created resource in storage.
     * Route: POST /authors
     * Currently commented out and unused.
     */
    public function store(Request $request)
    {
        // The actual logic is commented out.
        // Usually, creation logic should go here in a RESTful API.
    }

    /**
     * Display a single author by ID.
     * Route: GET /authors/{id}
     */
    public function show(string $id)
    {
        // Find the author in the collection by matching the id
        $author = collect($this->authors)->firstWhere('id', $id);

        // If found, return the author as JSON
        if ($author) {
            return response()->json($author);
        }

        // If not found, return a 404 response
        return response()->json(['message' => 'Author not found'], 404);
    }
    
    /**
     * Update the specified author by ID.
     * Route: PUT/PATCH /authors/{id}
     */
    public function update(Request $request, string $id)
    {
        // Validate input; 'name' is optional but must be a string if provided
        $request->validate([
            'name' => 'sometimes|required|string',
        ]);

        // Loop through the authors to find the one to update
        foreach ($this->authors as $index => $author) {
            if ($author['id'] == $id) {
                // Merge existing author data with the new data from the request
                $this->authors[$index] = array_merge($author, $request->only('name'));

                // Return the updated author data
                return response()->json($this->authors[$index]);
            }
        }

        // If not found, return a 404 response
        return response()->json(['message' => 'Author not found'], 404);
    }

    /**
     * Delete an author by ID.
     * Route: DELETE /authors/{id}
     */
    public function destroy(string $id)
    {
        // Loop through authors to find the one to delete
        foreach ($this->authors as $index => $author) {
            if ($author['id'] == $id) {
                // Remove the author from the list
                array_splice($this->authors, $index, 1);

                // Return success message
                return response()->json(['message' => 'Deleted']);
            }
        }

        // If author not found, return 404
        return response()->json(['message' => 'Author not found'], 404);
    }
}
