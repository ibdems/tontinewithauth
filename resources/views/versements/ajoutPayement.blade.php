@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Nouveau Versement</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
        <li class="breadcrumb-item">Versement</li>
        <li class="breadcrumb-item active">Ajout</li>
      </ol>
    </nav>
  </div>

      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            {{-- Boutton pour afficher la liste --}}
            <div class="row mb-4">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col">
                    <a href="{{ route('gestionTontine') }}">
                        <button name="afficher" type="submit" class="form-control bg-success text-white">Gerer</button>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('listePayement') }}">
                        <button name="afficher" type="submit" class="form-control bg-success text-white">Afficher</button>
                    </a>
                </div>

            </div>
          <!-- Partie de l'ajout -->
          <div class="card rounded-4">
            <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Effectuer un Versement</h1>
            <div class="card-body">

            <form method="post" action="{{ route('ajoutPayement') }}">
                @csrf
                <div class="row">
                    <div class="col">
                        @if (Session::has('success'))
                             <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                        @endif

                        @if(Session::has('error'))
                              <div class="alert text-center alert-danger">
                                  {{ Session::get('error') }}
                              </div>
                          @endif
                  </div>
                </div>
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
                    @error('tontine')
                        <span class="text-danger ms-3">{{ $message }}</span>
                    @enderror
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
                            @error('membre')
                                <span class="text-danger ms-3">{{ $message }}</span>
                            @enderror
                      </div>
                  </div>

                    <div class="row mb-4">

                      <div class="col ms-3" style="margin-right: 10px">
                        <label for="inputDate" class="  text-center fs-5">Date</label>
                        <input name="date" id="date"  type="date" class="form-control border-secondary">
                        @error('date')
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
                      <button id="annullee" type="button" class="btn btn-danger form-control">Annullee</button>
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

        // Desactiver le champ pour la selection de membre
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
  });

</script>

<!-- End #main -->
