<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display friends list
        return view('friends.index'); // Assuming you have a view for the friends list
    }
} 