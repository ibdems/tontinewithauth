<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Membre;
use App\Models\Participation;
use App\Models\PayementCollective;
use App\Models\TontineCollective;
use App\Models\Versement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TontineCollectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    // La fonction pour afficher la page d'ajout
    public function createTontine()
    {
        $agents = Agent::all();
        return view('tontineCollectifs.ajoutTontine', compact('agents'));
    }

    // La fonction pour afficher la liste des tontines
    public function createListeTontine()
    {
        $agents = Agent::all();
        $tontines = TontineCollective::with('agents')
                    ->where('statutTontineC', null)
                    ->orWhere('statutTontineC', true)
                    ->get();
        return view('tontineCollectifs.listeTontine', compact('tontines', 'agents'));
    }

    // La fonction pour afficher la page d'historique de la tontine
    public function createHistoriqueTontine()
    {
        $agents = Agent::all();
        $tontines = TontineCollective::with('agents')->get();
        return view('tontineCollectifs.historiqueTontine', compact('tontines', 'agents'));
    }

    // La fonction pour afficher la page de gestion de la tontine
    public function createGestionTontine()
    {
        $agents = Agent::all();
        $membres = Membre::all();
        $tontines = TontineCollective::with('agents')->get();
        return view('tontineCollectifs.gestionTontine', compact('tontines', 'agents', 'membres'));
    }


    // La fonction pour enregistrer les tontines
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'nom'=>'required',
            'debut'=>'required|date',
            'montant'=>'required|numeric',
            'frequence'=>'required',

        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else{


            $tontines = new TontineCollective();
            $code = TontineCollective::OrderBy('id', 'desc')->first();
            if($code == null){
                $codeTontineC = 'YMTC1';
            }else{
                $codeTontineC='YMTC'.($code->id+1);
            }
            $tontines->codeTontineC = $codeTontineC;
            $tontines->nomTontineC = $request->nom;
            $tontines->debutTontineC = $request->debut;
            $tontines->montant = $request->montant;
            $tontines->frequence = $request->frequence;
            $tontines->agent = 1;
            $tontines->save();
            return redirect()->back()->with('success','Enregistrement effectuer avec succes');
        }
    }


    // La fonction pour modifier les tontines
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'nom'=>'required',
            'debut'=>'required|date',
            'montant'=>'required',
            'frequence'=>'required',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }else{

            $code = $request->input('code');
            $tontines = TontineCollective::where('codeTontineC',$code)->first();
            $statutTontine = $tontines->statutTontineC;
            if(!$tontines){
                return redirect()->back()->with('error', "La tontine avec le code donné n'existe pas.");
            }

            if($statutTontine !== null){
                return redirect()->back()->with('error','Modification impossible car la tontine a deja commencer');
            } else {
                $tontines->nomTontineC = $request->nom;
                $tontines->debutTontineC = $request->debut;
                $tontines->montant = $request->montant;
                $tontines->frequence = $request->frequence;
                $tontines->save();
                return redirect()->back()->with('success','Modification effectuer avec succes');
            }

        }
    }


    // La fonction pour recherher les tontines
    public function search(Request $request){
        $choix = $request->input('choix');

        $recherche = $request->input('txtRecherche');

        $tontines = TontineCollective::query();

        if($choix == 'identifiant'){
            $tontines = TontineCollective::where('codeTontineC', 'like', '%' . $recherche .'%');
        }else if($choix == 'nom'){
            $tontines = TontineCollective::where('nomTontineC', 'like', '%' . $recherche .'%');
        }else if($choix == 'montant'){
            $tontines = TontineCollective::where('montant', 'like', '%' . $recherche .'%');
        }else if($choix == 'agent'){
            $tontines->whereHas('agents', function ($query) use ($recherche){
                $query->where('nomAgent', 'like', '%' . $recherche . '%')
                ->orWhere('prenomAgent', 'like', '%' . $recherche . '%');
            });
        }else{
             $tontines = TontineCollective::with('agents');
        }
        $tontines = $tontines->get();
        $agents = Agent::all();
        return view('tontineCollectifs.listeTontine', compact('tontines', 'agents'));
    }

    // lA FONCTION POUR RECHERCHER DANS L'HISTORIQUE DE LA TONTINE
    public function searchHistoriqueTontineC(Request $request){
        $choix = $request->input('choix');
        $recherche = $request->input('txtRecherche');

        $periode = $request->input('periode');
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $annee = $request->input('annee');
        $mois = $request->input('mois');

        $tontines = TontineCollective::with('agents');

        if(!empty($choix) && $choix !== 'null' && !empty($recherche)){
            if($choix == 'identifiant'){
                $tontines = TontineCollective::where('codeTontineC', 'like', '%' . $recherche .'%');
            }else if($choix == 'nom'){
                $tontines = TontineCollective::where('nomTontineC', 'like', '%' . $recherche .'%');
            }else if($choix == 'montant'){
                $tontines = TontineCollective::where('montant', 'like', '%' . $recherche .'%');
            }else if($choix == 'agent'){
                $tontines->whereHas('agents', function ($query) use ($recherche){
                    $query->where('nomAgent', 'like', '%' . $recherche . '%')
                    ->orWhere('prenomAgent', 'like', '%' . $recherche . '%');
                });
            }else if($choix == 'statut'){
                if($recherche == 'Non debuté'){
                    $tontines->where('statutTontineC', null);
                }else if($recherche == 'En cours'){
                    $tontines->where('statutTontineC', true);
                }elseif($recherche == 'Terminé'){
                    $tontines->where('statutTontineC', false);
                }
            }
        }

        if(!empty($periode) && $periode !== 'null'){
            if($periode === 'date_unique'){
                $tontines->whereDate('debutTontineC', '=', $date1);
            }elseif($periode === 'plage_dates'){
                $tontines->whereBetween('debutTontineC', [$date1, $date2]);
            }elseif ($periode === 'annee'){
                $tontines->whereYear('debutTontineC', $annee);
            }else if ($periode === 'mois'){
                if(!empty($annee) && $annee !== 'null'){
                    $tontines->whereYear('debutTontineC', $annee)
                            ->whereMonth('debutTontineC', $mois);
                }
                $tontines->whereMonth('debutTontineC', $mois);
            }
        }

        $tontines = $tontines->get();

        $agents = Agent::all();
        return view('tontineCollectifs.historiqueTontine', compact('tontines', 'agents'));


    }

    // La fonction pour associer les membres a la tontine
    public function associate(Request $request){

        $validation = Validator::make($request->all(),[
            'membre'=>'required',

        ]);

        if($validation->fails()){
            return response()->json([ 'error' => 'Veuillez choisir le membre concernee']);
        } else {

            $tontineId = $request->tontine;
            $tontine = TontineCollective::find($tontineId);
            $versement = Versement::where('tontine', $tontineId);
            $nombreVersement = $versement->count();
            if($nombreVersement >= 1){
                return response()->json(['error' => 'Erreur: La tontine a deja debuter']);
            }else {
                $membreId = $request->membre;
                $membre = Membre::find($membreId);

                // Créez une nouvelle participation
                $participation = new Participation();

                // Associez la tontine au membre dans la participation
                $participation->tontinesC()->associate($tontine);
                $participation->membres()->associate($membre);

                // Enregistrez la participation
                $participation->save();

                // Assurez-vous que vous attribuez les dates aux objets Membre correctement si nécessaire
                $membre->created_at = now();
                $membre->updated_at = now();
                $membre->save();

                $nombre = $tontine->nombreParticipant;
                $tontine->nombreParticipant = $nombre + 1;
                $tontine->save();



                // Retournez la vue avec les données mises à jour
                return response()->json([
                    'participation' => $participation,
                    'success' => 'Membre associer avec succes'
                ]);
            }

        }

    }

    public function displayMembre(Request $request){
        $tontineId = $request->tontineId;

        // Récupérer la tontine avec les membres et leurs versements et participations
        $tontine = TontineCollective::with('membresVersements', 'membresParticipations')->find($tontineId);
        $participant = Participation::with('tontinesC', 'membres')
                ->select('membre')
                ->where('tontine', $tontineId)
                ->groupBy('membre') // Regrouper par membre
                ->get();
        $participantArray = $participant->toArray();

        // Récupérer tous les versements pour la tontine donnée
    $versements = Versement::where('tontine', $tontineId)
            ->select('membre', DB::raw('count(*) as nombreVersements'), DB::raw('sum(montantVersement) as montantTotalVersement'))
            ->groupBy('membre')
            ->get();
        $versementsParMembre = $versements->toArray();
        // Recuperer le nombre de participation de chaque membre
        $nombreParticipationMembre = Participation::where('tontine', $tontineId)
                                    ->select('membre', DB::raw('count(*) as nombreParticipations'))
                                    ->groupBy('membre')->get();

        $nombreParticipatonArray = $nombreParticipationMembre->toArray();
        // Recuperer le nombre total de participant
        $nombreParticipant = $tontine->nombreParticipant;

        $montantTontine = $tontine->montant;
        // Recuperer le montant total a verser
            // Initialiser le montant total à verser par membre
        $montantTotalAverser = $montantTontine * $nombreParticipant;

        // Récupérer tous les paiements pour la tontine donnée (s'il s'agit de la table payements)
        $payements = PayementCollective::whereIn('tontine', [$tontineId])
                    ->select('membre', DB::raw('count(*) as nombrePayementMembre'))
                    ->groupBy('membre')
                    ->get();
        $payer = $payements->toArray(); // S'assurer que c'est la bonne logique pour déterminer si le membre a payé

        return response()->json([
            'participant' => $participantArray,
            'versementsParMembre' => $versementsParMembre,
            'payer' => $payer,
            'montantTontine'=> $montantTontine,
            'nombreParticipationMembre' => $nombreParticipatonArray,
            'montantTotalAverser' =>$montantTotalAverser,

        ]);
    }

    // Fonction pour recuperer les info de la tontine
    public function getInfoTontineCollective($id){
        $tontine = TontineCollective::with('membresVersements', 'membresParticipations')->where('id', $id)->first();
        $payments = PayementCollective::where('tontine', $id)->get();
        $numPayments = $payments->count(); // Obtient le nombre de paiements

        $nombreParticipants = $tontine->nombreParticipant;
        $montant = $tontine->montant;
        $montantTotal = $montant * $nombreParticipants;
        $resteAprendre = $nombreParticipants - $numPayments; // Calcul du reste à prendre

        return response()->json([
            'tontine' => $tontine,
            'numPayments' => $numPayments,
            'resteAprendre' => $resteAprendre,
            'montantTotal' => $montantTotal,
        ]);
    }

}
