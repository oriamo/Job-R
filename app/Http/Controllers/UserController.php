<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    //to show the register/create user form
    public function create()
    {
        return view('users.create');
    }


    // create and store a new user
    public function store(Request $request)
    {
        //validate the form data
       $formFields =  $request->validate([
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            //the confirmed rule will look for a matching field with _confirmation 
            //appended to it so no need to write password_confirmation
            'password' => 'required|min:8|confirmed',
        ]);

        //hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //create a new user
        $user = User::create($formFields);

        //save the user
        $user->save();

        //sign in the user
        auth()->login($user);

        //redirect to home page
        return redirect('/')->with('message', 'Thanks for signing up!');
    }

    //log user out
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out');
    }

    //login in the user 
    public function login()
    {
        return view('users.login');
    }

    //authenticate the user
    public function authenticate(Request $request){

          //validate the form data
       $formFields =  $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
        ]);

        //attempt to log the user in
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }


}
