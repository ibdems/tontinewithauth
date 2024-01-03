<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Agence;
use Illuminate\Support\Facades\Request as FacadesRequest;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agences = Agence::orderBy('statut', 'desc')->get();
        return view('agences.afficherAgence',compact('agences'));
    }

    public function createAjout()
    {
        return view('agences.ajoutAgence');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'nomAgence'=>'required|min:3|max:70',
            'adresseAgence'=>'required|min:3|max:40',
            'telAgence'=>'required|min:9|max:20|',
            'mailAgence'=>'required|email',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else {
            $code = Agence::OrderBy('id', 'desc')->first();
            if($code == null){
                $codeAgence = 'YMAG1';
            }else {
                $codeAgence = 'YMAG'.($code->id+1);
            }
            $Agence = new Agence;
            $Agence->codeAgence = $codeAgence;
            $Agence->nomAgence = $request->input('nomAgence');
            $Agence->adresseAgence = $request->input('adresseAgence');
            $Agence->telAgence = $request->input('telAgence');
            $Agence->mailAgence= $request->input('mailAgence');
            $Agence->statut= true;
            $Agence->save();
            return redirect()->back()->with('success', "Enregistrement effectuee avec success");
        }
    }

     public function update(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'MnomAgence'=>'required|min:3|max:70',
            'MadresseAgence'=>'required|min:3|max:40',
            'MtelAgence'=>'required|min:9|max:20|',
            'MmailAgence'=>'required|email',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else {

            $code = $request->input('idAgence');
            $agence = Agence::where('codeAgence', $code)->first();
            if (!$agence) {
                return redirect()->back()->with('error', "L'agence avec le code donné n'existe pas.");
            }

            $agence->nomAgence = $request->input('MnomAgence');
            $agence->adresseAgence = $request->input('MadresseAgence');
            $agence->telAgence = $request->input('MtelAgence');
            $agence->mailAgence= $request->input('MmailAgence');
            $agence->save();
            return redirect()->back()->with('success', "Modication effectuee avec success");
        }
    }

    public function arretAgence(Request $request){
        $code = $request->input('codeAgenceArret');
        $agences = Agence::where('codeAgence', $code)->first();
        if (!$agences) {
            return redirect()->back()->with('error', "L'agence avec le code donné n'existe pas.");
        }
        $agences->statut = false;
        $agences->save();
        return redirect()->back()->with('success', "Agence arreter avec succes");
    }

    public function actifAgence(Request $request){
        $code = $request->input('codeAgenceActivation');
        $agences = Agence::where('codeAgence', $code)->first();
        if (!$agences) {
            return redirect()->back()->with('error', "L'agence avec le code donné n'existe pas.");
        }
        $agences->statut = true;
        $agences->save();
        return redirect()->back()->with('success', "Agence reativer avec succes");
    }
    public function search(Request $request)
    {
        $choix = $request->input('choix');
        $recherche = $request->input('txtRecherche');
        $agences = Agence::query(); // Initialisez la requête de base.

        if ($choix == 'nom') {
            $agences->where('nomAgence', 'like', '%' . $recherche . '%');
        } elseif ($choix == 'code') {
            $agences->where('codeAgence', 'like', '%' . $recherche . '%');
        } elseif ($choix == 'adresse') {
            $agences->where('adresseAgence', 'like', '%' . $recherche . '%');
        } elseif ($choix == 'statut') {
            if ($recherche == 'Actif') {
                $agences->where('statut', true);
            } else if ($recherche == 'Arrêté') {
                $agences->where('statut', false);
            }
        }else {
            $agences = Agence::orderBy('statut', 'desc');
        }

        // Exécutez la requête et récupérez les résultats.
        $agences = $agences->get();

        return view('agences.afficherAgence', compact('agences'));
    }


}
