<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MemberStorePostRequest;
use App\Http\Requests\MemberUpdateRequest;

class MemberController extends Controller
{
    /**
     * GET /members
     * List all members
     */
    public function index()
    {
        $members = Members::all();
        return response()->json($members);
    }

    /**
     * POST /members
     * Store a new member
     */
  public function store(MemberStorePostRequest $request)
{
    $member = Members::create($request->validated());

    return response()->json([
        "message" => "Success",
        "data" => $member
    ]);
}


    /**
     * GET /members/{id}
     * Show a specific member
     */
    public function show(string $id)
    {
        $member = Members::find($id);

        if ($member) {
            return response()->json($member);
        }

        return response()->json(['message' => 'Member not found'], 404);
    }

    /**
     * PUT or PATCH /members/{id}
     * Update a member
     */
    public function update(MemberUpdateRequest $request, string $id)
{
    $member = Members::find($id);

    if (!$member) {
        return response()->json([
            'success' => false,
            'message' => 'Member not found'
        ], 404);
    }

    $member->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Member updated successfully',
        'data' => $member
    ]);
}

    /**
     * DELETE /members/{id}
     * Delete a member
     */
    public function destroy(string $id)
    {
        $member = Members::find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $member->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
