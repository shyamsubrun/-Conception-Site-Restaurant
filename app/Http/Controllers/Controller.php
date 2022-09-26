<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $noms = DB::table('pizzas')->get();
        return view('index', ['noms' => $noms]);
    }

    
    public function modifierprofil()
    {
        return view('modifierprofil');  
    }

    public function process_modifierprofil(Request $requete)
    {
        $requete->validate([
            'mdp' => 'required|string|confirmed'
        ]);

        DB::update('update users set mdp = ? where login = ?', [Hash::make($requete->input('mdp')),Auth::user()->login]);
        return redirect()->route('home');
    }
}
