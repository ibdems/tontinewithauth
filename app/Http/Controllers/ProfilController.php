<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\Delegue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profil.profil');
    }

    public function update(Request $request){
        $validation = Validator::make($request->all(), [
            'nom' => 'required|min:3|max:20',
            'prenom' => 'required|min:3|max:20',
            'tel' => 'required|min:9',
            'email' => 'required|email',
            'address' => 'required|min:3|max:20',
            'date' => 'required|date'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else{
           $currentId = Auth::user()->id;
           $user = User::where('id', $currentId)->first();
            //    Logique : Effectuer la modification selon le role de l'utilisateur connecter
           if(auth()->user()->role == 'admin'){

                $admin = Admin::where('user_id', $currentId)->first();

                $user->email = $request->input('email');
                $user->save();
                $admin->nomAdmin = $request->input('nom');
                $admin->prenomAdmin = $request->input('prenom');
                $admin->telAdmin = $request->input('tel');
                $admin->dateAdhesion = $request->input('date');
                $admin->adresseAdmin = $request->input('address');
                $admin->mailAdmin = $request->input('email');
                if($request->hasFile('photo')){
                    $admin->photoAdmin = $request->file('photo')->store(config('photo.path'), 'public');
                }
                $admin->save();

                // Vérifier si l'email a été modifié
                if ($request->input('email') !== $user->email) {
                    // Déconnexion de l'utilisateur pour éviter les incohérences de session
                    Auth::logout();

                    // Connexion avec les nouvelles informations (évitez d'effectuer cette action directement, ce serait mieux de demander à l'utilisateur de se reconnecter avec son nouveau mail)
                    Auth::login($user);
                }
                return redirect()->back()->with('success', 'Modification effectuer avec success');
           } else if(auth()->user()->role == 'delegue'){

                $delegue = Delegue::where('user_id', $currentId)->first();

                $user->email = $request->input('email');
                $user->save();
                $delegue->nomDelegue = $request->input('nom');
                $delegue->prenomDelegue = $request->input('prenom');
                $delegue->telDelegue = $request->input('tel');
                $delegue->dateAdhesion = $request->input('date');
                $delegue->adresseDelegue = $request->input('address');
                $delegue->mailDelegue = $request->input('email');
                if($request->hasFile('photo')){
                    $delegue->photoDelegue = $request->file('photo')->store(config('photo.path'), 'public');
                }
                $delegue->save();

                // Vérifier si l'email a été modifié
                if ($request->input('email') !== $user->email) {
                    // Déconnexion de l'utilisateur pour éviter les incohérences de session
                    Auth::logout();

                    // Connexion avec les nouvelles informations (évitez d'effectuer cette action directement, ce serait mieux de demander à l'utilisateur de se reconnecter avec son nouveau mail)
                    Auth::login($user);
                }
                return redirect()->back()->with('success', 'Modification effectuer avec success');
            }else if(auth()->user()->role == 'agent'){

                $agent = Agent::where('user_id', $currentId)->first();

                $user->email = $request->input('email');
                $user->save();
                $agent->nomAgent = $request->input('nom');
                $agent->prenomAgent = $request->input('prenom');
                $agent->telAgent = $request->input('tel');
                $agent->dateAdhesion = $request->input('date');
                $agent->adresseAgent = $request->input('address');
                $agent->mailAgent = $request->input('email');
                if($request->hasFile('photo')){
                    $agent->photoAgent = $request->file('photo')->store(config('photo.path'), 'public');
                }
                $agent->save();

                // Vérifier si l'email a été modifié
                if ($request->input('email') !== $user->email) {
                    // Déconnexion de l'utilisateur pour éviter les incohérences de session
                    Auth::logout();

                    // Connexion avec les nouvelles informations (évitez d'effectuer cette action directement, ce serait mieux de demander à l'utilisateur de se reconnecter avec son nouveau mail)
                    Auth::login($user);
                }
                return redirect()->back()->with('success', 'Modification effectuer avec success');
            }

        }
    }

    public function updatePassword(Request $request){
        $currentId = Auth::user()->id;
        $user = User::where('id', $currentId)->first(); // Récupération de l'utilisateur actuel

        // Validation des données du formulaire
        $validatedData = Validator::make($request->all(),[
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        // Vérification du mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
        }

        // Mise à jour du mot de passe
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès!');
    }


}
