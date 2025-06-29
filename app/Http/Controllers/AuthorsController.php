<?php

// app/Http/Controllers/AuthorsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authors;

class AuthorsController extends Controller
{
    /**
     * List all authors.
     * Route: GET /authors
     */
   public function index()
{
    return response()->json(Authors::with('books')->get());
}

    /**
     * Create a new author.
     * Route: POST /authors/create
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'bio' => 'nullable|string',
            'nationality' => 'nullable|string',
        ]);

        $author = Authors::create($validated);

        return response()->json($author, 201);
    }

    /**
     * Show a single author.
     * Route: GET /authors/{id}
     */
   public function show($id)
{
    $author = Authors::with('books')->find($id);

    if (!$author) {
        return response()->json(['message' => 'Author not found'], 404);
    }

    return response()->json($author);
}

    /**
     * Update an author.
     * Route: PUT /authors/{id}
     */
    public function update(Request $request, $id)
    {
        $author = Authors::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'bio' => 'nullable|string',
            'nationality' => 'nullable|string',
        ]);

        $author->update($validated);

        return response()->json($author);
    }

    /**
     * Delete an author.
     * Route: DELETE /authors/{id}
     */
    public function destroy($id)
    {
        $author = Authors::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author->delete();

        return response()->json(['message' => 'Deleted']);
    }
public function search(Request $request){
    $search = $request->query('search');

    $author = Authors::with('books')
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->get();

    return response()->json([
        'message' => 'Authors retrieved successfully',
        'data' => $author,
    ]);
}




}