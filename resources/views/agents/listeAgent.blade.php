@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Liste des Agents</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
        <li class="breadcrumb-item">Agents</li>
        <li class="breadcrumb-item active">Liste</li>
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
                <form action="{{ route('searchAgent') }}" method="POST" class="form-inline bg-light">
                    @csrf
                      <div class="row">
                        <div class="col-sm"><label for="txtRechercheAgentIdentifiant" class="form-label">Effectuez une recherche</label></div>
                        <div class="col-sm"></div>
                        <div class="col-sm"></div>
                        <div class="col-sm"></div>
                      </div>
                      <div class="row">
                          <div class="col-sm">
                          <div class="form-group">
                              <div class="col">
                                  <select name="choix" id="selectRechercheAgentsation" class="form-select">
                                    <option value="" selected>Choissisez une option</option>
                                    <option value="identifiant">Identifiant</option>
                                    <option value="nom">Nom</option>
                                    <option value="prenom">Prenom</option>
                                    <option value="adresse">Adresse</option>
                                    <option value="agence">Agence</option>
                                    <option value="statut">Statut</option>
                                  </select>
                              </div>
                          </div>
                          </div>
                          <div class="col-sm">
                              <div class="form-group">

                              <input name="recherche_element" type="text" class="form-control bi bi-search" id="txtRechercheAgent">
                              </div>
                          </div>
                          <div class="col-sm">
                            <div class="form-group">
                              <div class="col-sm">
                                <button name="filtrer" id="btnSearchAgent" type="submit" class="form-control bg-warning-light text-center">
                                    <i class="bi bi-filter"></i>Filtrer
                                </button>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm">
                          <div class="form-group">
                            <div class="col-sm">
                              <a href="{{ route('listeAgent') }}">
                                <button name="actualiser" type="submit" class="btn form-control bg-warning-light text-center">
                                    <i class="bi bi-repeat"></i>Actualiser
                                </button>
                              </a>
                            </div>
                          </div>
                        </div>
                          <!-- Colonne pour bouton ajouter -->
                          <div class="col-sm ">
                            <div class="form-group">
                                <button id="btnNewAgent" type="button" class="bg-warning-light text-center form-control"  data-bs-toggle="modal" data-bs-target="#modalAjoutAgentsation">
                                  <i class="bi bi-plus"></i> Nouveau
                                  </button>
                            </div>

                          </div>
                          <!-- Fin pour ajouter  -->
                          <div class="col-sm ">
                            <button id="btnPrintAgent" type="button" class="form-control bg-warning-light text-center">
                                <i class="bi bi-printer"></i>Imprimer
                            </button>
                          </div>
                      </div>

                      <div class="row mt-4">
                          <!-- Table -->
                        <table id="tableAffichageAgent" class="table text-center table-bordered table-responsive table-compressed table-hover table-striped">
                            <thead class="bg-success">
                              <tr class="bg-success">
                                    <th class="text-center bg-success text-white">#</th>
                                    <th class="text-center bg-success text-white">Code</th>
                                    <th class="text-center bg-success text-white">Photo</th>
                                    <th class="text-center bg-success text-white">Nom</th>
                                    <th class="text-center bg-success text-white">Prenom</th>
                                    <th class="text-center bg-success text-white">Adreese</th>
                                    <th class="text-center bg-success text-white">Contact</th>
                                    <th class="text-center bg-success text-white">Mail</th>
                                    <th class="text-center bg-success text-white">Date</th>
                                    <th class="text-center bg-success text-white">Agence</th>
                                    <th class="text-center bg-success text-white">Statut</th>
                                    <th class="text-center bg-success text-white noPrint" colspan="2">Action</th>
                              </tr>
                            </thead>
                            <tbody id="tbodyAfficheIdentifiant">
                                <?php $i=1; ?>
                                @foreach ($agents as $agent)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $agent->codeAgent }}</td>
                                        <td><img src="{{asset('app/public/'. $agent->photoAgent)}}" height="30" width="30" alt="" class="fa-photo rounded-circle"></td>
                                        <td>{{ $agent->nomAgent }}</td>
                                        <td>{{ $agent->prenomAgent }}</td>
                                        <td>{{ $agent->adresseAgent }}</td>
                                        <td>{{ $agent->telAgent }}</td>
                                        <td>{{ $agent->mailAgent }}</td>
                                        <td>{{ $agent->dateAdhesion }}</td>
                                        <td>{{ $agent->agences->nomAgence }}</td>
                                        <td>
                                            @if ($agent->statutAgent == 1)
                                                En service
                                            @else
                                                Suspendu
                                            @endif
                                        </td>
                                        <td class='btnCoti noPrint'><a href="$id" class='btn btn-transparent editAgent' data-id='1'  data-bs-toggle='modal' data-bs-target='#modalModifAgent' data-bs-placement='bottom' title='Modifier'><i class='bi bi-pen'></i></a></td>
                                        <td class='btnCoti noPrint'>
                                            @if ($agent->statutAgent == 1)
                                                <a href='#'  class='btn btn-transparent suspendAgent'  data-bs-toggle='modal' data-bs-target='#modalSuspendAgent' data-bs-placement='bottom' title='Suspendre'><i class='bi bi-exclamation-triangle'></i></a>
                                            @else
                                                <a href='#' class='btn btn-transparent reintegreAgent'  data-bs-toggle='modal' data-bs-target='#modalReintegreAgent' data-bs-placement='bottom' title='Reintegrer'><i class='bi bi-check'></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                              <!-- End Table  -->
                      </div>
                </form>


      </div>
      <div class="row mt-5">


        <!-- Le modal pour ajouter -->
            <div class="modal fade" id="modalAjoutAgentsation" tabindex="-1">
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
                        <form method="post" action="{{ route('storeAgent') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">

                                <div class="col">
                                    <label class=" text-center fs-5">Nom</label>
                                    <div class="col">
                                        <input name="nom" id="" type="text" class="form-control border-secondary">
                                    </div>

                                </div>

                                <div class="col">
                                    <label class=" text-center fs-5">Prenom</label>
                                    <input name="prenom" id="" type="text" class="form-control border-secondary">

                                </div>

                            </div>


                            <div class="row mb-3">

                                <div class="col">
                                <label class="  text-center fs-5">Adresse</label>
                                <input name="adresse" id="" type="text" class="form-control border-secondary">

                                </div>

                                <div class="col">
                                    <label class=" text-center fs-5">Telephone</label>
                                    <input name="telephone" id="" type="tel" class="form-control border-secondary">

                                </div>

                            </div>



                            <div class="row mb-3">

                                <div class="col">
                                <label class=" text-center fs-5">Date d'inscription</label>
                                <input name="date" id="" type="date" class="form-control border-secondary">

                                </div>

                                <div class="col">
                                    <label for="" class=" text-center fs-5">Photo</label>
                                    <input type="file" id="" name="photo"  accept=".jpg, .png" class="form-control border-secondary">

                                </div>

                            </div>

                            <div class="row mb-3">
                            <div class="col">
                                <label class=" fs-5">Email</label>
                                <input name="mail" id="" type="mail" class="form-control border-secondary">

                            </div>

                            <div class="col">
                                <label class=" fs-5">Mot de Pass</label>
                                <input name="password" id="" type="password" class="form-control border-secondary">

                            </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col"></div>
                                <div class="col">
                                    <button name="ajouter" type="submit" class="btn btn-success" style="width: 100%;">Valider</button>
                                </div>
                                <div class="col">
                                    <button id="annuller" type="button" class="btn btn-secondary" style="width: 100%;">Annuler</button>
                                </div>
                                <div class="col"></div>
                            </div>

                        </form><!-- End General Form Elements -->
                    </div>

                    </div>
                </div>
            </div>
                <!-- Fin Modal pour ajouter -->


              <!-- Debut modal pour Modification -->
              <div class="modal fade" id="modalModifAgent" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header text-center">

                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <div class="d-flex justify-content-center">
                        <a href="#" class="logo d-flex align-items-center w-auto">
                          <img src="{{ asset('assets/img/yetemali.jpg') }} "alt="">
                          <span class="d-none d-lg-block text-success">Yete</span>
                          <span class="d-none d-lg-block text-warning">mali</span>
                        </a>
                      </div>
                      <!-- General Form Elements -->

                            <!-- Partie de l'ajout -->
                          <div class="card rounded-4">
                            <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Modification</h1>
                            <div class="card-body">

                            <form method="post" action="{{ route('updateAgent') }}" enctype="multipart/form-data">
                                @csrf
                                    <input type="hidden" id="code" name="code">
                                    <div class="row">


                                      <div class="col">
                                          <label class=" text-center fs-5">Nom</label>
                                          <div class="col">
                                            <input name="nom" id="nom" type="text" class="form-control border-secondary">
                                          </div>
                                      </div>

                                      <div class="col">
                                        <label class=" text-center fs-5">Prenom</label>
                                        <input name="prenom" id="prenom" type="text" class="form-control border-secondary">
                                      </div>


                                    </div>


                                    <div class="row mb-3">

                                        <div class="col">
                                          <label class="  text-center fs-5">Adresse</label>
                                          <input name="adresse" id="adresse" type="text" class="form-control border-secondary">
                                        </div>

                                        <div class="col">
                                            <label class=" text-center fs-5">Telephone</label>
                                            <input name="telephone" id="telephone" type="number" class="form-control border-secondary">
                                        </div>

                                    </div>



                                    <div class="row mb-3">

                                        <div class="col">
                                            <label class=" text-center fs-5">Date d'inscription</label>
                                            <input name="date" id="date" type="date" class="form-control border-secondary">

                                        </div>

                                        <div class="col">
                                            <label for="" class=" text-center fs-5">Photo</label>
                                            <input type="file" name="photo" accept=".jpg, .png" class="form-control border-secondary">
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class=" fs-5">Email</label>
                                            <input name="mail" id="mail" type="mail" class="form-control border-secondary">
                                        </div>

                                        <div class="col">
                                            <label class=" fs-5">Mot de Pass</label>
                                            <input name="password" id="password" type="password" class="form-control border-secondary">
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                      <button name ="modifier" type="submit" class="btn btn-success boutton">Modifier</button>
                                      <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                                    </div>

                                  </form><!-- End General Form Elements -->

                            </div>
                          </div>


                    </div>

                </div>
              </div>




      </div>

      {{-- Debut du modal pour la suspension de l'agent --}}
    <div class="modal fade" id="modalReintegreAgent" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('reintgrerAgent') }}" method="post">
                    @csrf
                    <div class="modal-body text-center fw-bold">
                            <input type="hidden" name="codeReintegreAgent" id="codeReintegreAgent">
                            Voulez-vous vraiment faire reintegrer cet agent?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Reintegrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Fin du modal pour la suspension de l'agent --}}

    {{-- Debut du modal pour la reintegration de l'agent --}}
    <div class="modal fade" id="modalSuspendAgent" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('suspendAgent') }}" method="post">
                    @csrf
                    <div class="modal-body text-center fw-bold">
                            <input type="hidden" name="codeAgentSuspend" id="codeIdSuspendAgent">
                            Voulez-vous vraiment suspendre cet agent?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Suspendre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- Fin du main -->
@endsection

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var tableAffichageAgent = document.getElementById('tableAffichageAgent');

        function editerAgent() {
            for (var i = 0; i < tableAffichageAgent.rows.length; i++) {
                tableAffichageAgent.rows[i].onclick = function () {
                    document.getElementById("code").value = this.cells[1].innerHTML;
                    document.getElementById("nom").value = this.cells[3].innerHTML;
                    document.getElementById("prenom").value = this.cells[4].innerHTML;
                    document.getElementById("adresse").value = this.cells[5].innerHTML;
                    document.getElementById("telephone").value = this.cells[6].innerHTML;
                    document.getElementById("mail").value = this.cells[7].innerHTML;
                    document.getElementById("date").value = this.cells[8].innerHTML;
                    document.getElementById("photo").value = ''; // Réinitialiser le champ de fichier
                    var photoPath = this.cells[2].getElementsByTagName("img")[0].src;
                    document.getElementById("photo").value = photoPath;

                    // Sélectionner la valeur dans le champ de sélection "mMembre"
                        var membreText = this.cells[9].innerHTML; // Contenu de la cellule "Membre"
                        var selectMembre = document.getElementById("agence");

                            // Parcourir les options du champ de sélection et sélectionner la correspondante
                            for (var j = 0; j < selectMembre.options.length; j++) {
                                if (selectMembre.options[j].text === membreText) {
                                    selectMembre.selectedIndex = j;
                                    break; // Sortir de la boucle dès que la correspondance est trouvée
                                }
                            }
                };
            }
        }

        function suspendAgent() {
            for (var i = 0; i < tableAffichageAgent.rows.length; i++) {
                tableAffichageAgent.rows[i].onclick = function () {
                    document.getElementById("codeIdSuspendAgent").value = this.cells[1].innerHTML;
                };
            }
        }

        function reintegreAgent() {
            for (var i = 0; i < tableAffichageAgent.rows.length; i++) {
                tableAffichageAgent.rows[i].onclick = function () {
                    document.getElementById("codeReintegreAgent").value = this.cells[1].innerHTML;
                };
            }
        }

      $('.editAgent').click(function (e) {
          e.preventDefault();
          editerAgent();
      });

      $('.suspendAgent').click(function (e) {
        e.preventDefault();
        suspendAgent();
      });

      $('.reintegreAgent').click(function (e) {
        e.preventDefault();
        reintegreAgent();
      });




        $('#btnPrintAgent').click(function (e) {
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
                                margin-right: 40px;
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
                            ${document.getElementById('tableAffichageAgent').outerHTML}
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


