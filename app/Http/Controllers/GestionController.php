<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GestionController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function gestionpizzas()
    {
        $pizzas = DB::table('pizzas')->get();
        return view('gestionpizzas', ['pizzas' => $pizzas]);  
    }

    public function ajouterpizza()
    {
        return view('ajouterpizza');  
    }

    public function process_ajouterpizza(Request $requete)
    {
        $requete->validate([
            'nom' => 'required|string|max:256',
            'description' => 'required|string|max:10000',
            'prix' => 'required|int',
        ]);

        DB::insert('insert into pizzas (nom, description, prix) values ( ?, ?, ? )', [$requete->input('nom'),$requete->input('description'),$requete->input('prix')]);
        return redirect()->route('gestionpizzas');
    }

    public function modifierpizza($id)
    {
        $pizza = DB::table('pizzas')->where('id', $id)->first();
        return view('modifierpizza', ['pizza' => $pizza]);  
    }

    public function process_modifierpizza(Request $requete)
    {
        $requete->validate([
            'nom' => 'required|string|max:256',
            'description' => 'required|string|max:10000',
            'prix' => 'required|int',
        ]);

        DB::update('update pizzas set nom = ?, description = ?, prix = ? where id = ?', [$requete->input('nom'),$requete->input('description'),$requete->input('prix'),$requete->input('id')]);
        return redirect()->route('gestionpizzas');
    }

    public function gestionutilisateurs()
    {
        $utilisateurs = DB::table('users')->get();
        return view('gestionutilisateurs', ['utilisateurs' => $utilisateurs]);  
    }

    public function modifierutilisateur($id)
    {
        $utilisateur = DB::table('users')->where('id', $id)->first();
        return view('modifierutilisateur', ['utilisateur' => $utilisateur]);  
    }

    public function process_modifierutilisateur(Request $requete)
    {
        $requete->validate([
            'nom' => 'required|string|max:256',
            'prenom' => 'required|string|max:256',
            'mdp' => 'required|string|confirmed',
            'type' => 'required'
        ]);

        DB::update('update users set nom = ?, prenom = ?, mdp = ?, type = ? where id = ?', [$requete->input('nom'),$requete->input('prenom'),Hash::make($requete->input('mdp')),$requete->input('type'),$requete->input('id')]);
        return redirect()->route('gestionutilisateurs');
    }

    public function supprimerutilisateur($id) {
        DB::delete('delete from users where id = ?', [$id]);
        return redirect()->route('gestionutilisateurs');
    }
}
