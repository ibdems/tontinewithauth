@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Liste des Cotisations</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
        <li class="breadcrumb-item">Cotisations</li>
        <li class="breadcrumb-item active">Liste</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

    <div class="container">
        <div class="row">
            <div class="col messages">
                @if(Session::has('success'))
                    <div class="alert alert-success text-center fw-bold fs-24">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

        </div>
        <div class="row ">
            <form action="" class="form-inline bg-light">
                  <div class="row">

                    <div class="col-sm">
                          <div class="col">
                            <label for="">Selectionner la tontine</label>
                            <div class="input-group">
                                <input type="text" id="searchTontine" class="form-control border-secondary" placeholder="saisissez le nom de la cotisation">
                                <select name="tontine" id="tontine"  class="form-select border-secondary">
                                    <option value="">Choisir la cotisation</option>
                                    @foreach ($tontinesI as $tontines )
                                        <option value="{{ $tontines->id }}">{{ $tontines->nomTontineI.' ('.$tontines->codeTontineI.')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                    </div>

                    <div class="col-sm-2 ">
                        <label for="">Cliquez pour afficher</label>
                        <button id="btnAfficheCoti" type="button" class="form-control bg-warning-light text-center">
                            <i class="bi bi-list"></i>Afficher
                        </button>
                    </div>

                    <div class="col-sm"></div>
                  </div>


                  <div class="row mt-3 acacher">

                      <div class="col-sm">
                          <div class="form-group">
                          <label for="">Rechercher une date</label>
                          <input type="date" name="dateRecherche" id="dateRecherche" class="form-control" id="">
                          </div>
                      </div>
                      <div class="col-sm">
                        <div class="form-group">
                            <label for="form-label" class="text-white">Filtrer</label>
                            <button id="btnSearchCoti" type="button" class="form-control bg-warning-light text-center">
                                <i class="bi bi-filter"></i>Filtrer
                            </button>
                        </div>
                      </div>
                      <div class="col-sm ">
                        <label for="form-label" class="text-white">Acutaliser</label>
                        <button id="btnActualiseCoti" type="button" class="form-control bg-warning-light text-center">
                            <i class="bi bi-repeat"> </i>Actualiser
                        </button>
                      </div>
                      <!-- Colonne pour bouton ajouter -->
                      <div class="col-sm ">
                        <div class="form-group">
                            <label for="form-label" class="text-white">Nouveau</label>
                            <button id="btnNewCoti" type="button" class=" bg-warning-light text-center form-control"  data-bs-toggle="modal" data-bs-target="#modalAjoutCotisation">
                              <i class="bi bi-plus"></i>Nouveau
                              </button>
                        </div>
                      </div>
                      <!-- Fin pour ajouter  -->
                      <div class="col-sm ">
                        <label for="form-label" class="text-white">Imprimer</label>
                        <button id="btnPrintCoti" type="button" class=" form-control bg-warning-light text-center">
                            <i class="bi bi-printer"></i>Imprimer
                        </button>
                      </div>
                  </div>

            </form>
         </div>
        <div id="blocTable" class="row mt-3 acacher">
            <!-- Table -->
             <table id="tableAffichageCoti" class="table text-center table-bordered table-responsive table-compressed table-hover table-striped">
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
                <tbody id="tbodyAfficheTontine">

                </tbody>
            </table>
            <!-- End Table  -->
        </div>

    </div>

     <div class="modal fade" id="modalAjoutCotisation" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header text-center">
                        <h2 class="text-center">Ajout d'une cotisation</h2>
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
                        <form method="post" action="{{ route('StoreCotisation') }}">
                            @csrf


                            <div class="row mb-4">
                                <label class="col fs-5 ms-3">Membre</label>
                                <div class="row">
                                      <div class="ms-3 input-group">
                                            <input type="text" id="searchMembre" class="form-control border-secondary" placeholder="Rechercher un menbre" >
                                            <select name="membre" id="membre" class="form-select border-secondary" aria-label="Default select example">
                                                <option value="0" selected>Cliquez pour choisir</option>
                                                @foreach ($membres as  $membre)
                                                    <option value="{{ $membre->id }}">{{ $membre->nomMembre.' '.$membre->prenomMembre.' ('.$membre->codeMembre.')' }}</option>
                                                @endforeach

                                            </select>
                                      </div>
                                </div>

                            </div>

                            <div class="row mb-4">
                              <label class="col fs-5 ms-3">Tontine</label>
                              <div class="row">
                                <div class="input-group ms-3">
                                    <input type="text" id="searchTontineA" class="form-control border-secondary " placeholder="Rechercher une tontine">
                                    <select name="tontine" class="form-select border-secondary" aria-label="Default select example">
                                        <option value="" selected>Cliquez pour choisir</option>

                                    </select>
                                </div>
                              </div>

                            </div>


                                <div class="row mb-4">

                                  <div class="col ms-3" style="margin-right: 10px">
                                    <label for="inputDate" class="  text-center fs-5">Date</label>
                                    <input name="debut" id="debut"  type="date" class="form-control border-secondary">

                                  </div>
                                </div>



                              <div class="row mb-4">
                                  <div class="col"></div>
                                  <div class="col">
                                    <button name="btnValider" type="submit" class="btn btn-success form-control">Valider</button>
                                  </div>
                                  <div class="col">
                                  <button id="annullee" type="button" class="btn btn-danger form-control">Annullée</button>
                                  </div>
                                  <div class="col"></div>
                              </div>

                        </form><!-- End General Form Elements -->


                    </div>
            </div>
        </div>
     </div>

</main>
<!-- Fin du main -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>

    $(document).ready(function () {


        $('.acacher').hide();
        //Fuction pour la recherche du tontine
        function updateSelectOptions(searchInput, selectElement) {
            var searchTerm = searchInput.val().toLowerCase();
            selectElement.find('option').each(function () {
                var optionText = $(this).text().toLowerCase();
                if (optionText.includes(searchTerm)) {
                    $(this).show();

                } else {
                    $(this).hide();
                }
            });
        }

        //Utlisation de la function de trie dans le champ de recherche
        $('#searchTontine').on('input', function () {
            updateSelectOptions($(this), $('select[name="tontine"]'));
        });

        $('#searchTontineA').on('input', function () {
            updateSelectOptions($(this), $('select[name="tontine"]'));
        });

        $('#searchMembre').on('input', function () {
            updateSelectOptions($(this), $('select[name="membre"]'));
        });

        // Fonction pour afficher les cotisations a travers une fonction ajax
        function afficheCotisation(){
            // Action pour afficher les cotisations en fonction de la tontine choisi
            $tontineId = $('#tontine').val();
                $.ajax({
                    type: "Post",
                    url: "{{ route('cotisationByTontine') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        tontine: $tontineId
                    },
                    success: function (response) {
                         // Effacer le contenu actuel du tableau
                        $('#tableAffichageCoti tbody').empty();

                        // Parcourir les données JSON et ajouter des lignes au tableau
                        $.each(response.cotisations, function (index, cotisation) {
                            var cotisationHtml = '<tr>';
                            cotisationHtml += '<td>' + (index + 1) + '</td>';
                            cotisationHtml += '<td>' + cotisation.codeCotisation + '</td>';
                            cotisationHtml += '<td>' + cotisation.tontines.nomTontineI + '</td>';
                            cotisationHtml += '<td>' + cotisation.membres.nomMembre + ' ' + cotisation.membres.prenomMembre + ' (' + cotisation.membres.codeMembre + ') ' +'</td>';
                            cotisationHtml += '<td>' + cotisation.montantCotisation + '</td>';
                            cotisationHtml += '<td>' + cotisation.dateCotisation + '</td>';
                            cotisationHtml += '</tr>';

                            // Ajouter la ligne au tableau
                            $('#tableAffichageCoti tbody').append(cotisationHtml);
                        });
                    }
                });
                // Fin de la fonction Ajax
        }

        // Aficher le tableau au click du bouton afficher
        $('#btnAfficheCoti').click(function (e) {
            e.preventDefault();
            afficheCotisation();
            $('.acacher').show();
        });

        // Actualiser le tableau au click du bouton actualiser
        $('#btnActualiseCoti').click(function (e) {
            e.preventDefault();
            afficheCotisation();
        });


        // Action sur le bouton filtrer pour rechercher en fonction du date
        $('#btnSearchCoti').click(function (e) {
            e.preventDefault();
            var $date = $('#dateRecherche').val();
            $.ajax({
                    type: "Post",
                    url: "{{ route('searchDate') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        dateRecherche: $date
                    },
                    success: function (response) {
                        alert('succes')
                        if (response.cotisations && response.cotisations.length > 0) {
                            // Effacer le contenu actuel du tableau
                            $('#tableAffichageCoti tbody').empty();

                            // Parcourir les données JSON et ajouter des lignes au tableau
                            $.each(response.cotisations, function (index, cotisation) {
                                var cotisationHtml = '<tr>';
                                cotisationHtml += '<td>' + (index + 1) + '</td>';
                                cotisationHtml += '<td>' + cotisation.codeCotisation + '</td>';
                                cotisationHtml += '<td>' + cotisation.tontines.nomTontineI + '</td>';
                                cotisationHtml += '<td>' + cotisation.membres.nomMembre + ' ' + cotisation.membres.prenomMembre + ' (' + cotisation.membres.codeMembre + ') ' +'</td>';
                                cotisationHtml += '<td>' + cotisation.montantCotisation + '</td>';
                                cotisationHtml += '<td>' + cotisation.dateCotisation + '</td>';
                                cotisationHtml += '</tr>';

                                // Ajouter la ligne au tableau
                                $('#tableAffichageCoti tbody').append(cotisationHtml);
                            });
                        }
                        else {
                            $('#tableAffichageCoti tbody').empty();
                        }
                    },

                });

        });

        // La fonction pour afficher les tontines au changement du membre
        $('#membre').on('change', function() {
            var selectedMembreId = $(this).val();

            // Effectuez une requête AJAX pour obtenir les données de la tontine individuelle
            $.ajax({
                url: "{{ route('getTontineIndividuelle') }}", // Remplacez 'getTontineIndividuelle' par le nom de votre route Laravel
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    membre: selectedMembreId
                },
                success: function(response) {
                    $('select[name="tontine"]').empty();

                    // Ajoutez une option par défaut
                    $('select[name="tontine"]').append($('<option>', {
                        value: '',
                        text: 'Cliquez pour choisir'
                    }));

                    // Ajoutez les options pour chaque tontine individuelle
                    response.tontineData.forEach(function(tontine) {
                        $('select[name="tontine"]').append($('<option>', {
                            value: tontine.id,
                            text: tontine.nomTontineI + ' (' + tontine.codeTontineI + ')'
                        }));
                    });
                },
                error: function() {
                    alert('Une erreur s\'est produite lors de la récupération des données de la tontine individuelle.');
                }
            });
        });

        // l'action sur le bouton imprimer
        // La fonction pour imprimer le tableau
        $('#btnPrintCoti').click(function (e) {
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





