@extends('master.layout')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
      <h1>Nouvelle tontine individuelle</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
          <li class="breadcrumb-item">Tontine individuelle</li>
          <li class="breadcrumb-item active">Ajout</li>
        </ol>
      </nav>
  </div>

        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="row mb-3">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
                        <a href="{{ route('listeTontineInd') }}">
                            <button name="afficher" type="submit" class="form-control bg-success text-white">Afficher</button>
                        </a>
                    </div>
                </div>
              <!-- Partie de l'ajout -->
              <div class="card rounded-4">
                <h1 class="card-title rounded-4 text-black fs-3 fw-3 bg-warning-light">Nouvelle tontine individuelle</h1>
                <div class="card-body">

                  <!-- General Form Elements -->
                  <form method="post" action="{{ route('ajoutTontineInd') }}">
                    @csrf
                    <div class="row">
                      <div class="col">
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                        @endif
                      </div>
                    </div>
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
                        @error('agent')
                            <span class= "text-danger">{{ $message }}</span>
                        @enderror
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
                      @error('membre')
                            <span class= "text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                      <div class="form-group">
                        <div class="row mb-3">
                          <label class=" fs-5 ms-3">Nom</label>
                            <div class="row">
                                <div class="col-12">
                                    <input name="nom" id="nom" type="text" class="form-control border-secondary ms-3">
                                </div>
                                @error('nom')
                                    <span class= "text-danger">{{ $message }}</span>
                                @enderror
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
                                @error('debut')
                                    <span class= "text-danger">{{ $message }}</span>
                                @enderror
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
                            @error('montant')
                                <span class= "text-danger">{{ $message }}</span>
                            @enderror
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

            <div class="col-sm-3">
            </div>
          </div>
</main>
@endsection
  <!-- Debut du main -->

  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script>
    $(document).ready(function () {
      $('#bntAnnulee').click(function (e) {
        e.preventDefault();
            $('#nom').val("");
            $('#montant').val("");
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

        $('#searchAgent').on('input', function () {
            updateSelectOptions($(this), $('select[name="agent"]'));
        });

        $('#searchMembre').on('input', function () {
            updateSelectOptions($(this), $('select[name="membre"]'));
        });
    });
  </script>
  <!-- End #main -->


