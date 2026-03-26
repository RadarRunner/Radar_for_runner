<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{


    public function index()
    {
        if (auth()->guest()) {
            return redirect('welcome')->withErrors([
                'email' => "Vous devez être connecté pour voir cette page.",
            ]);
        }

        return view('dashboard');
    }

}
