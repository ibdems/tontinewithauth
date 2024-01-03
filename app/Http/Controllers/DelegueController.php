<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Delegue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DelegueController extends Controller
{
    public function index(){
        $agences = Agence::all();
        return view('delegues.ajoutDelegue', compact('agences'));
    }

    public function list(){
        $agences = Agence::all();
        $delegues = Delegue::with('agences')->get();
        return view('delegues.listDelegue', compact('agences', 'delegues'));
    }

    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'nom'=>'required|min:2|max:20|alpha',
            'prenom'=>'required|min:3|max:50',
            'adresse'=>'required|min:3|max:50',
            'telephone'=>'required|min:9|max:20',
            'date'=>'required|date',
            'mail'=>'required|email',
            'photo'=>'required|image',
            'agence' => 'required|exists:agences,id',
            'password' => 'nullable|min:4',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else{
            $nomDelegue = $request->input('nom');
            $prenomDelegue = $request->input('prenom');
            $nomUn = substr($nomDelegue,0,1);
            $prenomUn = substr($prenomDelegue,0,1);
            $code = Delegue::OrderBy('id', 'desc')->first();
            if($code == null){
                $codeDelegue='YM'.$prenomUn.$nomUn.'1';
            } else {
                $codeDelegue= 'YM'.$prenomUn.$nomUn.($code->id+1);
            }
            // Création de l'utilisateur User
            $user = new User();
            $user->email = $request->mail;
            $user->password = Hash::make($request->password);
            $user->role = 'delegue';
            $user->save();

            $delegue = new Delegue;
            $delegue->codeDelegue = $codeDelegue;
            $delegue->agence_id = $request->agence;
            $delegue->nomDelegue = $request->nom;
            $delegue->prenomDelegue=$request->prenom;
            $delegue->adresseDelegue=$request->adresse;
            $delegue->telDelegue=$request->telephone;
            $delegue->dateAdhesion=$request->date;
            $delegue->mailDelegue=$request->mail;
            $delegue->photoDelegue=$request->photo->store(config("photo.path"), "public");
            $delegue->user_id = $user->id;
            $delegue->save();

            return redirect()->back()->with('success', 'Enregistrement effectuer avec success');
        }
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nom'=>'required|min:2|max:20|alpha',
            'prenom'=>'required|min:3|max:50',
            'adresse'=>'required|min:3|max:50',
            'telephone'=>'required|min:9|max:20',
            'date'=>'required|date',
            'mail'=>'required|email',
            'photo'=>'image',
            'agence' => 'nullable',
            'password' => 'nullable|min:4'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            $code = $request->input('code');
            // Assurez-vous de charger le délégué avec l'utilisateur associé
            $delegue = Delegue::where('codeDelegue', $code)->with('user')->first();

            if (!$delegue) {
                return redirect()->back()->with('error', "Le délégué avec le code donné n'existe pas.");
            }

            // Mettez à jour les informations du délégué
            if($request->filled('agence')){
                $delegue->agence_id = $request->agence;
            }
            $delegue->nomDelegue = $request->nom;
            $delegue->prenomDelegue = $request->prenom;
            $delegue->adresseDelegue = $request->adresse;
            $delegue->telDelegue = $request->telephone;
            $delegue->dateAdhesion = $request->date;
            $delegue->mailDelegue = $request->mail;

            // Mettez à jour le mot de passe seulement si un nouveau mot de passe est fourni
            if ($request->filled('password')) {
                $delegue->user->password = Hash::make($request->password);
            }
            $delegue->user->email = $request->mail;
            $delegue->user->save();  // Enregistrez l'utilisateur séparément

            if ($request->hasFile('photo')) {
                // Si un fichier a été téléchargé, enregistrez-le
                $delegue->photoDelegue = $request->photo->store(config("photo.path"), "public");
            }

            // Enregistrez le délégué
            $delegue->save();

            return redirect()->back()->with('success', 'Modification effectuée avec succès');
        }
    }


    public function search(Request $request){
        // Je recupere la valeur choisi dans le champs select
        $choix = $request->input('choix');

        // Je recupere la valeur qui sera saisi dans le champ filtrer
        $recherche = $request->input('recherche_element');

        $delegues = Delegue::query();
        $delegues->with('agences');
        //Effectuer la recherche en fonction du choix de l'utilisateur
        if($choix === 'identifiant'){
            $delegues = Delegue::where('codeDelegue', 'like', '%' . $recherche .'%');
        }else if($choix==='nom'){
            $delegues = Delegue::where('nomDelegue', 'like', '%' . $recherche . '%');
        }else if($choix === 'prenom'){
            $delegues = Delegue::where('prenomDelegue', 'like', '%' . $recherche . '%');
        }else if($choix === 'adresse'){
            $delegues = Delegue::where('adresseDelegue', 'like', '%' . $recherche . '%');
        }else if($choix === 'agence'){
            $delegues = Delegue::whereHas('agences', function ($query) use ($recherche){
                $query->where('nomAgence', 'like', '%' . $recherche . '%');
            });
        }
        else {
             $Delegues = Delegue::with('Agences');
        }

        $delegues = $delegues->get();
         $agences = Agence::all();

        return view('delegues.listDelegue', compact('delegues','agences'));
    }
}
