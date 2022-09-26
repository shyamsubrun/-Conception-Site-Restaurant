<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CommandesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function commandes()
    {
        if(Auth::user()->type == 'client') {
            $commandes = DB::table('commandes')->where('user_id', Auth::user()->id)->get();
        } else {
            $commandes = DB::table('commandes')->where('statut', '<', 2)->get();
        }
        return view('commandes', ['commandes' => $commandes]);  
    }

    public function voircommande($id)
    {
        $pizzas = DB::table('commande_pizza')->where('commande_id', $id)->get();
        return view('voircommande', ['pizzas' => $pizzas, 'id' => $id]);  
    }

    public function majcommande($id)
    {
        $commande = DB::table('commandes')->where('id', $id)->first();
        DB::update('update commandes set statut = ? where id = ?', [($commande->statut)+1,$id]);
        return redirect()->route('commandes');
    }
}
