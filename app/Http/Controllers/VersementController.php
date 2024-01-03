<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\Participation;
use App\Models\PayementCollective;
use App\Models\TontineCollective;
use App\Models\Versement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VersementController extends Controller
{



    public function createVersement()
    {
        $tontinesC = TontineCollective::where('statutTontineC', null)->orWhere('statutTontineC', true)->get();
        $membres = Membre::all();
        return view('versements.ajoutPayement', compact('tontinesC', 'membres'));
    }

    public function createListeVersement()
    {
        $versements = Versement::with('tontinesC', 'membres')->get();
        $tontinesC = TontineCollective::all();
        $membres = Membre::all();
        return view('versements.listePayement', compact('versements','tontinesC','membres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'tontine'=>'required|numeric',
            'membre'=>'required|numeric',
            'date'=>'required|date',

        ]);

        if($validation->fails()){
            if ($request->ajax()) {
                return response()->json(['errors' => $validation->errors()], 422);
            } else {
                return redirect()->back()->withErrors($validation)->withInput();
            }
        }else{
            $nomMembre = Membre::all()->where('id', $request->membre)->first();
            $code = Versement::OrderBy('id', 'desc')->first();
            if($code == null){
                $codeVersement = 'YMVTC1';
            }else {
                $codeVersement = 'YMVTC'.($code->id+1);
            }
            $idTonitne = $request->tontine;
            $tontine = TontineCollective::find($idTonitne);
            $montant = $tontine->montant;
            // Recupere le membre associe aux versement
            $membre = $request->membre;

            //Procedure pour verifier que le participant n'effectue pas plus de versement qu'il doit le faire
            // Recuperer les participation de ce membre
            $participation = Participation::where('tontine', $idTonitne)->where('membre', $membre)->get();
            // Recuperer le nombre de participatiion du membre dans la tontine
            $nombreParticipationMembre = $participation->count();
            // Recuperer le nombre de versement du membre dans la tontine
            $nombreVersementMembre = Versement::where('tontine', $idTonitne)->where('membre', $membre)->count();
            // Recuperer le nombre de membre dans la tontine
            $nombreParticipant = Participation::where('tontine', $idTonitne)->count();
            // Le nombre total de versement dans la tontine
            $nombreTotalVersementMembre = $nombreParticipationMembre * $nombreParticipant;

            // Procedure pour verifier que la somme est atteint pour le tour et qu'il faut effectuer un payement
            $totalVersementsAttendus =$nombreParticipant * $tontine->montant;
            // Calcul du total des versements actuels dans la tontine
            $totalVersementsActuels = $tontine->totalVersement;

            // Procedure pour que chaque membre effectue un versement pour chaque tour
            // Recuperer le nombre de payement effectuer dans la tontine
            $nombrePayementActuelle = PayementCollective::where('tontine', $idTonitne)->count();

            // Condition pour effectuer le payement
            if($nombreVersementMembre > $nombreTotalVersementMembre){
                return redirect()->back()->with('error','Ce membre a atteint le nombre de versement dans la tontine');
             }else if(($totalVersementsActuels + $montant) > $totalVersementsAttendus){
                return redirect()->back()->with('error', 'Le montant total des versements a déjà été atteint pour ce tour. Veuillez effectuer un payement');
             }else if($nombreVersementMembre < (($nombrePayementActuelle*$nombreParticipationMembre)+$nombreParticipationMembre)){  // Condition qui verifie si le nombre de versement du membre est inferieur au nombre
                //de payement actuelle fois le nombre de participation du membre plus le nombre de participation pour s'assurer qu'il ne verse plus avant la fin du tour
                $versements = new Versement;
                $versements->codeVersement = $codeVersement;
                $versements->montantVersement = $montant;
                $versements->dateVersement = $request->date;
                $versements->tontine = $idTonitne;
                $versements->membre = $request->membre;
                $versements->save();
                $ifVersement = Versement::where('tontine', $idTonitne);
                if($ifVersement){
                    $montantVerser = $tontine->montant;
                    $montantDejaVerse = $tontine->totalVersement;
                    $tontine->statutTontineC = true;
                    $tontine->totalVersement = $montantDejaVerse + $montantVerser;
                    $tontine->save();
                }
                return redirect()->back()->with('success','Versement effectuer avec succes');
             }
             else {
                return redirect()->back()->with('error','Ce membre a atteint le nombre de versement pour ce tour');
             }



        }
    }

    public function getMembreTontine(Request $request){
        $tontineId = $request->input('tontine');

        $participations = Participation::where('tontine', $tontineId)->with('membres')->get();

        $membres = $participations->toArray();

        return response()->json(['participations' => $membres]);
    }

    public function search(Request $request){
        $choix = $request->input('choix');
        $recherche = $request->input('txtRecherche');
        $periode = $request->input('periode');
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $annee = $request->input('annee');
        $mois = $request->input('mois');
        $versements = Versement::query();
        $versements->with('tontinesC', 'membres');
        if(!empty($choix) && $choix !== null && !empty($recherche)){
            if($choix == 'identifiant'){
                $versements = Versement::where('codeVersement', 'like', '%'. $recherche .'%');
            }else if( $choix == 'tontine'){

                $versements = Versement::whereHas('tontinesC', function ($query) use ($recherche){
                    $query->where('nomTontineC', 'like', '%' . $recherche . '%')
                    ->orWhere('codeTontineC', 'like', '%'. $recherche .'%');
                });
            }else if( $choix == 'membre'){
                $versements = Versement::whereHas('membres', function ($query) use ($recherche){
                    $query->where('nomMembre', 'like', '%' . $recherche . '%');
                });
            }else if( $choix == 'montant'){
                $versements = Versement::where('montant', 'like', '%'. $recherche .'%');
            }else {
                $versements = Versement::with('tontinesC', 'membres');
            }
        }

        if(!empty($periode) && $periode !== null){
            if($periode === 'date_unique'){
                $versements->whereDate('dateVersement', '=', $date1);
            }elseif($periode === 'plage_dates'){
                $versements->whereBetween('dateVersement', [$date1, $date2]);
            }elseif($periode=== 'annee'){
                $versements->whereYear('dateVersement', $annee);
            }elseif($periode === 'mois'){
                if(!empty($annee) && $annee !== null){
                    $versements->whereYear('dateVersement', $annee)->whereMonth('dateVersement', $mois);
                }
                $versements->whereMonth('dateVersement', $mois);
            }
        }
        $versements = $versements->get();
        $tontinesC = TontineCollective::all();
        $membres = Membre::all();
        return view('versements.listePayement', compact('versements','tontinesC','membres'));
    }


}
