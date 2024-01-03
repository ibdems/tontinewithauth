@extends('master.layout')
@section('content')
<!-- Debut du main -->
<main class="main" id="main">
    <div class="pagetitle">
      <h1>Nouveau Membre</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
          <li class="breadcrumb-item">Membre</li>
          <li class="breadcrumb-item active">Nouveau</li>
        </ol>
      </nav>
    </div>

    <div class="container">
        <div class="row">
          <div class="col-2"></div>
          <div class="col-8">
            <div class="card">
                <h1 class="card-title rounded-4 text-center text-black fs-1 fw-3 bg-warning-light">Nouveau Membre</h1> 
                <div class=" card-body">
                    <div class="row mb-4">
                      <div class="col">
                        <label for="">Nom</label>
                        <input type="text" id="nom" name="nomMembre" class="form-control border-secondary">
                      </div>
                      <div class="col">
                          <label for="">Prenom</label>
                          <input type="text" id="prenom" name="prenomMembre" class="form-control border-secondary">
                      </div>
                  </div>

                  <div class="row mb-4">
                      <div class="col">
                        <label for="">Adresse</label>
                        <input type="text" id="adresse" name="adresseMembre" class="form-control border-secondary">
                      </div>
                      <div class="col">
                        <label for="">Contact</label>
                        <input type="text" id="contact" name="telMembre" class="form-control border-secondary">
                      </div>
                  </div>
                  
                  <div class="row mb-4">
                      <div class="col">
                          <label for="">date_Adhesion</label>
                          <input type="date" id="date" name="dateAdhesion" class="form-control border-secondary">
                      </div>
                      <div class="col">
                          <label for="">E-mail</label>
                        <input type="mail" id="mailMembre" name="mailMembre" class="form-control border-secondary">
                      </div>
                  </div>

                  <div class="row mb-4">
                      <div class="col">
                          <label for="">Agent</label>
                          <select name="agent" id="" class="form-control border-secondary"></select>
                      </div>
                      <div class="col">
                          <label for="">Photo</label>
                        <input type="file" id="photo" name="photo" class="form-control border-secondary">
                      </div>
                  </div>

                  <div class="row">
                      <div class="col"></div>
                      <div class="col">
                        <button type="submit" class="bg-success form-control text-center">
                            Ajouter
                        </button>
                      </div>
                      <div class="col">
                        <button type="button" class="bg-danger form-control text-center">
                            Ajouter
                        </button>
                      </div>
                      <div class="col"></div>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-2"></div> 
        </div>
    </div>
</main>
<!-- Fin du main -->
@endsection




