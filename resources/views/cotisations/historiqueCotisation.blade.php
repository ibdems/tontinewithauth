@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Historique des Cotisation</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
        <li class="breadcrumb-item">Cotisations</li>
        <li class="breadcrumb-item active">Historique</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
      <div class="container mt-5">
      <div class="row">

        <form method="POST" action="{{ route('searchHistorique') }}" class="form-inline bg-light">
            @csrf
            {{-- Recherche periodique --}}
            <div class="row mb-2">
                <div class="col">
                    <select name="periode" id="periode" class="form-select border-secondary">
                        <option value="">Choisir une periode</option>
                        <option value="date_unique">Une date</option>
                        <option value="plage_dates">Plages de date</option>
                        <option value="annee">Annee</option>
                        <option value="mois">Mois</option>
                    </select>
                </div>
                <div class="col">
                    <input type="date" name="date1" id="date1" class="form-control border-secondary">
                </div>
                <div class="col">
                    <input type="date" name="date2" id="date2" class="form-control border-secondary">
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
                    <input type="text" name="annee" id="annee" class="form-control border-secondary" placeholder="Saisissez l'annee">
                </div>

            </div>
            <div class="row mt-3">
                  <div class="col">
                    <select name="choix" id="" class="form-select border-secondary">
                      <option value="" selected>Choisir l'option</option>
                      <option value="identifiant">Identifiant</option>
                      <option value="tontine">Tontine</option>
                      <option value="membre">Membre</option>
                    </select>
                  </div>
                  <div class="col">
                    <input type="text" name="txtRecherche" class="form-control border-secondary" placeholder="Saisissez">
                  </div>
                  <div class="col">
                      <button id="btnSearchCoti" type="submit" class=" bg-warning-light form-control border-secondary ">
                          <i class="bi bi-filter"></i> Filtrer
                      </button>
                  </div>
                  <div class="col">
                    <a href="{{ route('historiqueCotisation') }}">
                        <button id="btnSearchCoti" type="submit" class=" bg-warning-light form-control border-secondary ">
                            <i class="bi bi-repeat"></i> Acutaliser
                        </button>
                    </a>
                  </div>
                  <div class="col">
                    <button id="btnPrintCotiHistorique" type="button" class=" form-control bg-warning-light text-center border-secondary">
                        <i class="bi bi-printer"></i> Imprimer
                    </button>
                  </div>
            </div>

            <div class="row mt-3">
                <!-- Table -->
                <table id="tableHistoriqueCoti" class="table text-center table-bordered table-responsive table-compressed table-hover table-striped">
                  <thead class="bg-success">
                      <tr class="bg-success">
                            <th class="text-center bg-success text-white">N°</th>
                            <th class="text-center bg-success text-white">Code</th>
                            <th class="text-center bg-success text-white">Tontine</th>
                            <th class="text-center bg-success text-white">Membre</th>
                            <th class="text-center bg-success text-white">Montant</th>
                            <th class="text-center bg-success text-white">Date</th>

                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($cotisations as $cotisation )
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $cotisation->codeCotisation }}</td>
                              <td>{{ $cotisation->tontines->nomTontineI. ' ('.$cotisation->tontines->codeTontineI .')'  }}</td>
                              <td>{{ $cotisation->membres->nomMembre. ' '. $cotisation->membres->prenomMembre. ' ('.$cotisation->membres->codeMembre .')'  }}</td>
                              <td>{{ $cotisation->montantCotisation }}</td>
                              <td>{{ $cotisation->dateCotisation }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
                    <!-- End Table  -->


          </div>

        </form>


    </div>

      </div>
</main>
<!-- Fin du main -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
       $('#periode').change(function (e) {
            e.preventDefault();
            let valeur = $('#periode').val();

            switch(valeur){
                case "date_unique" :
                    $('#date2').prop('disabled', true);
                    break;
                case "plage_dates" :
                    $('#annee').prop('disabled', true);
                    $('#mois').prop('disabled', true);
                    $('#date2').prop('disabled', false);
                    break;
                default:
                    $('#date2').prop('disabled', false);
                    $('#annee').prop('disabled', false);
                    $('#mois').prop('disabled', false);
                    break;


            }
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
                            ${document.getElementById('tableHistoriqueCoti').outerHTML}
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






