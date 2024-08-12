<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        //collect all users on val name users
        $users = User::all();
        //return to the client response
        return response()->json([
            'data' => $users
        ]);
    }

    public function store(Request $request)
    {
        //step 1: validate the input data. done
        //step 2: store the user on the database. done
        //step 3: return message to the client.
        $input = $request->validate([
            'name' => ['string', 'required'],
            'email' => ['required', 'email', 'string', 'unique:users,email'],
        ]);
        User::create($input);
        return response()->json([
            'message' => 'User created successfully'
        ]);

    }

    public function show($id)
    {
        //step 1: search for the user
        //step 2: return user information to the client
        $user = User::findOrFail($id);

        return response()->json([
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        //step 1: validate the data
        //step 2: search for the user
        //step 3: update user data
        //step 4: return to the client

        $input = $request->validate([
            'name' => ['string'],
            'email' => ['string', 'email', Rule::unique('users', 'email')->ignore($id)]
        ]);

        $user = User::findOrFail($id);

        $user->update($input);

        return response()->json([
            'data' => 'user updated successfully'
        ]);
    }

    public function destroy($id)
    {
        //step 1: search for the user
        //step 2: delete user
        //step 3: return to the client

        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'data' => 'user deleted successfully'
        ]);
    }
}
