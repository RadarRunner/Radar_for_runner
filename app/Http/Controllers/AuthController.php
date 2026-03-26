<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Tentative de connexion
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // Redirection après connexion réussie
            return redirect()->route('dashboard');
        }

        // Erreur login
        return back()->withErrors([
            'email' => 'Adresse e-mail ou mot de passe incorrect',
        ])->onlyInput('email');
    }
}
