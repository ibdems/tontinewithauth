<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
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
    public function createAjout()
    {
        $agences = Agence::where('statut', true)->get();
        return view('agents.ajoutAgent',compact('agences'));
    }



    public function create()
    {
        $agences = Agence::all();
        if(Auth::user()->role == 'admin'){
            $agents = Agent::with('agences')->orderBy('statutAgent', 'desc')->get();
        }elseif(Auth::user()->role == 'delegue') {
            $idAgence = Auth::user()->delegues->agence_id;
            $agents = Agent::with('agences')->where('Agence', $idAgence)->orderBy('statutAgent', 'desc')->get();
        }

        return view('agents.listeAgent', compact('agents', 'agences'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nom'=>'required|min:2|max:20',
            'prenom'=>'required|min:3|max:50',
            'adresse'=>'required|min:3|max:50',
            'telephone'=>'required|min:9|max:20',
            'date'=>'required|date',
            'mail'=>'required|email',
            'photo'=>'required|image',
            'password' => 'required|min:4'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else{
            try{
                $nomAgent = $request->nom;
                $prenomAgent = $request->prenom;
                $nomUn = substr($nomAgent,0,1);
                $prenomUn = substr($prenomAgent,0,1);
                $code = Agent::OrderBy('id', 'desc')->first();
                if($code == null){
                    $codeAgent='YM'.$prenomUn.$nomUn.'1';
                } else {
                    $codeAgent= 'YM'.$prenomUn.$nomUn.($code->id+1);
                }
                if(Auth::user()->role == 'delegue'){
                    $user = new User();
                    $user->email = $request->input('mail');
                    $user->password = Hash::make($request->input('password'));
                    $user->role = 'agent';
                    $user->save();
                }

                // Recuperer l'id du delegue connecte
                $idAgence = Auth::user()->delegues->agence_id;
                $agent = new Agent;
                $agent->codeAgent = $codeAgent;
                $agent->agence = $idAgence;
                $agent->nomAgent = $request->input('nom');
                $agent->prenomAgent = $request->input('prenom');
                $agent->adresseAgent = $request->input('adresse');
                $agent->telAgent = $request->input('telephone');
                $agent->dateAdhesion = $request->input('date');
                $agent->mailAgent = $request->input('mail');
                $agent->statutAgent = true;
                $agent->photoAgent = $request->photo->store(config("photo.path"), "public");
                $agent->user_id = $user->id;
                $agent->save();
                return redirect()->back()->with('success', 'Enregistrement effectuer avec success');
            }catch (\Exception $e) {
                return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement');
            }

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
            'photo' => 'nullable|mimes:jpg,png',
            'password' => 'nullable|min:4'
        ]);
        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else{
            $code = $request->input('code');
            $agent = Agent::where('codeAgent', $code)->first();
            if(!$agent){
                return redirect()->back()->with('error', "L'agent avec le code donné n'existe pas.");
            }
            if ($request->filled('password')) {
                $agent->user->password = Hash::make($request->password);
                // Hasher et mettre à jour le mot de passe seulement si un nouveau mot de passe est fourni
            }
            $agent->user->email = $request->mail;
            $agent->user->save();
            $agent->nomAgent = $request->nom;
            $agent->prenomAgent=$request->prenom;
            $agent->adresseAgent=$request->adresse;
            $agent->telAgent=$request->telephone;
            $agent->dateAdhesion=$request->date;
            $agent->mailAgent=$request->mail;

            if ($request->hasFile('photo')) {
                // Si un fichier a été téléchargé, enregistrez-le
                $agent->photoAgent = $request->photo->store(config("photo.path"), "public");
            }
            $agent->save();
            return redirect()->back()->with('success', 'Modification effectuer avec success');
        }
    }

    // La fonction pour suspendre l'agent
    public function suspendAgent(Request $request){
        $code = $request->input('codeAgentSuspend');
        $agents = Agent::where('codeAgent', $code)->first();
        if (!$agents) {
            return redirect()->back()->with('error', "L'agence avec le code donné n'existe pas.");
        }
        $agents->statutAgent = false;
        $agents->save();
        return redirect()->back()->with('success', "Agent suspendu avec succes");
    }

    // Fonction pour reintegrer l'agent
    public function reintgrerAgent(Request $request){
        $code = $request->input('codeReintegreAgent');
        $agents = Agent::where('codeAgent', $code)->first();
        if (!$agents) {
            return redirect()->back()->with('error', "L'agence avec le code donné n'existe pas.");
        }
        $agents->statutAgent = true;
        $agents->save();
        return redirect()->back()->with('success', "Agent reintegrer avec succes");
    }


}
