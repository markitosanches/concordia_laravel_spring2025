<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|max:20'
        ]);

        $credentials = $request->only('email', 'password');

       if(!Auth::validate($credentials)):
            return redirect(route('login'))
                    ->withErrors(trans('auth.password'))
                    ->withInput();
       endif;
       $user = Auth::getProvider()->retrieveByCredentials($credentials);
       Auth::login($user);
       Auth::user()->roles()->detach();
       if($user->role_id === 1){
            $user->assignRole('Admin');
       } elseif ($user->role_id === 2){
            $user->assignRole('Employee');
       }

       return redirect()->intended(route('user.index'))->withSuccess('Signed in');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
       Auth::logout();
       return redirect(route('login'));
    }
}
