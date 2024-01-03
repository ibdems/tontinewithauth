<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Cotisation;
use App\Models\PayementIndividuelle;
use App\Models\TontineIndividuelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayementIndividuelleController extends Controller
{
    //  Payement des tontines individuelle et cloture de la tontine
    public function payementTontineIndividuelle(Request $request){
        $codeTontine = $request->input("code");
        $validation = Validator::make($request->all(), [
            'datePayement' =>'required|date',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            // Verifier si la table n'a pas deja un enregsrement
            $code = PayementIndividuelle::OrderBy("id","desc")->first();
            // Generer le code en fonction du resultat obtenu
            if($code == null){
                $codePayement = 'YMPTI1';
            }else{
                $codePayement ='YMPTI1'. ($code->id);
            }
            $tontine = TontineIndividuelle::with('membres', 'agents')->where('codeTontineI', $codeTontine)->first();
            $cotisation = Cotisation::all();
            // Recuperer le membre concerner
            $membre = $tontine->membre;
            $tontineId = $tontine->id;
            // Recuperer le montant a cotiser dans la tontine
            $montantACotiser = $tontine->montantTontineI;
            // recuperer le montant total de la cotisation pour le considerer comme le montant de la tontine
            $montantTotalCotiser = $cotisation->sum('montantCotisation');
            // Recuperer le montant a payer
            $montantAPayer = $montantTotalCotiser - $montantACotiser;

            // Verifier si la tontine n'a pas eu de payement
            $verification = $tontine->payementIndividuelles->isEmpty();
            if($verification){
                // Inserer les donnees pour le payement
                $payements = new PayementIndividuelle;
                $payements->codePayementI = $codePayement;
                $payements->montantPayementI = $montantAPayer;
                $payements->datePayementI = $request->datePayement;
                $payements->tontine = $tontineId;
                $payements->membre = $membre;
                $payements->save();

                //  Inserer les donnnes pour le payement
                $comptes = new Compte;
                $comptes->montantVerser = $montantACotiser;
                $comptes->dateVersement = $request->datePayement;
                $comptes->tontineIndividuelle = $tontineId;
                $comptes->save();

                // Mettre le statut de la tontine a false
                $tontine->statutTontinteI = false;
                $tontine->save();
               

                return redirect()->back()->with('success', 'Payement effectuer avec success et fin de cette tontine');
            }else {
                return redirect()->back()->with('error','Vous ne pouvez pas effectuer un payement sur cette tontine');
            }
        }


    }
}
