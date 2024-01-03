<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Membre;
use App\Models\TontineIndividuelle;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CotisationController extends Controller
{

    public function createListe()
    {
        $cotisations = Cotisation::with('tontines', 'membres')->get();
        $tontinesI = TontineIndividuelle::all();
        $membres = Membre::all();
        return view('cotisations.affichCotisation', compact('cotisations', 'tontinesI', 'membres'));

    }

    public function CotisationByTontine(Request $request){
        $tontine = $request->input('tontine');
        $cotisations = Cotisation::with('tontines', 'membres')->where('tontine', $tontine)->get();
        $cotisationsArray = $cotisations->toArray();
        return response()->json(['cotisations' => $cotisationsArray]);
    }

    public function createAjout()
    {
        $tontinesI = TontineIndividuelle::all();
        $membres = Membre::all();
        return view('cotisations.cotisation', compact('tontinesI', 'membres'));
    }

    public function createHistorique()
    {
        $cotisations = Cotisation::with('tontines', 'membres')->get();
        return view('cotisations.historiqueCotisation', compact('cotisations'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'membre' => 'required',
            'tontine' => 'required',
            'debut'=>'required|date',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else {
            $tontineId = $request->tontine;
            $tontineIndividuelle = TontineIndividuelle::find($tontineId);
            $membre = Membre::find($request->membre);
            $firstNomMembre = substr($membre->nomMembre,0,2);
            $firstPrenomMembre = substr($membre->prenomMembre,0,2);
            $code = Cotisation::OrderBy('id', 'desc')->first();
            if($code == null){
                $codeCotisation = 'YMCI'.$firstNomMembre.$firstPrenomMembre.'1';
            }else {
                $codeCotisation = 'YMCI'.$firstNomMembre.$firstPrenomMembre.($code->id+1);
            }
            // Compter le nombre de cotisation deja effectuer dans la tontine
            $nombreCotisation = Cotisation::where('tontine', $tontineId)->count();
            if($nombreCotisation <= 30){
                $Cotisations = new Cotisation();
                $Cotisations->codeCotisation = $codeCotisation;
                $Cotisations->tontine = $request->tontine;
                $Cotisations->membre = $request->membre;
                $Cotisations->montantCotisation = $tontineIndividuelle->montantTontineI;
                $Cotisations->dateCotisation = $request->debut;
                $Cotisations->save();

                 // Mettre à jour la colonne statutTontineI si c'est la première cotisation
                $firstCotisation = Cotisation::where('tontine', $request->tontine)->first();
                if ($firstCotisation) {
                    TontineIndividuelle::where('id', $request->tontine)->update(['statutTontinteI' => true]);
                }

                return redirect()->back()->with('success', 'Enregistrement effectuer avec success');
            }else {
                return redirect()->back()->with('erreur', 'Enregistrement effectuer avec success');
            }

        }
    }

    public function getTontineIndividuelle(Request $request) {
        $membreId = $request->input('membre');
        $tontineData = TontineIndividuelle::where('membre', $membreId)->get();

        $tontineDataArray = $tontineData->toArray();

        return response()->json(['tontineData' => $tontineDataArray]);
    }

    // La fonction pour effectuer des recherhes en fonction de la date
    public function searchDate(Request $request){
        $date = $request->input('dateRecherche');
        $cotisations = Cotisation::with('tontines', 'membres')->whereDate('dateCotisation', '=', $date)->get();
        $cotisationsArray = $cotisations->toArray();

        return response()->json(['cotisations' => $cotisationsArray]);
    }

    public function searchHistorique(Request $request){
        $choix = $request->input('choix');
        $recherche = $request->input('txtRecherche');
        $periode = $request->input('periode');
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $annee = $request->input('annee');
        $mois = $request->input('mois');

        $cotisations = Cotisation::with('tontines', 'membres');

        if(!empty($choix) && $choix !== 'null' && !empty($recherche)){
            if($choix === 'identifiant'){
                $cotisations->where('codeCotisation', 'like', '%' . $recherche . '%');
            } elseif($choix === 'tontine'){
                $cotisations->whereHas('tontines', function($query) use ($recherche) {
                    $query->where('nomTontine', 'like', '%'. $recherche . '%')
                        ->orWhere('codeTontine', 'like', '%'. $recherche . '%');
                });
            } elseif($choix === 'membre'){
                $cotisations->whereHas('membre', function($query) use ($recherche){
                    $query->where('nomMembre', 'like', '%'. $recherche . '%')
                        ->orWhere('prenomMembre', 'like', '%'. $recherche . '%')
                        ->orWhere('codeMembre', 'like', '%'. $recherche . '%');
                });
            }
        }

        if(!empty($periode) && $periode !== null){
            if($periode === 'date_unique'){
                $cotisations->whereDate('dateCotisation', '=', $date1);
            }elseif($periode === 'plage_dates'){
                $cotisations->whereBetween('dateCotisation', [$date1, $date2]);
            }elseif($periode === 'annee'){
                $cotisations->whereYear('dateCotisation', $annee);
            }elseif($periode === 'mois') {
                if(!empty($annee) && $annee !== 'null'){
                    $cotisations->whereYear('dateCotisation', $annee)
                            ->whereMonth('dateCotisation', $mois);
                }
                $cotisations->whereMonth('dateCotisation', $mois);
            }
        }

        $cotisations = $cotisations->get();

        return view('cotisations.historiqueCotisation', compact('cotisations'));

    }

    public function getCotisationsInfo($id)
    {


        // Maintenant, utilisez $tontineIndId pour récupérer les informations nécessaires de votre modèle
        $cotisations = Cotisation::with(['tontines', 'membres'])->where('tontine', $id)
            ->first();


        // Retourner les informations de cotisations sous forme de réponse JSON
        return response()->json(['cotisations'=> $cotisations]);
    }
}
