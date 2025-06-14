<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    // In-memory user data. This will reset on each request (not stored in DB).
    public $users = [
        [
            'id' => '1',
            'name' => 'Kosal Pouy',
            'email' => 'kosal@gmail.com',
            'membershipDate' => '2023-09-10',
        ],
        [
            'id' => '2',
            'name' => 'Ahnoch Phengneang',
            'email' => 'ahnoch@gmail.com',
            'membershipDate' => '2023-10-22',
        ],
        [
            'id' => '3',
            'name' => 'Bopha Khat',
            'email' => 'bopha@gmail.com',
            'membershipDate' => '2023-11-02',
        ],
        [
            'id' => '4',
            'name' => 'Chhannak Kan',
            'email' => 'channak@gmail.com',
            'membershipDate' => '2023-12-11',
        ],
    ];

    /**
     * Display a list of all users.
     * Route: GET /users
     */
    public function index()
    {
        // Return all users as a JSON array
        return response()->json($this->users);
    }

    /**
     * Create and store a new user.
     * Route: POST /users/create
     */
    public function create(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'membershipDate' => 'required|date',
        ]);

        // Create a new user entry
        $newUser = [
            'id' => (string)(count($this->users) + 1), // Auto-increment ID as string
            'name' => $validated['name'],
            'email' => $validated['email'],
            'membershipDate' => $validated['membershipDate'],
        ];

        // Append new user to the array
        $this->users[] = $newUser;

        // Return the newly created user with a 201 Created response
        return response()->json($newUser, 201);
    }

    /**
     * Show a specific user by ID.
     * Route: GET /users/{id}
     */
    public function show(string $id)
    {
        // Find user with matching ID
        $user = collect($this->users)->firstWhere('id', $id);

        // Return user if found
        if ($user) {
            return response()->json($user);
        }

        // Otherwise return not found response
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Update an existing user by ID.
     * Route: PUT/PATCH /users/{id}
     */
    public function update(Request $request, string $id)
    {
        // Validate only the fields that are provided (optional fields)
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'membershipDate' => 'sometimes|required|date',
        ]);

        // Search for the user and update if found
        foreach ($this->users as $index => $user) {
            if ($user['id'] === $id) {
                // Merge validated data into the existing user
                $this->users[$index] = array_merge($user, $validated);
                return response()->json($this->users[$index]);
            }
        }

        // If user not found
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Delete a user by ID.
     * Route: DELETE /users/{id}
     */
    public function destroy(string $id)
    {
        // Search and delete the user by ID
        foreach ($this->users as $index => $user) {
            if ($user['id'] === $id) {
                array_splice($this->users, $index, 1); // Remove user from array
                return response()->json(['message' => 'Deleted']);
            }
        }

        // If user not found
        return response()->json(['message' => 'User not found'], 404);
    }
}
