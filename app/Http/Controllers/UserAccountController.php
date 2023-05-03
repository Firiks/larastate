<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAccountController extends Controller
{

    /**
     * User account creation form
     *
     * @return \Inertia\ResponseFactory|\Inertia\Response
     */
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // create the user
        $user = User::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]));

        // log the user in
        Auth::login($user);

        return redirect()->route('listing.index')->with('success', 'Account created!');
    }
}
