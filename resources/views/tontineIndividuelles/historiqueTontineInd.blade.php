@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Historique des tontines individuelles</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="../../index.php">Acceuil</a>
          </li>
          <li class="breadcrumb-item active">Historique</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <!-- Contenue de la page -->
    <div class="container">
        <form action="{{ route('searchHistoriqueTontineInd') }}" method="post">
            @csrf
            <div class="row mb-2">
                <div class="col">
                    <select name="periode" id="" class="form-select border-secondary">
                        <option value="">Choisir une periode</option>
                        <option value="date_unique">Une date</option>
                        <option value="plage_dates">Plages de date</option>
                        <option value="annee">Annee</option>
                        <option value="mois">Mois</option>
                    </select>
                </div>
                <div class="col">
                    <input type="date" name="date1" id="" class="form-control border-secondary">
                </div>
                <div class="col">
                    <input type="date" name="date2" id="" class="form-control border-secondary">
                </div>
                <div class="col">
                    <select name="mois" id="mois" class="form-select border-secondary">
                        <option value="">Choisissez le mois</option>
                        <option value="01">Janvier</option>
                        <option value="02">Fevrier</option>
                        <option value="03">Mars</option>
                        <option value="04">Avril</option>
                        <option value="05">Mai</option>
                        <option value="06">Juin</option>
                        <option value="07">Juillet</option>
                        <option value="08">Aout</option>
                        <option value="09">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Decembre</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" name="annee" class="form-control border-secondary" placeholder="Saisissez l'annee">
                </div>

            </div>
            <div class="row">

                <div class="col">
                  <select name="choix" id="sldTontineCours" class="form-select border-secondary">
                      <option value="" selected>Choisir une option</option>
                      <option value="identifiant">Identifiant</option>
                      <option value="nom">nom</option>
                      <option value="montant">Montant</option>
                      <option value="membre">Membre</option>
                      <option value="agent">Agent</option>
                      <option value="statut">Statut</option>
                  </select>
                </div>
                <div class="col">
                  <input type="text" name="txtRecherche" class="form-control border-secondary" placeholder="Saisissez votre text de recherche">
                </div>
                <div class="col">
                  <button type="submit" class="form-control border-secondary bg-warning-light">
                    <i class="bi bi-filter"></i>Filtrer
                  </button>
                </div>
                <div class="col">
                  <button type="submit" class="form-control border-secondary bg-warning-light">
                    <i class="bi bi-arrow-repeat"></i>Actualiser
                  </button>
                </div>

                <div class="col">
                  <button type="button" id="btnPrint" class="form-control border-secondary bg-warning-light">
                    <i class="bi bi-printer"></i>Imprimer
                  </button>
                </div>
              </div>

              <!-- Partie du tableau -->
              <div class="row mt-3">
                <table id="tableAffichageCoti" class="text-center table table-bordered table-responsive table-compressed table-hover table-striped">
                  <thead class="bg-success">
                     <tr class="bg-success">
                           <th class="text-center bg-success text-white">N°</th>
                           <th class="text-center bg-success text-white">Identifiant</th>
                           <th class="text-center bg-success text-white">Nom</th>
                           <th class="text-center bg-success text-white">Date de debut</th>
                           <th class="text-center bg-success text-white">Montant</th>
                           <th class="text-center bg-success text-white">Membre</th>
                           <th class="text-center bg-success text-white">Agent</th>
                           <th class="text-center bg-success text-white">Cotisations</th>
                           <th class="text-center bg-success text-white">Total</th>
                           <th class="text-center bg-success text-white">Statut</th>
                           <th class="text-center bg-success text-white noPrint">Voir</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($tontines as $tontine)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>{{ $tontine->codeTontineI }}</td>
                            <td>{{ $tontine->nomTontineI }}</td>
                            <td>{{ $tontine->debutTontineI }}</td>
                            <td>{{ $tontine->montantTontineI }}</td>
                            <td>{{ $tontine->membres->nomMembre.' '.$tontine->membres->prenomMembre }}</td>
                            <td>{{ $tontine->agents->nomAgent.' '.$tontine->agents->prenomAgent }}</td>
                            <td>{{ count($tontine->cotisations) }}</td>
                            <td>{{ $tontine->cotisations->sum('montantCotisation') }}</td>
                            <td>
                                @if ($tontine->statutTontinteI === null)
                                    Non debuté
                                    @elseif ($tontine->statutTontinteI === 1)
                                    En cours
                                    @elseif ($tontine->statutTontinteI === 0)
                                    Terminé
                                @endif
                            </td>
                            <td class="btnCoti noPrint">
                                <a href='#'  class='btn btn-transparent voirTontineI' data-id = {{ $tontine->id }}  data-bs-toggle='modal' data-bs-target='#modalvoirTontineI' data-bs-placement='bottom' title='Voir'><i class='bi bi-eye'></i></a>
                            </td>
                        </tr>
                    @endforeach

                  </tbody>
              </table>
              </div>
        </form>
    </div>



   <!-- Debut Modal pour Voir le suivi -->
   <div class="modal fade" id="modalvoirTontineI" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <h3 class="text-center">Suivie de cette tontine</h3>

        <div class="row ms-2">
            <div class="col-4 fw-bold ">Numero: <span id="numeroTontine" class="resultText"> </span></div>
            <div class="col-8 fw-bold ">Nom Tontine: <span id="nomTontine" class="resultText"> </span></div>
        </div>

        <div class="row ms-2">
            <div class="col-4 fw-bold  ">Nom: <span id="nomMembre" class="resultText"> </span></div>
            <div class="col-8 fw-bold">Prenom: <span id="prenomMembre" class="resultText"> </span></div>
        </div>

        <div class="row ms-2">
            <div class="col-4 fw-bold ">Adresse: <span id="adresseTontine" class="resultText"> </span></div>
            <div class="col-8 fw-bold">Telephone: <span id="telTontine" class="resultText"> </span></div>
        </div>

        <div class="row ms-2">
            <div class="col-4 fw-bold ">Montant: <span id="montantTontine" class="resultText"> </span> FG</div>
            <div class="col-8 fw-bold">Montant deposé: <span id="montantDepose" class="resultText"> </span> FG</div>
        </div>

        <div class="row ms-2">
            <div class="col-4 fw-bold ">Effectuées: <span id="cotisationEffectuee" class="resultText"> </span></div>
            <div class="col-8 fw-bold">Restants: <span id="resteAEffectuee" class="resultText"> </span></div>
        </div>

        <section id="case" class="blocCase">
            @for ($i = 0; $i < 30; $i++)
                <div class="case"></div>
            @endfor
        </section>

        <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
        </div>
    </div>
    </div>
</div>
<!-- Fin modal pour voir suivi -->

</main>
<!-- Fin du main -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
   $(document).ready(function () {

        $('.voirTontineI').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Faire une requête Ajax pour obtenir les informations de cotisations
            $.ajax({
                type: 'GET',
                url: '{{  route('TontineIndividuelle.info', ['id' => ':id']) }}'.replace(':id', id),
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    // Assurez-vous que les données sont correctement formatées
                    var tontine = data.tontine;
                    var cotisations = data.cotisations;
                    var sommeMontantCotisations = data.sommeMontantCotisations;
                    var nombreCotisationEffetues = data.nombreCotisationEffetues;
                    // Traitez les données comme nécessaire et mettez à jour le modal
                    if (tontine) {
                        $('#numeroTontine').text(tontine.codeTontineI);
                        $('#nomTontine').text(tontine.nomTontineI);
                        $('#nomMembre').text(tontine.membres.nomMembre);
                        $('#prenomMembre').text(tontine.membres.prenomMembre);
                        $('#adresseTontine').text(tontine.membres.adresseMembre);
                        $('#telTontine').text(tontine.membres.telMembre);

                        // Accédez aux informations de la tontine
                        $('#montantTontine').text(tontine.montantTontineI);
                        $('#montantDepose').text(sommeMontantCotisations);
                        $('#cotisationEffectuee').text(nombreCotisationEffetues);
                        $('#resteAEffectuee').text(30-nombreCotisationEffetues);

                        for (var i = 0; i < 30; i++) {
                            var caseElement = $('#case .case').eq(i);
                            if (i < nombreCotisationEffetues) {
                                caseElement.addClass('case-effectuee');
                            } else {
                                caseElement.removeClass('case-effectuee');
                            }
                        }
                        // Afficher le modal
                        $('#modalvoirTontineI').modal('show');
                    } else {
                        // Aucune tontine trouvée, gérer cela en conséquence
                        console.log('Aucune Tontine trouvée');
                    }
                },
                error: function (error) {
                    console.log(error);
                    // Gérer les erreurs
                }
            });
        });

        // La fonction pour imprimer le tableau
        $('#btnPrint').click(function (e) {
            e.preventDefault();
            // Récupérer le titre saisi par l'utilisateur
            var titre = prompt('Entrer le titre de la page! ');
            var date = new Date().toLocaleDateString();
            // Créer une nouvelle fenêtre pour l'impression
            var printWindow = window.open('', '', 'width=600,height=600');

            // Contenu à imprimer
            var content = `
                <html>
                    <head>
                        <title>Impression</title>
                        <link
                            href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}"
                            rel="stylesheet" />

                        <style>
                            body{
                                margin-left: 30px;
                                margin-right: 30px;
                              }
                            /* ... autres styles ... */

                            .noPrint{
                                display: none;
                            }
                        </style>
                    </head>
                    <body onload="window.print()">
                        <div class="row mt-4">
                            <div class="col">
                                <img src="{{ asset('assets/img/yetemali.jpg') }}" alt="" height="150" width="150">
                            </div>
                            <div class="col"></div>
                            <div class="col fw-bold fs-3 text-center">
                                <p class="text-center fw-1">
                                    Caisse Populaire d'Epargne et de Crédit de Guinée (CPECG)
                                 </p>
                               Le ${date}
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <h2>${titre}</h2>
                            <!-- Ajoutez ici le logo de l'entreprise -->
                            <!-- Ajoutez ici la date -->
                        </div>
                        <table>
                            ${document.getElementById('tableAffichageCoti').outerHTML}
                        </table>

                        <div class="row mt-3">
                            <div class="col">
                            </div>
                            <div class="col"></div>
                            <div class="col fw-bold fs-3 text-center">
                                Le Directeur
                            </div>
                        </div>
                    </body>
                </html>
            `;

            // Injecter le contenu dans la fenêtre d'impression
            printWindow.document.open();
            printWindow.document.write(content);
            printWindow.document.close();
        });
   });
</script>


