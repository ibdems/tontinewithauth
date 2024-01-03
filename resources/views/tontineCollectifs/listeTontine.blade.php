@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Liste des tontines</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{route('acceuil')}}">Acceuil</a>
          </li>
          <li class="breadcrumb-item active">Liste des tontines non terminés</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <!-- Contenue de la page -->
    <div class="container mt-4">
        <div class="row mb-4">

            <div class="col">
                <a href="{{ route('ajoutTontine') }}">
                    <button name="afficher" type="submit" class="form-control fs-6 bg-success text-white">Organiser</button>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('gestionTontine') }}">
                    <button name="afficher" type="submit" class="form-control fs-6 bg-success text-white">Gerer</button>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('ajoutPayement.create') }}">
                    <button name="afficher" type="submit" class="form-control fs-6 bg-success text-white">Faire un versement</button>
                </a>
            </div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>

        </div>
        <form action="{{ route('searchTontineC') }}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                <div class="col messages">
                    @if(Session::has('success'))
                        <div class="alert alert-success text-center fw-bold fs-24">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if(Session::has('error'))
                        <div class="alert text-center alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert text-center alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col">
                <select name="choix" id="sldTontineCours" class="form-select border-secondary">
                    <option value="" selected>Choisissez l'option</option>
                    <option value="identifiant">Identifiant</option>
                    <option value="nom">Nom</option>
                    <option value="montant">Montant</option>
                    <option value="agent">Agent</option>
                </select>
            </div>
            <div class="col">
                <input name="txtRecherche" type="text" class="form-control border-secondary" placeholder="Saisissez votre text de recherche">
            </div>
            <div class="col">
                <button name="filtrer" type="submit" class="form-control border-secondary bg-warning-light">
                <i class="bi bi-filter"></i>Filtrer
                </button>
            </div>
            <div class="col">
                <a href="{{ route('listeTontine') }}">
                    <button name="actualiser" type="submit" class="form-control border-secondary bg-warning-light">
                        <i class="bi bi-arrow-repeat"></i>Actualiser
                    </button>
                </a>
            </div>
            <div class="col">
                <button  type="button" class="form-control border-secondary bg-warning-light"data-bs-toggle="modal" data-bs-target="#modalAjoutTontine">
                <i class="bi bi-plus"></i>Nouveau
                </button>
            </div>
            <div class="col">
                <button type="button" id="btnPrintTontine" class="form-control border-secondary bg-warning-light">
                <i class="bi bi-printer"></i>Imprimer
                </button>
            </div>
            </div>

            <!-- Partie du tableau -->
            <div class="row mt-3">
                <table id="tableAffichageCoti" class="table text-center table-bordered table-responsive table-compressed table-hover table-striped">
                    <thead class="bg-success">
                    <tr class="bg-success">
                            <th class="text-center bg-success text-white">N°</th>
                            <th class="text-center bg-success text-white">Identifiant</th>
                            <th class="text-center bg-success text-white">Nom</th>
                            <th class="text-center bg-success text-white">Date de debut</th>
                            <th class="text-center bg-success text-white">Montant</th>
                            <th class="text-center bg-success text-white">Frequence</th>
                            <th class="text-center bg-success text-white">Participants</th>
                            <th class="text-center bg-success text-white">Agent</th>
                            <th class="text-center bg-success text-white noPrint" colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyAfficheTontine">

                        @foreach ($tontines as $tontineC)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tontineC->codeTontineC }}</td>
                                <td>{{ $tontineC->nomTontineC }}</td>
                                <td>{{ $tontineC->debutTontineC }}</td>
                                <td>{{ $tontineC->montant }}</td>
                                <td>
                                    @if ($tontineC->frequence == 1)
                                        Jours
                                        @elseif ($tontineC->frequence == 7)
                                        Semaine
                                        @elseif ($tontineC->frequence == 30)
                                        Mois
                                        @else
                                        Annee
                                    @endif
                                </td>
                                <td>{{ $tontineC->nombreParticipant }}</td>
                                <td>{{ $tontineC->agents->nomAgent.' '.$tontineC->agents->prenomAgent }}</td>
                                <td class='btnCoti noPrint'><a  class='btn btn-transparent editTontineInd'  data-bs-toggle='modal' data-bs-target='#modalModifTontine' data-bs-placement='bottom' title='Modifier'><i class='bi bi-pen'></i></a></td>
                                <td class='btnCoti noPrint'><button type='button' class='btn btn-transparent suiviTontine' data-id= {{ $tontineC->id }} data-bs-toggle='modal' data-bs-target='#modalSuiviTontine' data-bs-placement='bottom' title='Voir'><i class='bi bi-eye'></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modalAjoutTontine" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-center py-4">
                        <a href="#" class="logo d-flex align-items-center w-auto">
                            <img src="{{ asset('assets/img/yetemali.jpg') }}" alt="">
                            <span class="d-none d-lg-block text-success">Yete</span>
                            <span class="d-none d-lg-block text-warning">mali</span>
                        </a>
                    </div>
                    <!-- General Form Elements -->
                    <div class="card rounded-4 mb-5">
                        <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Nouvelle Tontine Collective</h1>
                        <div class="card-body">

                          <!-- General Form Elements -->
                          <form method="post" action="{{ route('ajoutTontine') }}">
                            @csrf
                              <div class="form-group">
                                <div class="row">
                                  <div class="col"></div>
                                  <div class="col">

                                  </div>
                                  <div class="col"></div>
                                </div>
                                <div class="row mb-4">

                                 <div class="row mb-3">
                                    <div class="col">
                                        <label class="fs-5">Nom</label>
                                        <input name="nom" id="nom" type="text" class="form-control border-secondary" placeholder="Nom de la tontine">

                                    </div>
                                 </div>


                                  <div class="row mb-3">
                                    <div class="col">
                                        <label for="inputDate" class="fs-5">Debut</label>
                                        <input name="debut" id="debut"  type="date" class="form-control border-secondary">

                                      </div>
                                  </div>

                                  <div class="row mb-3">
                                    <div class="col">
                                        <label class="fs-5">Montant</label>
                                        <input name="montant" id="montant" type="number" class="form-control border-secondary" placeholder="Montant de la tontine">

                                      </div>
                                  </div>


                                  <div class="row mb-3">
                                    <div class="col">
                                        <label for="" class="fs-5">Frequence</label>
                                        <select name="frequence" id="frequence" class="form-select border-secondary">
                                          <option value="1" selected>Jours</option>
                                          <option value="7">Semaines</option>
                                          <option value="30">Mois</option>
                                          <option value="12">Annee</option>
                                        </select>

                                      </div>
                                  </div>

                              <div class="row">
                                <div class="col"></div>
                                <div class="col">
                                <button name="ajouter" type="submit" class="btn btn-success form-control">Ajouter</button>
                                </div>
                                <div class="col">
                                <button name="annuler" id="annuller" type="button" class="btn btn-secondary form-control">Annuler</button>
                                </div>
                                <div class="col"></div>
                              </div>



                          </form><!-- End General Form Elements -->

                        </div>
                      </div>

                </div>

            </div>
        </div>
     </div>
    </div>
    <!-- Fin Modal pour ajouter -->



</main>
<!-- Fin du main -->

  <!-- Debut modal pour Modification -->
  <div class="modal fade" id="modalModifTontine" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header text-center">
                <h1 class="text-center text-black fs-1 fw-3 bg-warning-light-light">Modification</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-center py-4">
                        <a href="#" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('assets/img/yetemali.jpg') }}" alt="">
                        <span class="d-none d-lg-block text-success">Yete</span>
                        <span class="d-none d-lg-block text-warning">mali</span>
                        </a>
                    </div>
                    <!-- General Form Elements -->
                    <!-- Partie de l'ajout -->
                    <div class="card rounded-4">

                    <div class="card-body">

                        <!-- General Form Elements -->
                        <form method="post" action="{{ route('updateTontineC') }}">
                            @csrf
                            <div class="form-group">

                                <div class="row mb-4">
                                    <input type="hidden" name="code" id="code">

                                    <div class="col">
                                    <label class="fs-5">Nom</label>
                                    <input name="nom" id="mNom" type="text" class="form-control border-secondary" placeholder="Nom de la tontine">
                                    </div>

                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <label for="inputDate" class="fs-5">Debut</label>
                                        <input name="debut" id="mDebut"  type="date" class="form-control border-secondary">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                    <label class="fs-5">Montant</label>
                                    <input name="montant" id="mMontant" type="number" class="form-control border-secondary" placeholder="Montant de la tontine">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <label for="" class="fs-5">Frequence</label>
                                        <select name="frequence" id="mfrequence" class="form-select border-secondary">
                                            <option value="1" selected>Jours</option>
                                            <option value="7">Semaines</option>
                                            <option value="30">Mois</option>
                                            <option value="12">Annee</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning boutton">Valider</button>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </form><!-- End General Form Elements -->

                    </div>
                    </div>

                </div>

        </div>
    </div>
  </div>
  <!-- Fin modal pour modification -->

  <!-- Debut Modal pour Voir le suivi -->
    <div class="modal fade" id="modalSuiviTontine" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h3 class="text-center">Suivie de cette Tontine</h3>
                <div class="row ms-2">
                    <div class="col-4 fw-bold ">Numero: <span id="numeroTontine" class="resultText"> </span></div>
                    <div class="col-8 fw-bold ">Nom Tontine: <span id="nomTontine" class="resultText"> </span></div>
                </div>

                <div class="row ms-2">
                    <div class="col-4 fw-bold  ">Date: <span id="dateTontine" class="resultText"> </span></div>
                    <div class="col-8 fw-bold">Montant: <span id="montantTontine" class="resultText"> </span></div>
                </div>

                <div class="row ms-2">
                    <div class="col-4 fw-bold ">Frquence: <span id="frequenceTontine" class="resultText"> </span></div>
                    <div class="col-8 fw-bold">Participants: <span id="participantTontine" class="resultText"> </span></div>
                </div>

                <div class="row ms-2">
                    <div class="col-4 fw-bold ">Statut: <span id="statutTontine" class="resultText"> </span> </div>
                    <div class="col-8 fw-bold">Total à prendre: <span id="montantprendre" class="resultText"> </span> </div>
                </div>

                <div class="row ms-2">
                    <div class="col-4 fw-bold ">Ont pris: <span id="prisTontine" class="resultText"> </span> </div>
                    <div class="col-8 fw-bold">Restant: <span id="restantTontine" class="resultText"> </span> </div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                         <canvas id="pieChart" class="text-center" style="width: 300px; height: 300px;"></canvas>
                    </div>
                    <div class="col"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
<!-- Fin modal pour voir suivi -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var tableAffichageCoti = document.getElementById('tableAffichageCoti');

        function editerTontineI() {
            for (var i = 0; i < tableAffichageCoti.rows.length; i++) {
              tableAffichageCoti.rows[i].onclick = function () {
                    document.getElementById("code").value = this.cells[1].innerHTML;
                    document.getElementById("mNom").value = this.cells[2].innerHTML;
                    document.getElementById("mDebut").value = this.cells[3].innerHTML;
                    document.getElementById("mMontant").value = this.cells[4].innerHTML;
                    document.getElementById("mfrequence").value = this.cells[5].innerHTML;



                    // Sélectionnez la valeur de la cellule "Frequence"
                    var frequenceText = this.cells[5].innerHTML.trim();

                    // Sélectionnez le champ de sélection "mfrequence"
                    var selectFrequence = document.getElementById("mfrequence");

                    // Parcourez les options du champ de sélection
                    for (var j = 0; j < selectFrequence.options.length; j++) {
                        var optionValue = selectFrequence.options[j].value;
                        if (optionValue.toLowerCase() === frequenceText.toLowerCase()) {
                            // Si la valeur de l'option correspond à la cellule "Frequence", définissez cette option comme sélectionnée
                            selectFrequence.value = optionValue;
                            break; // Sortez de la boucle dès que la correspondance est trouvée
                        }
                    }
                };
            }
        }


      $('.editTontineInd').click(function (e) {
          e.preventDefault();
          editerTontineI();
      });

      //Evenement pour la suivie de la tontine
      $('.suiviTontine').click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: ' {{ route('TontineCollective.info', ['id' => ':id']) }}'.replace(':id', id),
                data: {
                    _token: '{{ csrf_token() }}',
                },

                success: function (data) {
                    var tontine = data.tontine;
                    var numPayments = data.numPayments;
                    var resteAprendre = data.resteAprendre;
                    var montantTotal = data.montantTotal;
                    var totalParticipants = numPayments + resteAprendre;

                    if(tontine){
                         // Recalcul des pourcentages en fonction des participants ayant pris et de ceux qui n'ont pas pris
                            var prisPercentage = (numPayments / totalParticipants) * 100;
                            var restantPercentage = (resteAprendre / totalParticipants) * 100;

                        $('#numeroTontine').text(tontine.codeTontineC);
                        $('#nomTontine').text(tontine.nomTontineC);
                        $('#dateTontine').text(tontine.debutTontineC);
                        $('#montantTontine').text(tontine.montant);
                        var frequence = tontine.frequence;
                        var statut = tontine.statutTontineC;
                        if(frequence == 1){
                            $('#frequenceTontine').text('Jour');
                        }else if(frequence == 7){
                            $('#frequenceTontine').text('Semaine');
                        }else if(frequence == 12){
                            $('#frequenceTontine').text('Année');
                        }else if(frequence == 30){
                            $('#frequenceTontine').text('Mois');
                        }

                        if(statut === null){
                            $('#statutTontine').text('Non debuté');
                        }else if(statut === 1){
                            $('#statutTontine').text('En cours');
                        }else if (statut === 0){
                            $('#statutTontine').text('Terminé');
                        }
                        $('#participantTontine').text(tontine.nombreParticipant);
                        $('#prisTontine').text(numPayments);
                        $('#restantTontine').text(resteAprendre);
                        $('#montantprendre').text(montantTotal);

                        var pieChart = document.getElementById('pieChart').getContext('2d');

                         // Détruire le graphique existant s'il y en a un
                        if (window.myChart) {
                            window.myChart.destroy();
                        }

                        // Créez un graphique circulaire
                        window.myChart = new Chart(pieChart, {
                            type: 'doughnut',
                            data: {
                                labels: ['Pris', 'Restant'],
                                datasets: [{
                                    label: 'Participants',
                                    data: [numPayments, resteAprendre],
                                    backgroundColor: [
                                        '#1f6f20e9', // Vert pour ceux qui ont pris
                                        'yellow' // Jaune pour ceux qui restent à prendre
                                    ],
                                    borderColor: [
                                        '#1f6f20e9',
                                        'yellow'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: false,
                                maintainAspectRatio: false,
                            }
                        });
                    }

                    // Obtenez le contexte du canevas

                }
            });
      });




       // La fonction pour imprimer le tableau
        $('#btnPrintTontine').click(function (e) {
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


