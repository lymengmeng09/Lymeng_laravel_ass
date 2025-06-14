<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorsController extends Controller
{
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
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->authors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $newAuthor = [
            'id' => count($this->authors) + 1,
            'name' => $validated['name'],
        ];

        $this->authors[] = $newAuthor;

        return response()->json($newAuthor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = collect($this->authors)->firstWhere('id', $id);
        if ($author) {
            return response()->json($author);
        }
        return response()->json(['message' => 'Author not found'], 404);
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
        $request->validate([
            'name' => 'sometimes|required|string',
        ]);

        foreach ($this->authors as $index => $author) {
            if ($author['id'] == $id) {
                $this->authors[$index] = array_merge($author, $request->only('name'));
                return response()->json($this->authors[$index]);
            }
        }

        return response()->json(['message' => 'Author not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         foreach ($this->authors as $index => $author) {
            if ($author['id'] == $id) {
                array_splice($this->authors, $index, 1);
                return response()->json(['message' => 'Deleted']);
            }
        }

        return response()->json(['message' => 'Author not found'], 404);
    }
    
}
