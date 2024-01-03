@extends('master.layout')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Tontine Individuelle</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="../../index.php">Acceuil</a>
          </li>
          <li class="breadcrumb-item active"> Liste des tontines individuelle en cours</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <!-- Contenue de la page -->
    <div class="container">
        <div class="row">
            <div class="col">
              <div class="col messages">
                  @if(Session::has('success'))
                      <div class="alert alert-success text-center fw-bold fs-24">
                          {{ Session::get('success') }}
                      </div>
                  @endif

                  @if(Session::has('error'))
                      <div class="alert alert-danger text-center">
                          {{ Session::get('error') }}
                      </div>
                  @endif

                  @if($errors->any())
                      <div class="alert alert-danger text-center">
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
        <form action="{{ route('searchTontine') }}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    <select name="choix" id="sldTontineCours" class="form-select border-secondary">
                        <option value="" selected>Choisissez l'option</option>
                        <option value="identifiant">Identifiant</option>
                        <option value="nom">nom</option>
                        <option value="montant">Montant</option>
                        <option value="membre">Membre</option>
                        <option value="agent">Agent</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" name="txtRecherche" class="form-control border-secondary">
                </div>
                <div class="col">
                    <button type="submit" class="form-control border-secondary bg-warning-light">
                    <i class="bi bi-filter"></i>Filtrer
                    </button>
                </div>
                <div class="col">
                    <a href="{{ route('listeTontineInd') }}">
                        <button type="submit" class="form-control border-secondary bg-warning-light">
                            <i class="bi bi-arrow-repeat"></i>Actualiser
                        </button>
                    </a>
                </div>
                <div class="col">
                    <button type="button" class="form-control border-secondary bg-warning-light"data-bs-toggle="modal" data-bs-target="#modalAjoutTontine">
                    <i class="bi bi-plus"></i>Nouveau
                    </button>
                </div>
                <div class="col">
                    <button type="button" id="btnPrint" class="form-control border-secondary bg-warning-light">
                    <i class="bi bi-printer"></i>Imprimer
                    </button>
                </div>
            </div>

            <!-- Partie du tableau -->
            <div class="row mt-5">
                <table id="tableTontineInd" class="table text-center table-bordered table-responsive table-compressed table-hover table-striped">
                    <thead class="bg-success">
                    <tr class="bg-success">
                            <th class="text-center bg-success text-white">N°</th>
                            <th class="text-center bg-success text-white">Identifiant</th>
                            <th class="text-center bg-success text-white">Nom</th>
                            <th class="text-center bg-success text-white">Date de debut</th>
                            <th class="text-center bg-success text-white">Montant</th>
                            <th class="text-center bg-success text-white">Membre</th>
                            <th class="text-center bg-success text-white">Agent</th>
                            <th class="text-center bg-success text-white noPrint">Voir</th>
                            <th class="text-center bg-success text-white noPrint">Payer</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($tontinesI as $tontine)
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $tontine->codeTontineI }}</td>
                                <td>{{ $tontine->nomTontineI }}</td>
                                <td>{{ $tontine->debutTontineI }}</td>
                                <td>{{ $tontine->montantTontineI }}</td>
                                <td>{{ $tontine->membres->nomMembre.' '.$tontine->membres->prenomMembre }}</td>
                                <td>{{ $tontine->agents->nomAgent.' '.$tontine->agents->prenomAgent }}</td>
                                <td class="btnCoti noPrint">
                                    <a href='#'  class='btn btn-transparent voirTontineI' data-id= {{ $tontine->id }} data-bs-toggle='modal' data-bs-target='#modalvoirTontineI' data-bs-placement='bottom' title='Voir'><i class='bi bi-eye'></i></a>
                                </td>
                                <td style="width: 50px" class="noPrint">
                                    <a href="#" class="btn btn-success payerTontineI" data-id={{ $tontine->id }}  data-bs-toggle='modal' data-bs-target='#modalPayementTontine' data-bs-placement='bottom' title='Payer'>Payer</a>
                                </td>
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
             <!-- General Form Elements -->
             <form method="post" action="{{ route('ajoutTontineInd') }}">
                @csrf

                <div class="row mb-3">
                    <label class="ms-3 fs-5">Agent</label>
                    <div class="input-group">
                          <input type="text" id="searchAgent" class="form-control border-secondary ms-3" placeholder="Recherher l'agent">
                          <select name="agent" id="agent" class="form-select border-secondary" aria-label="Default select example">
                                <option value="">Cliquez pour choisir</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->nomAgent.' '.$agent->prenomAgent }}</option>
                                @endforeach
                          </select>

                    </div>

                </div>

                <div class="row mb-3 mt-4">
                  <label class="fs-5 ms-3">Membre</label>
                  <div class="input-group">
                    <input type="text" id="searchMembre" class="form-control border-secondary ms-3 mr-3" placeholder="Recherhcher le membre">
                    <select name="membre" id="membre" class="form-select border-secondary" aria-label="Default select example">
                        <option value="">Cliquez pour choisir</option>
                        @foreach ($membres as $membre)
                            <option value="{{ $membre->id }}">{{ $membre->nomMembre.' '.$membre->prenomMembre.' ('.$membre->codeMembre.')' }}</option>
                        @endforeach
                    </select>

                  </div>

                </div>

                  <div class="form-group">
                    <div class="row mb-3">
                      <label class=" fs-5 ms-3">Nom</label>
                        <div class="row">
                            <div class="col-12">
                                <input name="nom" id="nom" type="text" class="form-control border-secondary ms-3">
                            </div>

                        </div>

                    </div>


                  </div>

                  <div class="form-group">
                    <div class="row mb-3">
                      <label class="ms-3 fs-5">Debut</label>
                      <div class="row">
                            <div class="col-12">
                                <input name="debut" id="debut" type="date" class="form-control border-secondary ms-3">
                            </div>
                      </div>

                    </div>


                  </div>

                  <div class="form-group">
                    <div class="row mb-3">
                      <label class="ms-3 fs-5">Montant</label>
                      <div class="row">
                        <div class="col-12">
                            <input name="montant" id="montant" type="number" class="form-control border-secondary ms-3">
                        </div>
                      </div>
                    </div>


                  </div>

                  <div class="row mb-3">
                      <div class="col"></div>
                      <div class="col">
                        <button name="btnValider" type="submit" class="btn btn-success form-control">Valider</button>
                      </div>
                      <div class="col">
                        <button name="btnAnulle" id="bntAnnulee" type="button" class="btn btn-danger form-control">Annulée</button>
                      </div>
                      <div class="col"></div>
                  </div>

              </form><!-- End General Form Elements -->
          </div>

        </div>
      </div>
  </div>
    <!-- Fin Modal pour ajouter -->


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

    <!-- Debut Modal pour Voir le suivi -->
    <div class="modal fade" id="modalPayementTontine" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <h3 class="text-center">Payer et cloturer la tontine</h3>
            <form action="{{ route('TontineIndividuelle.payement') }}" method="post">
                @csrf
                <input type="hidden" name="code" id="code" value="">
                <div class="row mb-3">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <input type="date" name="datePayement" id="" class="form-control border-secondary">
                    </div>
                    <div class="col-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Valider</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>


        </div>
        </div>
    </div>
    <!-- Fin modal pour voir suivi -->
</main>
@endsection

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
  $(document).ready(function () {
    var tableTontineInd = document.getElementById('tableTontineInd');

        function editerInfoTontineInd() {
            for (var i = 0; i < tableTontineInd.rows.length; i++) {
                tableTontineInd.rows[i].onclick = function () {
                    document.getElementById("code").value = this.cells[1].innerHTML;
                };
            }
        }

        $('.payerTontineI').click(function (e) {
            e.preventDefault();
            editerInfoTontineInd();
        });

        // Ajoutez cela à l'intérieur de votre fonction ready du document
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
                            ${document.getElementById('tableTontineInd').outerHTML}
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



