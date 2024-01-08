@extends('master.layout')
@section('content')
  <main class="main" id="main">
    <div class="pagetitle">
      <h1>Gestion des utilisateurs</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('acceuil') }}">Accueil</a></li>
          <li class="breadcrumb-item">Utilisateurs</li>
          <li class="breadcrumb-item active">Liste</li>
        </ol>
      </nav>
    </div>
        <div class="row">
          <div class=""></div>


              <div class="row">
                   <form action="" class="form-inline bg-light">
                      <div class="row">
                        <div class="col-sm">
                          <select name="" id="" class="form-select border-secondary">
                              <option value="id" selected>Identifiant</option>
                              <option value="username">Username</option>
                              <option value="type">Type</option>
                          </select>
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control border-secondary" placeholder="Saisissez">
                        </div>
                        <div class="col-sm">
                          <button type="button" class="bg-warning-light form-control border-secondary">
                            <i class="bi bi-filter"></i> Filtrer
                          </button>
                        </div>
                        <div class="col-sm">
                          <button type="button" class="bg-warning-light form-control border-secondary">
                            <i class="bi bi-repeat"></i> Actualiser
                          </button>
                        </div>
                        <div class="col-sm">
                          <button type="button" class="bg-warning-light form-control border-secondary"  data-bs-toggle="modal" data-bs-target="#modalAjoutUtilisateur">
                            <i class="bi bi-plus"></i> Ajouter
                          </button>
                        </div>
                        <div class="col-sm">
                          <button type="button" id="btnPrintAgent" class="bg-warning-light form-control border-secondary">
                            <i class="bi bi-printer"></i> Imprimer
                          </button>
                        </div>
                      </div>
                    </form>
             </div>
              <div class="row mt-5">
                    <!-- Table -->
                    <table id="tableUser" class="table table-bordered table-responsive text-center table-compressed table-hover table-striped">
                        <thead class="bg-success">
                        <tr class="bg-success">
                                <th class="text-center bg-success text-white">N°</th>
                                <th class="text-center bg-success text-white">Identifiant</th>
                                <th class="text-center bg-success text-white">Photo</th>
                                <th class="text-center bg-success text-white">Nom</th>
                                <th class="text-center bg-success text-white">Prenom</th>
                                <th class="text-center bg-success text-white">Email</th>
                                <th class="text-center bg-success text-white">Adresse</th>
                                <th class="text-center bg-success text-white">Telephone</th>
                                <th class="text-center bg-success text-white">Date</th>
                                <th class="text-center bg-success text-white">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            @php
                                $i = 1;
                            @endphp
                                @if ($user->role == 'admin')
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->admins->codeAdmin }}</td>
                                        <td><img src="{{asset('app/public/'. $user->admins->photoAdmin)}}" height="30" width="30" alt="" class="fa-photo rounded-circle"></td>
                                        <td>{{ $user->admins->nomAdmin }}</td>
                                        <td>{{ $user->admins->prenomAdmin }}</td>
                                        <td>{{ $user->admins->mailAdmin }}</td>
                                        <td>{{ $user->admins->adresseAdmin }}</td>
                                        <td>{{ $user->admins->telAdmin }}</td>
                                        <td>{{ $user->admins->dateAdhesion }}</td>
                                        <td>Administrateur</td>

                                    </tr>
                                @elseif ($user->role == 'delegue')
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{ $user->delegues->codeDelegue }}</td>
                                        <td><img src="{{asset('app/public/'. $user->delegues->photoDelegue)}}" height="30" width="30" alt="" class="fa-photo rounded-circle"></td>
                                        <td>{{ $user->delegues->nomDelegue }}</td>
                                        <td>{{ $user->delegues->prenomDelegue }}</td>
                                        <td>{{ $user->delegues->mailDelegue }}</td>
                                        <td>{{ $user->delegues->adresseDelegue }}</td>
                                        <td>{{ $user->delegues->telDelegue }}</td>
                                        <td>{{ $user->delegues->dateAdhesion }}</td>
                                        <td>Delegué</td>

                                    </tr>
                                @elseif ($user->role == 'agent')
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->agents->codeAgent }}</td>
                                        <td><img src="{{asset('app/public/'. $user->agents->photoAgent)}}" height="30" width="30" alt="" class="fa-photo rounded-circle"></td>
                                        <td>{{ $user->agents->nomAgent }}</td>
                                        <td>{{ $user->agents->prenomAgent }}</td>
                                        <td>{{ $user->agents->mailAgent }}</td>
                                        <td>{{ $user->agents->adresseAgent }}</td>
                                        <td>{{ $user->agents->telAgent }}</td>
                                        <td>{{ $user->agents->dateAdhesion }}</td>
                                        <td>Agent</td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                        <!-- End Table  -->


                    <!-- Debut modal pour Modification -->
              {{-- <div class="modal fade" id="modalModifAgent" tabindex="-1">
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

                            <form method="post" action="" enctype="multipart/form-data">
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

              <div class="modal fade" id="modalModifDelegue" tabindex="-1">
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

                            <form method="post" action="" enctype="multipart/form-data">
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
              </div> --}}

                      <!-- modal de confirmation de suppression -->
                <div class="modal fade" id="modalSuppressionUtilisateur" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center fw-bold">
                        Voulez-vous vraiment supprimer l'utilisateur?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger">Supprimer</button>
                      </div>
                    </div>
                  </div>
                </div>
                 <!--Fin modal de confirmation de suppression -->
                </div>

          </div>
        </div>
  </main>
@endsection

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var tableAffichageAgent = document.getElementById('tableUser');

        function editerAgent() {
            for (var i = 0; i < tableAffichageAgent.rows.length; i++) {
                tableAffichageAgent.rows[i].onclick = function () {
                    document.getElementById("code").value = this.cells[1].innerHTML;
                    document.getElementById("nom").value = this.cells[3].innerHTML;
                    document.getElementById("prenom").value = this.cells[4].innerHTML;
                    document.getElementById("adresse").value = this.cells[6].innerHTML;
                    document.getElementById("telephone").value = this.cells[7].innerHTML;
                    document.getElementById("mail").value = this.cells[5].innerHTML;
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
                            ${document.getElementById('tableUser').outerHTML}
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
