<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            'email' => ['required','email', 'string', 'unique:users,email'],
        ]);
        User::create($input);
        return response()->json([
            'message' => 'User created successfully'
        ]);

    }
}
