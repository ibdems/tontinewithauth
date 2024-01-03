@extends('master.layout')
@section('content')
    <!-- Debut du main -->
<main class="main" id="main">
    <div class="pagetitle">
      <h1>Gestion des tontines collectif</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('acceuil')}}">Accueil</a></li>
          <li class="breadcrumb-item">Tontine Collectif</li>
          <li class="breadcrumb-item active">Gestion</li>
        </ol>
      </nav>
    </div>
    <div class="container mt-5">
            <div class="row mb-4">

                <div class="col">
                    <a href="{{ route('ajoutTontine') }}">
                        <button name="afficher" type="submit" class="form-control fs-6 bg-success text-white">Organiser</button>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('listeTontine') }}">
                        <button name="afficher" type="submit" class="form-control fs-6 bg-success text-white">Liste des tontines</button>
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
            <div class="row">
                <div class="col">
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger text-center fw-bold">{{Session::get("error")}}</div>
                    @endif
                </div>
            </div>
            <!-- Choix d'action a faire -->
            <div class="row">
                <div class="col-4">
                    <label for="tontine">Choisissez la tontine a gerer</label>
                    <div class="input-group">
                        <input type="text" id="txtTontine" class="form-control border-secondary" placeholder="Saisissez le nom">
                        <select name="tontine" id="choixTontine" class="form-select border-secondary">
                            <option value="">Cliquer pour choisir</option>
                            @foreach ($tontines as $tontine )
                                <option value="{{ $tontine->id }}">{{ $tontine->nomTontineC }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('tontine')
                        <span class="text-center text-danger">{{ $message }}</span>
                    @enderror
                    <span class="text-danger d-none" id="erreurTontine">Veuillez choisir la tontine</span>
                </div>
                <div class="col">
                    <label for="">Ajouter un membre</label>
                    <button type="button" id="btnAjouter" class="form-control bg-warning-light border-secondary">
                        <i class="bi bi-plus"></i>Ajouter
                    </button>
                </div>
                <div class="col">
                    <label for="">Payer Un membre</label>
                    <button type="button"  id="btnPayement" class="form-control bg-warning-light border-secondary ">
                        <i class="bi bi-list"></i>Payer
                    </button>
                </div>
                <div class="col">
                    <label for="">Liste des Membres</label>
                    <button type="button"  id="btnListe" class="form-control bg-warning-light border-secondary ">
                        <i class="bi bi-list"></i>Liste
                    </button>
                </div>

            </div>

            <div class="row mt-5" id="AjoutMembre">

                    <div class="col-6">
                        <label for="">Choisissez le membre</label>
                        <div class="input-group">
                            <input type="text" id="txtMembre" class="form-control border-secondary" placeholder="Saisissez le nom">
                            <select name="membre" id="choixMembre" class="form-select border-secondary">
                                <option value=" ">Cliquer pour choisir</option>
                                @foreach ($membres as $membre)
                                    <option value="{{ $membre->id }}">{{ $membre->nomMembre.' '.$membre->prenomMembre. ' ('.$membre->codeMembre.')' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger d-none erreurMembre">Veuillez choisir le membre</span>
                    </div>
                    <div class="col-3">
                        <label for="" class="text-white">Assosier</label>
                        <button type="button" id="btnAssocier" class="form-control bg-warning-light border-secondary">
                            Associer
                        </button>
                    </div>
                    <div class="col-3">
                        <label for="" class="text-white">Inviter</label>
                        <button type="button" id="btnInviter" class="form-control bg-warning-light border-secondary">
                            Inviter
                        </button>
                    </div>
            </div>


             <!-- Action pour Payer un membre -->


            <form action="{{ route('payementCollectif') }}" method="post">
                @csrf
                <div class="row mt-5" id="PayementMembre">
                    <input type="hidden" name="tontine" id="tontinePayer" value="">
                    <div class="col-md-6">
                        <label for="" class="form-label">Choisissez le membre</label>
                        <div class="input-group">
                            <input type="text" id="txtMembre" class="form-control border-secondary" placeholder="Saisissez le nom">
                            <select name="membre2" id="choixMembre2" class="form-select border-secondary">
                                <option value="">Cliquer pour choisir</option>

                            </select>
                        </div>
                        @error('membre2')
                            <span class="text-center text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label">Date de Paiement</label>
                        <input type="date" name="date" id="date" class="form-control border-secondary">
                        @error('date')
                            <span class="text-center text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="validation" class="form-label">Valider le paiement</label>
                        <button type="submit" id="btnPayer" class="form-control bg-warning-light border-secondary">
                            Payer
                        </button>
                    </div>
                </div>
            </form>


            <!-- Action sur l'affichage des membres -->
            <section id="listMembre">
                <form action="" method="post">
                   <div class="row">
                        <div class="col-10"></div>
                        <div class="col-2">
                            <div class="col">
                                <button type="button" id="btnPrintMembres" class="form-control border-secondary bg-warning-light">
                                    <i class="bi bi-printer"></i>Imprimer
                                </button>
                            </div>
                        </div>
                   </div>
                    <div class="row mt-2">
                        <table id="tableInfoMembre" class="table table-bordered table-responsive table-compressed table-hover table-striped">
                            <thead class="bg-success">
                            <tr class="bg-success">
                                    <th class="text-center bg-success text-white">N°</th>
                                    <th class="text-center bg-success text-white">Code Membre</th>
                                    <th class="text-center bg-success text-white">Nom et Prenom</th>
                                    <th class="text-center bg-success text-white">Montant</th>
                                    <th class="text-center bg-success text-white">Participations</th>
                                    <th class="text-center bg-success text-white">Total à Verser</th>
                                    <th class="text-center bg-success text-white">Versements</th>
                                    <th class="text-center bg-success text-white">Montant Verser</th>

                                    <th class="text-center bg-success text-white">Reste à Verser</th>
                                    <th class="text-center bg-success text-white">Payement Reçu</th>

                            </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>
                      </div>
                </form>
            </section>

    </div>

  </main>
<!-- Fin du main -->
@endsection

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script>


    $(document).ready(function () {
         $('#AjoutMembre').hide();
         $('#listMembre').hide();
         $('#PayementMembre').hide()
         $('#btnAjouter').prop('disabled', true);
        $('#btnListe').prop('disabled', true);
        $('#btnPayement').prop('disabled', true);

         $('#btnAjouter').click(function (e) {
             e.preventDefault();
             $('#AjoutMembre').show();
             $('#listMembre').hide();
             $('#PayementMembre').hide();
        });

        // Action sur le bouton liste
        $('#btnListe').click(function (e) {
            e.preventDefault();
            $('#AjoutMembre').hide();
            $('#listMembre').show();
            $('#PayementMembre').hide();

            // recuperer l'id de la tontine
            var tontineId = $('#choixTontine').val();
            $.ajax({
                type: "GET",
                url: "{{ route('displayMembreTontineCollective') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    tontineId: tontineId
                },
                success: function (response) {
                    // Recuperer l'ensemble des donnees du controller
                    var participants = response.participant;
                    var versementsParMembre = response.versementsParMembre;
                    var montantTotalAverser = response.montantTotalAverser;
                    var nombreParticipationMembre = response.nombreParticipationMembre;
                    var montantTontine = response.montantTontine;
                    var payer = response.payer;




                   // Sélectionner le tbody du tableau pour y ajouter les données des membres
                    var tbody = $('#tableInfoMembre tbody');
                    tbody.empty(); // Vider le contenu actuel du tableau

                     // Boucler à travers les participants et ajouter chaque membre au tableau
                    for (var i = 0; i < participants.length; i++) {
                        // Afficher les informations du participants
                        var participant = participants[i];
                        var row = `<tr>
                                        <td>${i + 1}</td>
                                        <td>${participant.membres.codeMembre}</td>
                                        <td>${participant.membres.nomMembre} ${participant.membres.prenomMembre}</td>
                                        <td>${montantTontine}</td>`;

                        // Afficher le nombre de participations du membre
                        if (nombreParticipationMembre[i]) {
                            var participation = nombreParticipationMembre[i].nombreParticipations;
                            row += `<td>${participation}</td>
                                    <td>${participation * montantTotalAverser}</td>`;
                        } else {
                            row += `<td>${0}</td>
                                    <td>${0}</td>`; // Si aucun nombre de participations n'est disponible, afficher 0
                        }

                        // Afficher le infors consernant les versements
                        // Vérifier si le participant a des versements
                        if (versementsParMembre[i]) {
                            var montantVerser = versementsParMembre[i].montantTotalVersement;
                            var montantTotalAverserParMembre = (nombreParticipationMembre[i].nombreParticipations) * montantTotalAverser;
                            row += `<td>${versementsParMembre[i].nombreVersements}</td>
                                    <td>${montantVerser}</td>
                                    <td>${montantTotalAverserParMembre - montantVerser}</td>`;
                        } else {
                            // Si aucun versement n'existe pour ce participant, afficher des cellules vides
                            row += `<td>${0}</td>
                                    <td>${0}</td>
                                    <td>${0}</td>`;
                        }

                        // Pour afficher l'etat du payement du membre
                        if(payer[i]){
                            var payementEffectuer = payer[i].nombrePayementMembre;
                            row += `<td>${payementEffectuer}</td>`;
                        }else{
                            row += `<td>${0}</td>`;
                        }

                        // if(payer[i] && nombreParticipationMembre[i]){
                        //     if(payer[i].nombrePayementMembre < nombreParticipationMembre[i].nombreParticipations){
                        //         row += `<td>${'Non terminé'}</td>`;
                        //     } else {
                        //         row += `<td>${'Terminé'}</td>`;
                        //     }
                        // }





                        row += `</tr>`;
                        tbody.append(row); // Ajouter la ligne au tableau
                    }

                },
                error: function(error){
                    consol.log(error);
                }
            });
        });

        $('#btnPayement').click(function (e) {
            e.preventDefault();
            $('#AjoutMembre').hide();
            $('#listMembre').hide();
            $('#PayementMembre').show();
            var tontineId = $('#choixTontine').val();
            $('#tontinePayer').val(tontineId);

        });

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
        $('#txtTontine').on('input', function () {
            updateSelectOptions($(this), $('select[name="tontine"]'));
        });

        $('#txtMembre').on('input', function () {
            updateSelectOptions($(this), $('select[name="membre"]'));
        });
        $('#txtMembre2').on('input', function () {
            updateSelectOptions($(this), $('select[name="membre"]'));
        });



        ////////////// Partie de la gestion des evenement lies a la base de donnees

        $('#btnAssocier').click(function (e) {
            e.preventDefault();
            var tontineId = $('#choixTontine').val();
            var membreId = $('#choixMembre').val();

            if (tontineId === "") {
                $('#erreurTontine').removeClass('d-none').addClass('d-block');
                return; // Arrêter l'exécution du code si la tontine n'est pas sélectionnée
            } else {
                $('#erreurTontine').addClass('d-none').removeClass('d-block');
            }

            if (membreId === " ") {
                $('.erreurMembre').removeClass('d-none').addClass('d-block');
                return; // Arrêter l'exécution du code si le membre n'est pas sélectionné
            } else {
                $('.erreurMembre').addClass('d-none').removeClass('d-block');
            }

            $.ajax({
                type: "POST",
                url: '{{ route('associationTontine') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    tontine: tontineId,
                    membre: membreId,
                },
                success: function (response) {
                    if(response.success){
                        alert(response.success);
                    }else if (response.error){
                        alert(response.error);
                    }else {
                        alert("Une erreur s'est produite")
                    }
                    // Si vous avez besoin de réaliser d'autres actions après avoir associé le membre, vous pouvez les placer ici.
                },
                error: function (xhr, status, error) {
                    // En cas d'échec de la requête Ajax, vous pouvez gérer les erreurs ici
                    alert(error);
                }
            });
        });


        // // La partie pour inviter les membres a rejoindre la tontine
        // $('#btnInviter').click(function (e) {
        //     e.preventDefault();
        //     // var tontineId = $('#choixTontine').val();
        //     // alert(tontineId)
        // });


        // Pour le payement recuperer les membres en fonctions de la tontine choisi
        $('#choixTontine').change(function (e) {
            e.preventDefault();
            var tontineId = $(this).val();

            // Action pour activer les boutons
            if (tontineId !== '') {
                // Activer les boutons lorsque la tontine est sélectionnée
                $('#btnAjouter').prop('disabled', false);
                $('#btnListe').prop('disabled', false);
                $('#btnPayement').prop('disabled', false);
            } else {
                // Désactiver les boutons si aucune tontine n'est sélectionnée
                $('#btnAjouter').prop('disabled', true);
                $('#btnListe').prop('disabled', true);
                $('#btnPayement').prop('disabled', true);
            }

            $.ajax({
                type: "POST",
                url: "{{ route('membreTontine') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    tontine: tontineId
                },

                success: function (response) {

                    $('#choixMembre2').empty();

                    $('#choixMembre2').append($('<option>', {
                        value: '',
                        text: 'Cliquez pour choisir'
                    }));

                    response.participations.forEach(function(participation) {
                        var membre = participation.membres;
                        $('#choixMembre2').append($('<option>', {
                            value: membre.id,
                            text: membre.nomMembre + ' ' + membre.prenomMembre + ' (' + membre.codeMembre + ')'
                        }));
                    });
                }
            });
        });


        // La fonction pour imprimer les membres de la tontine
        $('#btnPrintMembres').click(function (e) {
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
                                <p class="text-center"> Caisse Populaire d'Epargne et Crédit de Guinée (CPECG)</p>
                               Le ${date}
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <h2>${titre}</h2>
                            <!-- Ajoutez ici le logo de l'entreprise -->
                            <!-- Ajoutez ici la date -->
                        </div>
                        <table>
                            ${document.getElementById('tableInfoMembre').outerHTML}
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


