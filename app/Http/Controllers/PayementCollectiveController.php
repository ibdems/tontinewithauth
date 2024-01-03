<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\Participation;
use App\Models\PayementCollective;
use App\Models\TontineCollective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayementCollectiveController extends Controller
{
    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'tontine' => 'required',
            'membre2' => 'required',
            'date'=>['required','date'],
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else {
            $tontineId = $request->input("tontine");
            $membreId = $request->input("membre2");

            $tontine = TontineCollective::find($tontineId);
            $membre = Membre::find($membreId);
            $montant = $tontine->montant;
            $nombreParticipant = $tontine->nombreParticipant;

            $montantPayement = $montant * $nombreParticipant;
            $montantVerser = $tontine->totalVersement;
            if($montantVerser === $montantPayement){

                     $code = PayementCollective::OrderBy('id', 'desc')->first();
                    if($code === null){
                        $codePayement = 'YMPC1';
                    }else{
                        $codePayement = 'YMPCI'.($code->id+1);
                    }

                   // Récupérer les participations distinctes du membre dans la tontine
                    $participationsDistinctes = Participation::where('tontine', $tontineId)
                    ->where('membre', $membreId)
                    ->distinct('id')
                    ->get();

                    $nombreParticipations = $participationsDistinctes->count();


                    // Vérifier le nombre de paiements existants pour ce membre dans cette tontine
                    $nombrePaiementsExistants = PayementCollective::where('tontine', $tontineId)
                                                ->where('membre', $membreId)
                                                ->count();

                    if ($nombrePaiementsExistants < $nombreParticipations) {
                        // Si le nombre de paiements existants est inférieur au nombre de participations
                        // Créer un nouveau paiement pour cette participation
                        $code = PayementCollective::orderBy('id', 'desc')->first();
                        if ($code === null) {
                        $codePayement = 'YMPC1';
                        } else {
                        $codePayement = 'YMPCI' . ($code->id + 1);
                        }

                        $payements = new PayementCollective();
                        $payements->codePayementC = $codePayement;
                        $payements->membres()->associate($membre);
                        $payements->tontines()->associate($tontine);
                        $payements->montantPayementC = $montantPayement;
                        $payements->datePayementC = $request->date;
                        $payements->save();
                    } else {
                        return redirect()->back()->with('error','Ce membre a deja été payer');
                    }

                    $nombre = PayementCollective::where('tontine', $tontineId);
                    $nombrePayement = $nombre->count();

                // Si chaque participant est payee le statut de la tontine passe a false
                if($nombreParticipant == $nombrePayement){
                        $tontine->statutTontineC = false;
                        $tontine->totalVersement = 0;
                        $tontine->save();
                }

                // Apres chaque payement le total de versement passe a 0
                $tontine->totalVersement = 0;
                $tontine->save();
                return redirect()->back()->with('success','Payement effectuer avec succes');
            }else{
                return redirect()->back()->with('error','Payement impossible, Versement manquant');
            }



        }


    }
}
