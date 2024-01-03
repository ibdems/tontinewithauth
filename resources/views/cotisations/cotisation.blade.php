@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Nouvelle Cotisation</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
        <li class="breadcrumb-item">Cotisation</li>
        <li class="breadcrumb-item active">Ajout</li>
      </ol>
    </nav>
  </div>
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
          <!-- Partie de l'ajout -->
          <div class="row mb-4">
            <div class="col"></div>
            <div class="col"></div>

            <div class="col">
                <a href="{{ route('afficheCotisation') }}">
                    <button name="afficher" type="submit" class="form-control bg-success text-white">Afficher</button>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('historiqueTontineInd') }}">
                    <button name="afficher" type="submit" class="form-control bg-success text-white">Voir les tontines</button>
                </a>
            </div>

        </div>
          <div class="card rounded-4">
            <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Effectuer une Cotisation</h1>
            <div class="card-body">

            <form method="post" action="{{ route('StoreCotisation') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        @if (Session::has('success'))
                             <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                        @endif
                        @if (Session::has('erreur'))
                             <div class="alert alert-danger text-center fw-bold">{{Session::get("erreur")}}</div>
                        @endif
                  </div>
                </div>

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
                          @error('membre')
                                <span class="text-danger ms-3">{{ $message }}</span>
                            @enderror
                    </div>

                </div>

                <div class="row mb-4">
                  <label class="col fs-5 ms-3">Tontine</label>
                  <div class="row">
                    <div class="input-group ms-3">
                        <input type="text" id="searchTontine" class="form-control border-secondary " placeholder="Rechercher une tontine">
                        <select name="tontine" class="form-select border-secondary" aria-label="Default select example">
                            <option value="" selected>Cliquez pour choisir</option>

                        </select>
                    </div>
                    @error('tontine')
                        <span class="text-danger ms-4">{{ $message }}</span>
                    @enderror
                  </div>

                </div>


                    <div class="row mb-4">

                      <div class="col ms-3" style="margin-right: 10px">
                        <label for="inputDate" class="  text-center fs-5">Date</label>
                        <input name="debut" id="debut"  type="date" class="form-control border-secondary">
                        @error('debut')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

        <div class="col-lg-3">
        </div>
      </div>
</main>
<!-- Fin du main -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
  $(document).ready(function () {
    $('#annullee').click(function (e) {
      $('#debut').val("");
      $('#montant').val("");

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
        $('#searchTontine').on('input', function () {
            updateSelectOptions($(this), $('select[name="tontine"]'));
        });

        $('#searchMembre').on('input', function () {
            updateSelectOptions($(this), $('select[name="membre"]'));
        });

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

  });



</script>

<!-- End #main -->
