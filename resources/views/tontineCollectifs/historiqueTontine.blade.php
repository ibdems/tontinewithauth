@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Historique des Tontines</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('acceuil')}}">Accueil</a></li>
        <li class="breadcrumb-item">Tontine</li>
        <li class="breadcrumb-item active">Historique</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
      <div class="container mt-5">
      <div class="row">
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
        <form action="{{ route('searchHistoriqueTontineC') }}" method="POST" class="form-inline bg-light">
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
            <div class="row mt-3">

                  <div class="col">
                    <select name="choix" id="" class="form-select border-secondary">
                      <option value="" selected>Choisissez</option>
                      <option value="identifiant">Identifiant</option>
                      <option value="nom">Nom</option>
                      <option value="agent">Agent</option>
                      <option value="statut">Statut</option>

                    </select>
                  </div>
                  <div class="col">
                    <input type="text" name="txtRecherche" class="form-control border-secondary" placeholder="Saisissez">
                  </div>
                  <div class="col">
                      <button id="btnSearchCoti" type="submit" class=" bg-warning-light form-control">
                          <i class="bi bi-filter"></i> Filtrer
                      </button>
                  </div>
                  <div class="col">
                    <button id="btnSearchCoti" type="submit" class=" bg-warning-light form-control">
                        <i class="bi bi-repeat"></i> Acutaliser
                    </button>
                  </div>
                  <div class="col">
                    <button id="btnPrintCotiHistorique" type="button" class=" form-control bg-warning-light text-center">
                        <i class="bi bi-printer"></i> Imprimer
                    </button>
                  </div>
            </div>
            <div class="row mt-3">
                <table id="tableHisotoriqueTontine" class="table text-center table-bordered table-responsive table-compressed table-hover table-striped">
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
                             <th class="text-center bg-success text-white">Statut</th>
                             <th class="text-center bg-success text-white noPrint">Voir</th>
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
                                <td>
                                    @if ($tontineC->statutTontineC === null)
                                            Non debuté
                                            @elseif ($tontineC->statutTontineC === 1)
                                            En cours
                                            @elseif ($tontineC->statutTontineC === 0)
                                            Terminé
                                     @endif
                                </td>
                                <td class='btnCoti noPrint'><button type='button' class='btn btn-transparent suiviTontine' data-id= {{ $tontineC->id }} data-bs-toggle='modal' data-bs-target='#modalSuiviTontine' data-bs-placement='bottom' title='Voir'><i class='bi bi-eye'></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>


    </div>

      </div>
</main>
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
        $('#btnPrintCotiHistorique').click(function (e) {
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
                            ${document.getElementById('tableHisotoriqueTontine').outerHTML}
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



