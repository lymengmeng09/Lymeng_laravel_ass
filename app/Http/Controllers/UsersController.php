<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
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
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json($this->users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'membershipDate' => 'required|date',
        ]);

        $newUser = [
            'id' => (string)(count($this->users) + 1),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'membershipDate' => $validated['membershipDate'],
        ];

        $this->users[] = $newUser;

        return response()->json($newUser, 201);
    }


    public function show(string $id)
    {
        $user = collect($this->users)->firstWhere('id', $id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        {
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'membershipDate' => 'sometimes|required|date',
        ]);

        foreach ($this->users as $index => $user) {
            if ($user['id'] === $id) {
                $this->users[$index] = array_merge($user, $validated);
                return response()->json($this->users[$index]);
            }
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        foreach ($this->users as $index => $user) {
            if ($user['id'] === $id) {
                array_splice($this->users, $index, 1);
                return response()->json(['message' => 'Deleted']);
            }
        }

        return response()->json(['message' => 'User not found'], 404);
    }
    
}
