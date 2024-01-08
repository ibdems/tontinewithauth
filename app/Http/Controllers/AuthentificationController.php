<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthentificationController extends Controller
{
    public function dologin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Si l'authentification est reussi
               $request->session()->regenerate();
                return redirect()->intended(route('acceuil'));
            } else {
                // Authentication failed
                $user = User::where('email', $request->input('email'))->first();



                if (!$user) {
                    return back()->withErrors(['email' => 'Adresse e-mail incorrecte'])->withInput($request->except('password'));
                } else {
                    return back()->withErrors(['password' => 'Mot de passe incorrect'])->withInput($request->except('password'));
                }
            }
        }
    }

    public function logout(){
        Auth::logout();
        return to_route('auth.login');
    }
    public function login(Request $request){

        // Création de l'utilisateur User
        // $user = new User();
        // $user->email = 'ibrahima882001@gmail.com';
        // $user->password = Hash::make('1234');
        // $user->role = 'admin';
        // $user->save();

        // $admin = new admin;
        // $admin->codeadmin ='YMAD2';
        // $admin->nomadmin = 'Diallo';
        // $admin->prenomadmin='Ibrahima';
        // $admin->adresseadmin='Hamdallaye';
        // $admin->teladmin='625149588';
        // $admin->dateAdhesion='2023-12-12';
        // $admin->mailadmin='ibrahima882001@gmail.com';
        // $admin->photoadmin='akhhd';
        // $admin->user_id = $user->id;
        // $admin->save();
        return view('auth.login');

    }
}



