@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Nouvelle Tontine Collective</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('acceuil')}}">Accueil</a></li>
        <li class="breadcrumb-item">Tontine Collective</li>
        <li class="breadcrumb-item active">Ajout</li>
      </ol>
    </nav>
  </div>

      <div class="row mt-1">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="row mb-3">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col">
                    <a href="{{ route('gestionTontine') }}">
                        <button name="afficher" type="submit" class="form-control bg-success text-white">Gerer</button>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('listeTontine') }}">
                        <button name="afficher" type="submit" class="form-control bg-success text-white">Afficher</button>
                    </a>
                </div>
            </div>
          <!-- Partie de l'ajout -->
          <div class="card rounded-4 mb-5">
            <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Nouvelle Tontine Collective</h1>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                          @if (Session::has('success'))
                               <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                          @endif
                    </div>
                </div>
              <!-- General Form Elements -->
              <form method="post" action="{{ route('ajoutTontine.store') }}">
                @csrf
                  <div class="form-group">
                    <div class="row">
                      <div class="col"></div>
                      <div class="col">

                      </div>
                      <div class="col"></div>
                    </div>
                    <div class="row mb-4">

                     <div class="row mb-3">
                        <div class="col">
                            <label class="fs-5">Nom</label>
                            <input name="nom" id="nom" type="text" class="form-control border-secondary" placeholder="Nom de la tontine">
                            @error('nom')
                                <span class="text-center text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                     </div>


                      <div class="row mb-3">
                        <div class="col">
                            <label for="inputDate" class="fs-5">Debut</label>
                            <input name="debut" id="debut"  type="date" class="form-control border-secondary">
                            @error('debut')
                                <span class="text-center text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col">
                            <label class="fs-5">Montant</label>
                            <input name="montant" id="montant" type="text" class="form-control border-secondary" placeholder="Montant de la tontine">
                            @error('montant')
                                <span class="text-center text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                        <div class="col">
                            <label for="" class="fs-5">Frequence</label>
                            <select name="frequence" id="frequence" class="form-select border-secondary">
                              <option value="1" selected>Jours</option>
                              <option value="7">Semaines</option>
                              <option value="30">Mois</option>
                              <option value="12">Annee</option>
                            </select>
                            @error('frequence')
                                <span class="text-center text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                      </div>

                  <div class="row">
                    <div class="col"></div>
                    <div class="col">
                    <button name="ajouter" type="submit" class="btn btn-success form-control">Ajouter</button>
                    </div>
                    <div class="col">
                    <button name="annuler" id="annuller" type="button" class="btn btn-secondary form-control">Annuler</button>
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
<!-- Fin du main -->
@endsection
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#annuller').click(function (e) {
            e.preventDefault();
            $('#nom').val("");
            $('#debut').val("");
            $('#montant').val("");
            $('#participant').val("");
            $('#agent').val(0);

        });
    });
</script>


