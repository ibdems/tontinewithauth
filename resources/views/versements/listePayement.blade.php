@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
    <div class="pagetitle">
      <h1>Historique des Versement</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
          <li class="breadcrumb-item">Versement</li>
          <li class="breadcrumb-item active">Historique</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

            <div class="row">
                <div class="row">
                    <div class="col">
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
                  </div>
                    <form action="{{ route('searchVersement') }}" method="post" class="form-inline bg-light">
                        @csrf
                        <div class="row mt-2">
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

                          <div class="col-sm">
                            <div class="form-group">
                             <label for=""></label>
                             <select name="choix" id="" class="form-select border-secondary">
                                <option value="" selected>Choisissez l'option</option>
                                <option value="identifiant">Identifiant</option>
                                <option value="tontine">Tontine</option>
                                <option value="membre">Membre</option>
                                <option value="montant">Montant</option>
                             </select>
                            </div>
                           </div>
                           <div class="col-sm">
                               <div class="form-group">
                                <label for=""></label>
                                <input name="txtRecherche" type="text" class="form-control bi bi-search border-secondary" id="txtRechercheCoti">
                               </div>
                            </div>
                           <div class="col-sm">
                              <div class="form-group">
                                  <label for="form-label"></label>
                                  <button name="filtrer" type="submit" class="form-control bg-warning-light text-center border-secondary">
                                     <i class="bi bi-filter"></i>Filtrer
                                  </button>
                              </div>
                           </div>
                           <div class="col-sm ">
                              <label for=""></label>
                              <button name="actualiser" type="submit" class="form-control bg-warning-light text-center">
                                 <i class="bi bi-repeat">Actualiser</i>
                              </button>
                            </div>
                           <!-- Colonne pour bouton ajouter -->
                           <div class="col-sm ">
                              <div class="form-group">
                                  <label for=""></label>
                                  <button id="btnNewCoti" type="button" class="bg-warning-light text-center form-control"  data-bs-toggle="modal" data-bs-target="#modalAjoutPayement">
                                    <i class="bi bi-plus"></i>Nouveau
                                   </button>
                              </div>

                           </div>
                           <!-- Fin pour ajouter  -->
                           <div class="col-sm ">
                              <label for=""></label>
                              <button id="btnPrintCoti" type="button" class="btn  form-control bg-warning-light text-center">
                                 <i class="bi bi-printer"></i>Imprimer
                              </button>
                           </div>
                        </div>
                   </div>
        <div class="row mt-2">


             <!-- Table -->
             <table id="tableAffichageCoti" class=" text-center table table-bordered table-responsive table-compressed table-hover table-striped">
                <thead class="bg-success">
                   <tr class="bg-success">
                         <th class="text-center bg-success text-white">N°</th>
                         <th class="text-center bg-success text-white">Identifiant</th>
                         <th class="text-center bg-success text-white">Tontine</th>
                         <th class="text-center bg-success text-white">Membre</th>
                         <th class="text-center bg-success text-white">Montant</th>
                         <th class="text-center bg-success text-white">Date</th>

                   </tr>
                </thead>
                <tbody id="tbodyAfficheTontine">
                    @foreach ($versements as $versement )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $versement->codeVersement }}</td>
                            <td>{{ $versement->tontinesC->nomTontineC.' ('.$versement->tontinesC->codeTontineC.')' }}</td>
                            <td>{{ $versement->membres->nomMembre.' '.$versement->membres->prenomMembre }}</td>
                            <td>{{ $versement->montantVersement }}</td>
                            <td>{{ $versement->dateVersement }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                  <!-- End Table  -->
        </div>
            </form>


         <!-- Le modal pour ajouter -->
        <div class="modal fade" id="modalAjoutPayement" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header text-center">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <div class="modal-body">

                <div class="d-flex justify-content-center py-4">
                  <a href="#" class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/yetemali.jpg" alt="">
                    <span class="d-none d-lg-block text-success">Yete</span>
                    <span class="d-none d-lg-block text-warning">mali</span>
                  </a>
                </div>
                <!-- General Form Elements -->

                      <!-- Partie de l'ajout -->
                    <div class="card rounded-4">
                      <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Nouveau Payement</h1>
                      <div class="card-body">

                        <form method="post" action="{{ route('ajoutPayement') }}">
                            @csrf

                            <div class="row mb-4">
                              <label class="col fs-5 ms-3">Tontine</label>
                              <div class="row">
                                <div class="input-group ms-3">
                                    <input type="text" id="searchTontine" class="form-control border-secondary " placeholder="Rechercher une tontine">
                                    <select name="tontine" id="tontine" class="form-select border-secondary" aria-label="Default select example">
                                        <option value="">Cliquez pour choisir</option>
                                        @foreach ($tontinesC as $tontines )
                                            <option value="{{ $tontines->id }}">{{ $tontines->nomTontineC.' ('.$tontines->codeTontineC.')' }}</option>
                                        @endforeach

                                    </select>
                                </div>

                              </div>

                            </div>
                              <div class="row mb-4">
                                  <label class="col fs-5 ms-3">Membre</label>
                                  <div class="row">
                                        <div class="ms-3 input-group" id="inputMembre">
                                            <input type="text" id="searchMembre" class="form-control border-secondary" placeholder="Rechercher un menbre" >
                                            <select name="membre" id="membre" class="form-select border-secondary" aria-label="Default select example">
                                                <option value="" selected>Choisissez la tontine ci-haut</option>


                                            </select>
                                        </div>

                                  </div>
                              </div>

                                <div class="row mb-4">

                                  <div class="col ms-3" style="margin-right: 10px">
                                    <label for="inputDate" class="  text-center fs-5">Date</label>
                                    <input name="date" id="date"  type="date" class="form-control border-secondary">

                                  </div>
                                </div>



                              <div class="row mb-4">
                                  <div class="col"></div>
                                  <div class="col">

                                    <button name="btnValider" type="submit" class="btn btn-success form-control">Valider</button>
                                  </div>
                                  <div class="col">
                                  <button id="annullee" type="button" class="btn btn-danger form-control">Annullee</button>
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
                            <!-- Fin Modal pour ajouter -->
</main>
<!-- <! Fin du main -- -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {


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

        // Écouteurs d'événements pour les champs de recherche
        $('#searchTontine').on('input', function () {
            updateSelectOptions($(this), $('select[name="tontine"]'));
        });

        $('#searchMembre').on('input', function () {
            updateSelectOptions($(this), $('select[name="membre"]'));
        });

        $('#membre').prop('disabled', true);
        $('#searchMembre').prop('disabled', true);

        // Action pour recuperer les membres associes a la tontine selectionner
        $('#tontine').change(function (e) {
            e.preventDefault();
            var tontineId = $(this).val();

            $.ajax({
                type: "POST",
                url: "{{ route('membreTontine') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    tontine: tontineId
                },

                success: function (response) {
                    $('#membre').prop('disabled', false);
                     $('#searchMembre').prop('disabled', false);
                    $('#membre').empty();

                    $('#membre').append($('<option>', {
                        value: '',
                        text: 'Cliquez pour choisir'
                    }));

                    response.participations.forEach(function(participation) {
                        var membre = participation.membres;
                        $('#membre').append($('<option>', {
                            value: membre.id,
                            text: membre.nomMembre + ' ' + membre.prenomMembre + ' (' + membre.codeMembre + ')'
                        }));
                    });
                }
            });
        });

        // Changement de la periode
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
                case 'mois' :
                     $('#date2').prop('disabled', true);
                     $('#date1').prop('disabled', true);
                     break;
                case 'annee' :
                    $('#date2').prop('disabled', true);
                    $('#date1').prop('disabled', true);
                    $('#mois').prop('disabled', true);
                    break;
                default:
                    $('#date2').prop('disabled', false);
                    $('#annee').prop('disabled', false);
                    $('#mois').prop('disabled', false);
                    $('#date1').prop('disabled', false);
                    break;


            }
       });

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
<!-- End #main -->


