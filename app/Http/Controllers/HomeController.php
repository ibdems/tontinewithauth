<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Agent;
use App\Models\Compte;
use App\Models\Membre;
use App\Models\TontineCollective;
use App\Models\TontineIndividuelle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $nombreAgence = Agence::count();
        $nombreMembre = Membre::count();
        $nombreAgent = Agent::count();
        $tontineIndividuelleEncours = TontineIndividuelle::where('statutTontinteI', true)->orWhere('statutTontinteI', null)->count();
        $tontineIndividuelleTermine = TontineIndividuelle::where('statutTontinteI', false)->count();
        $tontineCollectivesEncours = TontineCollective::where('statutTontineC', true)->orWhere('statutTontineC', null)->count();
        $tontineCollectivesTermine = TontineCollective::where('statutTontineC', false)->count();
        $compteTindividuelle = Compte::groupBy('tontineIndividuelle')->sum('montantVerser');
        $compteCollectives = Compte::groupBy('tontineCollectives')->sum('montantVerser');

        return view('dashboard', compact('nombreAgent', 'nombreAgence', 'nombreMembre', 'tontineIndividuelleEncours', 'tontineIndividuelleTermine', 'tontineCollectivesEncours', 'tontineCollectivesTermine', 'compteTindividuelle', 'compteCollectives'));
    }


}
