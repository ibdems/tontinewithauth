@extends('master.layout')
@section('content')
<main class="main" id="main">
  <div class="pagetitle">
    <h1>Nouvelle Agence</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('acceuil')}}">Accueil</a></li>
        <li class="breadcrumb-item">Agence</li>
        <li class="breadcrumb-item active">Nouvelle</li>
      </ol>
    </nav>
  </div>
  <div class="row mb-4">
    <div class="col"></div>
    <div class="col"></div>
    <div class="col"></div>
    <div class="col">
        <a href="{{ route('afficherAgence') }}">
            <button name="afficher" type="submit" class="btn btn-success">Afficher</button>
        </a>
    </div>
  </div>
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 mt-3">
            <div class="row">
                <div class="col">
                     @if(Session::has('success'))
                            <div class="alert alert-success text-center fw-bold">{{Session::get("success")}}</div>
                        @endif
                </div>
            </div>
          <div class="card mt-2 rounded-4">
            <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Nouvelle agence</h1>
            <div class="card-body">

              <!-- General Form Elements -->
              <form method="Post" action="{{ route('storeAgence') }}">
                @csrf
                    <div class="row mb-4">
                    <label class="col-sm-4  text-center fs-5">Agence</label>
                    <div class="col-sm-6">
                        <input name="nomAgence" id="nomAgence" type="text" class="form-control border-secondary">
                    </div>
                    <div class="col-sm-2"></div>
                        @error('nomAgence')
                            <span class="text-center text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                  <div class="row mb-4">
                      <label class="col-sm-4  text-center fs-5">Adresse</label>
                      <div class="col-sm-6">
                       <input name="adresseAgence" id="adresseAgence" type="text" class="form-control border-secondary">
                      </div>
                      <div class="col-sm-2"></div>
                      @error('adresseAgence')
                            <span class="text-center text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="row mb-4">
                    <label class="col-sm-4  text-center fs-5">Telephone</label>
                    <div class="col-sm-6">
                     <input name="telAgence" id="telAgence" type="tel" class="form-control border-secondary">
                    </div>
                    <div class="col-sm-2"></div>
                    @error('telAgence')
                            <span class="text-center text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="row mb-4">
                    <label class="col-sm-4  text-center fs-5">Mail</label>
                    <div class="col-sm-6">
                     <input name="mailAgence" id="mailAgence" type="mail" class="form-control border-secondary">
                    </div>
                    <div class="col-sm-2"></div>
                    @error('mailAgence')
                            <span class="text-center text-danger">{{ $message }}</span>
                      @enderror
                  </div>

                  <div class="row mb-4">
                    <div class="col"></div>
                    <div class="col">
                      <button type="submit" name="btnValiderAgence" class="btn btn-success form-control">Valider</button>
                    </div>
                    <div class="col">
                      <button type="button" id="btnAnnulerAgence" class="btn btn-secondary form-control">Annuler</button>
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
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#btnAnnulerAgence').click(function (e) {
            e.preventDefault();
            $('#nomAgence').val("");
            $('#adresseAgence').val("");
            $('#telAgence').val("");
            $('#mailAgence').val("");
        });
    });
</script>
