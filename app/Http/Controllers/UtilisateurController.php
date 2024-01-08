<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function index(){
        $users = User::all();
        return view('utilisateurs.utilisateurs', compact('users'));
    }
}
