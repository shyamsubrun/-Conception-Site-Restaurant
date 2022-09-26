<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('deconnexion');
    }
    
    public function connexion()
    {
        return view('connexion');
    }
    public function process_connexion(Request $requete)
    {
        $requete->validate([
            'login' => 'required|string',
            'mdp' => 'required|string'
        ]);

        $identite = ['login' => $requete->input('login'), 'password' => $requete->input('mdp')];

        if (Auth::attempt($identite)) {
            $requete->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'login' => 'Identifiant ou mot de passe incorrecte.'
        ]);
    }

    public function inscription()
    {
        return view('inscription');
    }
    public function process_inscription(Request $requete)
    {   
        $requete->validate([
            'nom' => 'required|string|max:256',
            'prenom' => 'required|string|max:256',
            'login' => 'required|string|max:256|unique:users',
            'mdp' => 'required|string|confirmed'
        ]);
 
        $utilisateur = new User();
        $utilisateur->nom = $requete->nom;
        $utilisateur->prenom = $requete->prenom;
        $utilisateur->login = $requete->login;
        $utilisateur->mdp = Hash::make($requete->mdp);
        $utilisateur->save();

        Auth::login($utilisateur);
       
        return redirect()->route('home');
    }

    public function deconnexion(Request $requete)
    {
        Auth::logout();
        $requete->session()->invalidate();
        $requete->session()->regenerateToken();
        return redirect()->route('home');
    }

}
