<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {

        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create() {
        return view('user.create');
    }

    public function store() {

        $data = request()->validate([
            'badge_number' => 'required|integer|digits_between:1,6|unique:users,badge_number',
            'first_name' => 'required|alpha|max:70',
            'last_name' => 'required|alpha|max:70'
        ]);

        User::create($data);

        return redirect('/users');
    }
}
